<?php
namespace WPKit\SiteDoctor;
if (!defined('ABSPATH')) exit;
final class SiteDoctorScore {
    public static function calculate(array $issues): array {
        $weights=['seo'=>15,'performance'=>15,'security'=>15,'accessibility'=>10,'mobile'=>10,'indexability'=>15,'links'=>5,'images'=>5,'technical'=>5];
        $penalties=['critical'=>35,'high'=>18,'medium'=>8,'low'=>3,'info'=>0];
        $scores=[];
        foreach($weights as $category=>$weight) $scores[$category]=100;
        foreach($issues as $issue){
            $cat=$issue->category;
            if(isset($scores[$cat])) $scores[$cat]=max(0,$scores[$cat]-($penalties[$issue->severity] ?? 0));
        }
        $overall=0; $total=0;
        foreach($weights as $category=>$weight){$overall += $scores[$category]*$weight; $total += $weight;}
        $overall=$total ? (int)round($overall/$total) : 100;
        $critical=false; foreach($issues as $issue){if($issue->severity==='critical'){$critical=true;break;}}
        return ['overall'=>$overall,'categories'=>$scores,'ready'=>$overall>=90&&!$critical,'critical'=>$critical];
    }
}
