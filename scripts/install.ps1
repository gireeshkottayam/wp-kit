param(
    [Parameter(Mandatory=$true)]
    [string]$ProjectPath
)

$source = Resolve-Path (Join-Path $PSScriptRoot "..")
$destination = Resolve-Path $ProjectPath -ErrorAction Stop

$directories = @("agent", "rules", "workflows", "templates", "scripts", "docs")

foreach ($directory in $directories) {
    $from = Join-Path $source $directory
    $to = Join-Path $destination $directory
    Copy-Item $from $to -Recurse -Force
}

Copy-Item (Join-Path $source "AGENTS.md") (Join-Path $destination "AGENTS.md") -Force

Write-Host "WP-KIT installed into $destination" -ForegroundColor Green
