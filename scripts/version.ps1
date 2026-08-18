$versionFile = Join-Path $PSScriptRoot "..\VERSION"

if (Test-Path $versionFile) {
    (Get-Content $versionFile -Raw).Trim()
} else {
    Write-Error "VERSION file not found."
}
