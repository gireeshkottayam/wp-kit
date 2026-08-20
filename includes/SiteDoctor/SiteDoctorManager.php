<?php
namespace WPKit\SiteDoctor;
if (!defined('ABSPATH')) exit;
final class SiteDoctorManager {
    private static array $scanners=[];
    public static function init(): void {
        self::register_defaults();
        add_action('admin_menu',[self::class,'admin_menu']);
        add_action('wp_ajax_wpkit_site_doctor_scan',[self::class,'ajax_scan']);
    }
    public static function register(SiteDoctorScanner $scanner): void { self::$scanners[$scanner->id()]=$scanner; }
    private static function register_defaults(): void {
        if(self::$scanners) return;
        foreach(['SEOScanner','AISearchScanner','PerformanceScanner','SecurityScanner','AccessibilityScanner','MobileScanner','LinkScanner','ImageScanner','WordPressScanner','LaunchScanner'] as $name){
            $class='WPKit\\SiteDoctor\\Scanners\\'.$name;
            if(class_exists($class)) self::register(new $class());
        }
        do_action('wpkit_site_doctor_register',self::$scanners);
    }
    public static function scan(): array {
        self::register_defaults(); $issues=[];
        foreach(self::$scanners as $scanner){ try{$issues=array_merge($issues,$scanner->scan());}catch(\Throwable $e){$issues[]=new SiteDoctorIssue(['id'=>'scanner-'.$scanner->id(),'category'=>'technical','severity'=>'high','risk'=>'manual_only','title'=>$scanner->label().' scanner failed','description'=>$e->getMessage(),'recommendation'=>'Review the scanner error before relying on the audit.']);} }
        $score=SiteDoctorScore::calculate($issues);
        $result=['timestamp'=>current_time('mysql'),'version'=>WPKIT_BUILDER_AGENT_VERSION,'scores'=>$score,'issues'=>array_map(static fn($i)=>$i->to_array(),$issues)];
        update_option('wpkit_site_doctor_last_scan',$result,false);
        return $result;
    }
    public static function last_scan(): ?array { $data=get_option('wpkit_site_doctor_last_scan',null); return is_array($data)?$data:null; }
    public static function admin_menu(): void { add_management_page('WP Kit Site Doctor','WP Kit Site Doctor','manage_options','wpkit-site-doctor',[self::class,'render']); }
    public static function render(): void {
        if(!current_user_can('manage_options')) wp_die(esc_html__('Permission denied.','wp-kit-builder-agent'));
        $scan=self::last_scan();
        echo '<div class="wrap"><h1>WP Kit Site Doctor</h1><p>Website health, launch-readiness and compatibility audit.</p>';
        echo '<p><button class="button button-primary" id="wpkit-site-doctor-scan">Run Full Scan</button></p><div id="wpkit-site-doctor-result">';
        if($scan) self::render_result($scan); else echo '<p>No scan has been run yet.</p>';
        echo '</div><script>document.addEventListener("DOMContentLoaded",function(){const b=document.getElementById("wpkit-site-doctor-scan");const r=document.getElementById("wpkit-site-doctor-result");if(!b)return;b.addEventListener("click",async()=>{b.disabled=true;b.textContent="Scanning...";const f=new FormData();f.append("action","wpkit_site_doctor_scan");f.append("_ajax_nonce","'.esc_js(wp_create_nonce('wpkit_site_doctor_scan')).'");try{const x=await fetch(ajaxurl,{method:"POST",body:f});const j=await x.json();r.innerHTML=j.success?j.data.html:"<p>Scan failed.</p>";}catch(e){r.innerHTML="<p>Scan failed.</p>";}b.disabled=false;b.textContent="Run Full Scan";});});</script></div>';
    }
    private static function render_result(array $scan): void {
        $s=$scan['scores']; $status=$s['critical']?'NOT READY':($s['ready']?'READY':'READY WITH WARNINGS');
        echo '<div style="max-width:1100px"><h2>Overall Score: '.esc_html($s['overall']).'/100</h2><p><strong>Status: '.esc_html($status).'</strong></p>';
        echo '<table class="widefat striped"><thead><tr><th>Category</th><th>Score</th></tr></thead><tbody>';
        foreach($s['categories'] as $cat=>$score) echo '<tr><td>'.esc_html(ucwords(str_replace('_',' ',$cat))).'</td><td>'.esc_html($score).'/100</td></tr>';
        echo '</tbody></table><h2>Issues ('.count($scan['issues']).')</h2><table class="widefat striped"><thead><tr><th>Severity</th><th>Category</th><th>Issue</th><th>Recommendation</th><th>Risk</th></tr></thead><tbody>';
        foreach($scan['issues'] as $i){echo '<tr><td>'.esc_html(strtoupper($i['severity'])).'</td><td>'.esc_html($i['category']).'</td><td><strong>'.esc_html($i['title']).'</strong><br>'.esc_html($i['description']).'</td><td>'.esc_html($i['recommendation']).'</td><td>'.esc_html($i['risk']).'</td></tr>';}
        echo '</tbody></table><p><small>Last scan: '.esc_html($scan['timestamp']).'</small></p></div>';
    }
    public static function ajax_scan(): void {
        check_ajax_referer('wpkit_site_doctor_scan'); if(!current_user_can('manage_options')) wp_send_json_error(['message'=>'Permission denied'],403);
        $scan=self::scan(); ob_start(); self::render_result($scan); $html=ob_get_clean(); wp_send_json_success(['html'=>$html,'scan'=>$scan]);
    }
}
