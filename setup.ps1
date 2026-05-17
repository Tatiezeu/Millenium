$nodePath = 'C:\Program Files\nodejs'
$possiblePhp8Paths = @(
    'C:\php8.3',
    'C:\Program Files\PHP\8.3',
    'C:\Program Files (x86)\PHP\8.3'
)
$php8Path = $possiblePhp8Paths | Where-Object { Test-Path "$__\php.exe" } | Select-Object -First 1

if (Test-Path $nodePath) {
    $userPath = [Environment]::GetEnvironmentVariable('PATH','User')
    $pathParts = $userPath -split ';' | ForEach-Object { $_.Trim() } | Where-Object { $_ -ne '' }
    if ($pathParts -notcontains $nodePath) {
        $pathParts += $nodePath
    }
    [Environment]::SetEnvironmentVariable('PATH', ($pathParts -join ';'), 'User')
    Write-Host "Added Node to PATH. Close and reopen PowerShell."
} else {
    Write-Host "Node not found at $nodePath"
}

if ($php8Path) {
    $userPath = [Environment]::GetEnvironmentVariable('PATH','User')
    $pathParts = $userPath -split ';' | ForEach-Object { $_.Trim() } | Where-Object { $_ -ne '' }
    $pathParts = $pathParts | Where-Object { $_ -notmatch '\\xampp\\php' }
    if ($pathParts -notcontains $php8Path) {
        $pathParts = ,$php8Path + $pathParts
    }
    [Environment]::SetEnvironmentVariable('PATH', ($pathParts -join ';'), 'User')
    Write-Host "Set PHP 8.3 PATH to: $php8Path. Close and reopen PowerShell."
} else {
    Write-Host "PHP 8.3 was not found in common install locations."
    Write-Host "Please install PHP 8.3 or update the path in this script."
}

Write-Host "`nNode check:"
& "$nodePath\node.exe" --version
& "$nodePath\npm.cmd" --version

Write-Host "`nPHP check:"
if ($php8Path) {
    & "$php8Path\php.exe" --version
} else {
    & 'C:\xampp\php\php.exe' --version
}