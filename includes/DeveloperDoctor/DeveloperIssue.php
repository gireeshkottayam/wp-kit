<?php
namespace WPKit\DeveloperDoctor;
if (!defined('ABSPATH')) exit;
final class DeveloperIssue {
    public $data;
    public function __construct(array $data){
        $this->data = array_merge([
            'id'=>'','category'=>'runtime','severity'=>'medium','risk'=>'manual_only','title'=>'','description'=>'','recommendation'=>'','file'=>'','line'=>0,'source'=>'','evidence'=>''
        ],$data);
    }
    public function to_array(): array { return $this->data; }
}
