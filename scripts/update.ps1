param(
    [string]$WpKitPath = "."
)

Write-Host "Updating WP-KIT..." -ForegroundColor Cyan

if (Test-Path (Join-Path $WpKitPath ".git")) {
    Push-Location $WpKitPath
    git pull
    Pop-Location
    Write-Host "WP-KIT update complete." -ForegroundColor Green
} else {
    Write-Host "The supplied path is not a Git repository." -ForegroundColor Yellow
}
