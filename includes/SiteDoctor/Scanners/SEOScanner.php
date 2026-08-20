<?php
namespace WPKit\SiteDoctor\Scanners;
use WPKit\SiteDoctor\SiteDoctorIssue; use WPKit\SiteDoctor\SiteDoctorScanner;
if (!defined('ABSPATH')) exit;
final class SEOScanner implements SiteDoctorScanner {
 public function id(): string{return 'seo';} public function label(): string{return 'SEO';}
 public function scan(): array{$out=[];$home=home_url('/');$html=$this->fetch($home);if(!$html)return [new SiteDoctorIssue(['id'=>'seo-home-fetch','category'=>'technical','severity'=>'high','risk'=>'manual_only','title'=>'Homepage could not be fetched','description'=>'WP Kit could not retrieve the public homepage for analysis.','recommendation'=>'Check the site URL, SSL, server availability and firewall rules.'])];
  if(!preg_match('/<title[^>]*>(.*?)<\\/title>/is',$html,$m)||trim(wp_strip_all_tags($m[1]))==='')$out[]=$this->i('missing-title','seo','high','safe','Missing homepage title','The homepage has no detectable HTML title.','Add a descriptive, unique title.');
  if(!preg_match('/<meta[^>]+name=["\']description["\'][^>]*content=["\']([^"\']*)/is',$html,$m)||trim($m[1])==='')$out[]=$this->i('missing-description','seo','medium','safe','Missing meta description','The homepage has no detectable meta description.','Add a useful summary of the page.');
  if(!preg_match('/<link[^>]+rel=["\']canonical["\']/is',$html))$out[]=$this->i('missing-canonical','seo','low','safe','Missing canonical link','No canonical link was detected on the homepage.','Configure a canonical URL through the site SEO system.');
  if(!preg_match('/<meta[^>]+name=["\']robots["\'][^>]*content=["\'][^"\']*noindex/i',$html)){} else $out[]=$this->i('homepage-noindex','indexability','critical','manual_only','Homepage is marked noindex','The homepage appears to tell search engines not to index it.','Review the search visibility setting before launch.');
  if(!has_site_icon())$out[]=$this->i('missing-site-icon','technical','low','safe','Site icon is not configured','No WordPress site icon is configured.','Set a favicon/site icon in Customizer or Site Editor.');
  return $out; }
 private function fetch(string $url){$r=wp_safe_remote_get($url,['timeout'=>8,'redirection'=>3]);if(is_wp_error($r)||wp_remote_retrieve_response_code($r)>=400)return '';return wp_remote_retrieve_body($r);}
 private function i($id,$cat,$sev,$risk,$title,$desc,$rec){return new SiteDoctorIssue(['id'=>$id,'category'=>$cat,'severity'=>$sev,'risk'=>$risk,'title'=>$title,'description'=>$desc,'recommendation'=>$rec]);}
}
