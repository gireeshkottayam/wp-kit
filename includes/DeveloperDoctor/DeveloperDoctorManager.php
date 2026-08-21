<?php
namespace WPKit\DeveloperDoctor;
if (!defined('ABSPATH')) exit;
final class DeveloperDoctorManager {
    const OPTION='wpkit_developer_doctor_last_scan';
    const LOG_OPTION='wpkit_developer_doctor_runtime';
    public static function init(): void {
        add_action('admin_menu',[self::class,'admin_menu']);
        add_action('wp_ajax_wpkit_developer_doctor_scan',[self::class,'ajax_scan']);
        add_action('deprecated_hook_run',[self::class,'capture_deprecated_hook'],10,3);
        add_action('doing_it_wrong_run',[self::class,'capture_doing_it_wrong'],10,3);
        register_shutdown_function([self::class,'capture_shutdown']);
    }
    public static function admin_menu(): void {
        add_management_page('WP Kit Developer Doctor','WP Kit Developer Doctor','manage_options','wpkit-developer-doctor',[self::class,'render']);
    }
    private static function redact($text): string {
        $text=(string)$text;
        $patterns=[
            '/(password|passwd|pwd|secret|token|api[_-]?key|authorization)\s*[:=]\s*[\"\']?[^\s,;\"\']+/i',
            '/(Bearer\s+)[A-Za-z0-9._\-]+/i'
        ];
        return preg_replace($patterns,['$1 [REDACTED]','$1[REDACTED]'],$text);
    }
    private static function record(array $entry): void {
        $items=get_option(self::LOG_OPTION,[]); if(!is_array($items))$items=[];
        $items[]=array_merge(['time'=>current_time('mysql')],$entry);
        if(count($items)>50)$items=array_slice($items,-50);
        update_option(self::LOG_OPTION,$items,false);
    }
    public static function capture_deprecated_hook($hook,$version,$replacement=''): void {
        self::record(['type'=>'deprecated_hook','message'=>self::redact($hook),'detail'=>'Deprecated since '.$version.($replacement?' replacement: '.$replacement:'')]);
    }
    public static function capture_doing_it_wrong($function,$message,$version): void {
        self::record(['type'=>'doing_it_wrong','message'=>self::redact($function),'detail'=>self::redact($message).' (since '.$version.')']);
    }
    public static function capture_shutdown(): void {
        $e=error_get_last();
        if(!$e || !in_array($e['type'],[E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR],true)) return;
        self::record(['type'=>'fatal','message'=>self::redact($e['message']),'detail'=>'Fatal error on request','file'=>isset($e['file'])?$e['file']:'','line'=>isset($e['line'])?(int)$e['line']:0]);
    }
    private static function classify_source($file): string {
        $file=(string)$file;
        if(defined('WP_PLUGIN_DIR') && strpos($file,WP_PLUGIN_DIR)!==false) {
            $rel=str_replace(WP_PLUGIN_DIR.'/','',$file); $parts=explode('/',$rel); return 'plugin:'.(isset($parts[0])?$parts[0]:'unknown');
        }
        if(defined('WP_CONTENT_DIR') && strpos($file,WP_CONTENT_DIR.'/themes/')!==false) return 'theme';
        if(defined('ABSPATH') && strpos($file,ABSPATH)!==false) return 'wordpress-core';
        return 'server-or-external';
    }
    private static function parse_debug_log(): array {
        $path=defined('WP_DEBUG_LOG') && is_string(WP_DEBUG_LOG) ? WP_DEBUG_LOG : WP_CONTENT_DIR.'/debug.log';
        if(!is_readable($path)) return [];
        $lines=@file($path,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES); if(!$lines)return [];
        $lines=array_slice($lines,-120); $out=[];
        foreach($lines as $line){
            if(!preg_match('/PHP (Fatal error|Parse error|Warning|Notice|Deprecated)/i',$line)) continue;
            $severity='low'; if(preg_match('/Fatal|Parse/i',$line))$severity='critical'; elseif(preg_match('/Warning/i',$line))$severity='high'; elseif(preg_match('/Deprecated/i',$line))$severity='medium';
            $source='unknown'; if(preg_match('/ in (.+?) on line (\d+)/',$line,$m)){$source=self::classify_source($m[1]);}
            $out[]=new DeveloperIssue(['id'=>'log-'.md5($line),'category'=>'php','severity'=>$severity,'risk'=>$severity==='critical'?'manual_only':'review_required','title'=>'PHP '.ucfirst(strtolower($severity)).' in debug.log','description'=>self::redact($line),'recommendation'=>$severity==='critical'?'Trace the first non-core plugin/theme in the stack trace and reproduce in a staging environment.':'Review the responsible component and update or replace deprecated code.','source'=>$source,'evidence'=>self::redact($line)]);
        }
        return $out;
    }
    private static function environment_issues(): array {
        $issues=[]; $php=PHP_VERSION; $wp=isset($GLOBALS['wp_version'])?$GLOBALS['wp_version']:'';
        if(version_compare($php,'8.0','<')) $issues[]=new DeveloperIssue(['id'=>'php-old','category'=>'environment','severity'=>'high','risk'=>'manual_only','title'=>'PHP runtime is below 8.0','description'=>'The site is running PHP '. $php.'. Modern WordPress development increasingly targets PHP 8+ compatibility.','recommendation'=>'Test the site on a supported PHP 8.x version in staging before upgrading production.']);
        if(defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY){$issues[]=new DeveloperIssue(['id'=>'debug-display','category'=>'environment','severity'=>'high','risk'=>'manual_only','title'=>'WP_DEBUG_DISPLAY is enabled','description'=>'PHP notices and warnings may be exposed to visitors.','recommendation'=>'Use WP_DEBUG_LOG for development and disable on-screen debugging on production.']);}
        if(defined('WP_DEBUG') && WP_DEBUG && !defined('WP_DEBUG_LOG')){$issues[]=new DeveloperIssue(['id'=>'debug-no-log','category'=>'environment','severity'=>'medium','risk'=>'review_required','title'=>'WP_DEBUG is enabled without explicit WP_DEBUG_LOG','description'=>'Debugging may be harder to review across AJAX, REST and cron requests.','recommendation'=>'Enable WP_DEBUG_LOG in development when appropriate.']);}
        if(function_exists('memory_get_limit')){ $mem=ini_get('memory_limit'); if($mem && preg_match('/^(\d+)([MG])$/i',$mem,$m)){ $mb=(int)$m[1]*($m[2]==='G'?1024:1); if($mb<128)$issues[]=new DeveloperIssue(['id'=>'low-memory','category'=>'environment','severity'=>'medium','risk'=>'manual_only','title'=>'Low PHP memory limit','description'=>'PHP memory_limit is '.$mem.'.','recommendation'=>'Review plugin/theme requirements and consider a higher limit in staging.']); }}
        if($wp && version_compare($wp,'6.0','<'))$issues[]=new DeveloperIssue(['id'=>'wp-old','category'=>'environment','severity'=>'medium','risk'=>'manual_only','title'=>'Old WordPress version detected','description'=>'WordPress '.$wp.' is older than this agent\'s baseline.','recommendation'=>'Update WordPress after testing plugins and themes in staging.']);
        return $issues;
    }
    private static function component_issues(): array {
        $issues=[]; $plugins=get_plugins(); $active=(array)get_option('active_plugins',[]); $active=array_map('strtolower',$active);
        foreach($plugins as $file=>$data){ if(!isset($data['Version']))continue; if(strpos(strtolower($data['Version']),'dev')!==false) $issues[]=new DeveloperIssue(['id'=>'dev-plugin-'.md5($file),'category'=>'components','severity'=>'medium','risk'=>'review_required','title'=>'Development/beta plugin detected: '.$data['Name'],'description'=>'Version '.$data['Version'].' may be a development build.','recommendation'=>'Use stable releases in production and keep development builds isolated.','source'=>'plugin:'.$file]); }
        $theme=wp_get_theme(); if($theme && $theme->exists() && $theme->get('Version')==='')$issues[]=new DeveloperIssue(['id'=>'theme-version','category'=>'components','severity'=>'low','risk'=>'review_required','title'=>'Active theme has no detectable version','description'=>'The active theme does not expose a version in its stylesheet header.','recommendation'=>'Ensure the theme has a valid version header for update and compatibility tracking.','source'=>'theme']);
        return $issues;
    }
    public static function scan(): array {
        if(!function_exists('get_plugins')) require_once ABSPATH.'wp-admin/includes/plugin.php';
        $issues=array_merge(self::parse_debug_log(),self::environment_issues(),self::component_issues());
        $runtime=get_option(self::LOG_OPTION,[]); if(is_array($runtime)) foreach(array_slice($runtime,-25) as $r){
            $sev=$r['type']==='fatal'?'critical':($r['type']==='deprecated_hook'?'medium':'low');
            $issues[]=new DeveloperIssue(['id'=>'runtime-'.md5(wp_json_encode($r)),'category'=>'runtime','severity'=>$sev,'risk'=>$sev==='critical'?'manual_only':'review_required','title'=>ucwords(str_replace('_',' ',$r['type'])),'description'=>self::redact(isset($r['message'])?$r['message']:''),'recommendation'=>$sev==='critical'?'Reproduce the failure and inspect the responsible file/component before changing code.':'Review the call site and update deprecated/incorrect usage.','file'=>isset($r['file'])?$r['file']:'','line'=>isset($r['line'])?(int)$r['line']:0]);
        }
        $counts=['critical'=>0,'high'=>0,'medium'=>0,'low'=>0]; foreach($issues as $i){$a=$i->to_array();if(isset($counts[$a['severity']]))$counts[$a['severity']]++;}
        $result=['timestamp'=>current_time('mysql'),'version'=>defined('WPKIT_BUILDER_AGENT_VERSION')?WPKIT_BUILDER_AGENT_VERSION:'','environment'=>['php'=>PHP_VERSION,'wordpress'=>isset($GLOBALS['wp_version'])?$GLOBALS['wp_version']:'','debug'=>defined('WP_DEBUG')&&WP_DEBUG,'debug_log'=>defined('WP_DEBUG_LOG')&&WP_DEBUG_LOG!==false,'theme'=>wp_get_theme()->get('Name')],'counts'=>$counts,'issues'=>array_map(static function($i){return $i->to_array();},$issues)];
        update_option(self::OPTION,$result,false); return $result;
    }
    public static function last_scan(){ $v=get_option(self::OPTION,null); return is_array($v)?$v:null; }
    public static function render(): void {
        if(!current_user_can('manage_options'))wp_die(esc_html__('Permission denied.','wp-kit-builder-agent'));
        $scan=self::last_scan();
        echo '<div class="wrap"><h1>WP Kit Developer Doctor</h1><p>Find runtime failures, PHP deprecations, debug-log errors and environment risks before they become production incidents.</p><p><button class="button button-primary" id="wpkit-devdoc-scan">Run Developer Scan</button> <button class="button" id="wpkit-devdoc-copy">Copy Incident Bundle</button></p><div id="wpkit-devdoc-result">';
        if($scan)self::render_result($scan);else echo '<p>No developer scan has been run yet.</p>';
        echo '</div><script>document.addEventListener("DOMContentLoaded",function(){const b=document.getElementById("wpkit-devdoc-scan"),r=document.getElementById("wpkit-devdoc-result"),c=document.getElementById("wpkit-devdoc-copy");if(b)b.onclick=async()=>{b.disabled=true;b.textContent="Scanning...";const f=new FormData();f.append("action","wpkit_developer_doctor_scan");f.append("_ajax_nonce","'.esc_js(wp_create_nonce('wpkit_developer_doctor_scan')).'");try{const x=await fetch(ajaxurl,{method:"POST",body:f}),j=await x.json();r.innerHTML=j.success?j.data.html:"<p>Scan failed.</p>";}catch(e){r.innerHTML="<p>Scan failed.</p>";}b.disabled=false;b.textContent="Run Developer Scan";};if(c)c.onclick=()=>{const text=r.innerText||"";navigator.clipboard&&navigator.clipboard.writeText(text);c.textContent="Copied";setTimeout(()=>c.textContent="Copy Incident Bundle",1500);};});</script></div>';
    }
    private static function render_result(array $s): void {
        echo '<h2>Developer Health</h2><p><strong>Critical:</strong> '.esc_html($s['counts']['critical']).' &nbsp; <strong>High:</strong> '.esc_html($s['counts']['high']).' &nbsp; <strong>Medium:</strong> '.esc_html($s['counts']['medium']).' &nbsp; <strong>Low:</strong> '.esc_html($s['counts']['low']).'</p>';
        echo '<p>PHP '.esc_html($s['environment']['php']).' · WordPress '.esc_html($s['environment']['wordpress']).' · Theme '.esc_html($s['environment']['theme']).'</p>';
        echo '<table class="widefat striped"><thead><tr><th>Severity</th><th>Category</th><th>Issue</th><th>Source</th><th>Recommendation</th></tr></thead><tbody>';
        foreach($s['issues'] as $i){echo '<tr><td>'.esc_html(strtoupper($i['severity'])).'</td><td>'.esc_html($i['category']).'</td><td><strong>'.esc_html($i['title']).'</strong><br>'.esc_html($i['description']).'</td><td>'.esc_html($i['source']).'</td><td>'.esc_html($i['recommendation']).'</td></tr>';}
        echo '</tbody></table><p><small>Last scan: '.esc_html($s['timestamp']).'</small></p>';
    }
    public static function ajax_scan(): void { check_ajax_referer('wpkit_developer_doctor_scan'); if(!current_user_can('manage_options'))wp_send_json_error(['message'=>'Permission denied'],403);$scan=self::scan();ob_start();self::render_result($scan);$html=ob_get_clean();wp_send_json_success(['html'=>$html,'scan'=>$scan]); }
}
