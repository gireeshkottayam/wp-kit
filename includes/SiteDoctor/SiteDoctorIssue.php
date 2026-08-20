<?php
namespace WPKit\SiteDoctor;
if (!defined('ABSPATH')) exit;
final class SiteDoctorIssue {
    public string $id;
    public string $category;
    public string $severity;
    public string $risk;
    public string $title;
    public string $description;
    public string $recommendation;
    public bool $auto_fix;
    public array $context;
    public function __construct(array $data) {
        foreach (['id','category','severity','risk','title','description','recommendation'] as $key) {
            $this->{$key} = (string)($data[$key] ?? '');
        }
        $this->auto_fix = !empty($data['auto_fix']);
        $this->context = is_array($data['context'] ?? null) ? $data['context'] : [];
    }
    public function to_array(): array { return get_object_vars($this); }
}
