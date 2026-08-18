Write-Host "WP-KIT Environment Check" -ForegroundColor Cyan

$commands = @("git", "php", "mysql")

foreach ($command in $commands) {
    $result = Get-Command $command -ErrorAction SilentlyContinue
    if ($result) {
        Write-Host "[OK] $command -> $($result.Source)"
    } else {
        Write-Host "[INFO] $command was not found in PATH"
    }
}

Write-Host ""
Write-Host "WP-KIT check complete."
