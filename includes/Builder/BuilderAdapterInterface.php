<?php
namespace WPKit\Builder;
if (!defined('ABSPATH')) exit;
interface BuilderAdapterInterface {
    public function id(): string;
    public function name(): string;
    public function type(): string;
    public function version(): ?string;
    public function edition(): string;
    public function is_active(): bool;
    public function confidence(): int;
    public function capabilities(): array;
    public function supports(string $capability): bool;
    public function get_content(int $post_id);
    public function update_content(int $post_id, $content);
    public function get_metadata(int $post_id): array;
}
