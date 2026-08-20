<?php
namespace WPKit\SiteDoctor;
if (!defined('ABSPATH')) exit;
interface SiteDoctorScanner {
    public function id(): string;
    public function label(): string;
    /** @return SiteDoctorIssue[] */
    public function scan(): array;
}
