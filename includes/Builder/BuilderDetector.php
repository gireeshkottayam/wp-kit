<?php
namespace WPKit\Builder;
if (!defined('ABSPATH')) exit;
final class BuilderDetector {
    public static function detect_site(): array {
        BuilderRegistry::init(); $out=[];
        foreach(array_keys(BuilderRegistry::all()) as $id){ $a=BuilderRegistry::get($id); if($a && $a->is_active()) $out[]=self::normalize($a); }
        usort($out,fn($a,$b)=>$b['confidence']<=>$a['confidence']);
        return $out ?: [self::normalize(BuilderRegistry::get('generic'))];
    }
    public static function detect_post(int $post_id): array {
        $post=get_post($post_id); if(!$post) return [];
        $out=[]; foreach(self::detect_site() as $item){
            if($item['id']==='gutenberg' && function_exists('has_blocks') && has_blocks($post)){ $item['confidence']=100; $out[]=$item; continue; }
            if($item['id']==='generic'){ $out[]=$item; continue; }
            $content=(string)$post->post_content;
            $signals=['elementor'=>'elementor','wpbakery'=>'wpb_','avada'=>'fusion_','divi'=>'et_pb_','bricks'=>'brxe-','breakdance'=>'breakdance'];
            if(isset($signals[$item['id']]) && strpos($content,$signals[$item['id']])!==false){$item['confidence']=min(100,$item['confidence']+10);$out[]=$item;}
        }
        usort($out,fn($a,$b)=>$b['confidence']<=>$a['confidence']); return $out;
    }
    private static function normalize(?BuilderAdapterInterface $a): array {
        if(!$a)return[]; return ['id'=>$a->id(),'name'=>$a->name(),'version'=>$a->version(),'type'=>$a->type(),'edition'=>$a->edition(),'confidence'=>$a->confidence(),'capabilities'=>$a->capabilities()];
    }
}
