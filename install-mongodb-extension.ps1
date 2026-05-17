$phpCmd = Get-Command php -ErrorAction SilentlyContinue
if (-not $phpCmd) {
    Write-Error 'php not found in PATH. Make sure PHP 8.3 is installed and available in PATH.'
    exit 1
}

$phpExe = $phpCmd.Source
$phpDir = Split-Path $phpExe -Parent
$phpIni = (& $phpExe --ini | Select-String 'Loaded Configuration File' | ForEach-Object { $_.ToString().Split(':',2)[1].Trim() })
if (-not $phpIni -or $phpIni -eq '(none)') {
    $phpIni = Join-Path $phpDir 'php.ini'
}

Write-Host "Using PHP: $phpExe"
Write-Host "PHP directory: $phpDir"
Write-Host "php.ini path: $phpIni"

$extDir = $phpDir
$phpIniContent = Get-Content -Path $phpIni -ErrorAction SilentlyContinue
if (-not $phpIniContent) {
    Write-Host 'php.ini file not found. Creating from php.ini-development if available.'
    $devIni = Join-Path $phpDir 'php.ini-development'
    if (-not (Test-Path $devIni)) {
        Write-Error 'php.ini-development not found. Cannot create php.ini.'
        exit 1
    }
    Copy-Item -Path $devIni -Destination $phpIni -Force
    $phpIniContent = Get-Content -Path $phpIni
}

$extDirLine = $phpIniContent | Select-String -Pattern '^\s*extension_dir\s*=.*' | Select-Object -First 1
if ($extDirLine) {
    $extDirPath = $extDirLine.ToString().Split('=',2)[1].Trim().Trim('"')
    if ($extDirPath -eq 'ext') {
        $extDir = $phpDir
    } else {
        $extDir = if ([System.IO.Path]::IsPathRooted($extDirPath)) { $extDirPath } else { Join-Path $phpDir $extDirPath }
    }
}

$extDirFull = Join-Path $extDir ''
Write-Host "Extension directory: $extDirFull"

$version = (& $phpExe -r "echo PHP_VERSION;" )
$version = $version.Trim()
Write-Host "PHP version: $version"

# Candidate extension versions and file names for PHP 8.3 ZTS x64
$extensionVersions = @('2.3.0', '2.4.0', '2.5.0')
$fileCandidates = @(
    'php_mongodb-{0}-8.3-ts-vs16-x64.zip',
    'php_mongodb-{0}-8.3-ts-vs16-x86.zip',
    'php_mongodb-{0}-8.3-nts-vs16-x64.zip',
    'php_mongodb-{0}-8.3-nts-vs16-x86.zip'
)

$tempDir = Join-Path $env:TEMP 'php_mongodb_install'
if (-Not (Test-Path $tempDir)) { New-Item -ItemType Directory -Path $tempDir | Out-Null }

 $localDll = Join-Path $tempDir 'php_mongodb.dll'
if (Test-Path $localDll) {
    Write-Host "Found existing downloaded DLL: $localDll"
    $downloaded = $true
    $downloadPath = $localDll
} else {
    $downloaded = $false
    $downloadPath = ''
}

if (-not $downloaded) {
    foreach ($ver in $extensionVersions) {
        foreach ($candidate in $fileCandidates) {
            $fileName = $candidate -f $ver
            $url = "https://windows.php.net/downloads/pecl/releases/mongodb/$ver/$fileName"
            Write-Host "Trying $url"
            try {
                $downloadPath = Join-Path $tempDir $fileName
                Invoke-WebRequest -Uri $url -OutFile $downloadPath -UseBasicParsing -ErrorAction Stop
                Write-Host "Downloaded $fileName"
                $downloaded = $true
                break
            } catch {
                Remove-Item -Path $downloadPath -ErrorAction SilentlyContinue
            }
        }
        if ($downloaded) { break }
    }
}

if (-not $downloaded) {
    Write-Error 'Could not download a matching MongoDB extension DLL. Please verify the PHP version and architecture.'
    exit 1
}

Write-Host "Extracting extension to $extDirFull"
try {
    if ([System.IO.Path]::GetExtension($downloadPath) -ieq '.dll') {
        $extractedDll = Get-Item -Path $downloadPath
    } else {
        Expand-Archive -Path $downloadPath -DestinationPath $tempDir -Force
        $extractedDll = Get-ChildItem -Path $tempDir -Filter 'php_mongodb.dll' -Recurse | Select-Object -First 1
    }
} catch {
    Write-Error "Failed to prepare php_mongodb.dll from $downloadPath : $_"
    exit 1
}

if (-not $extractedDll) {
    Write-Error 'php_mongodb.dll was not found inside the downloaded archive.'
    exit 1
}

Copy-Item -Path $extractedDll.FullName -Destination (Join-Path $extDirFull 'php_mongodb.dll') -Force
Write-Host "Copied php_mongodb.dll to $extDirFull"

# Enable extension in php.ini
$iniText = Get-Content -Path $phpIni
$hasEnabled = $iniText | Where-Object { $_ -match '^\s*extension\s*=\s*mongodb' }
if (-not $hasEnabled) {
    $iniText += 'extension=mongodb'
    $iniText | Set-Content -Path $phpIni
    Write-Host 'Enabled extension=mongodb in php.ini'
} else {
    Write-Host 'extension=mongodb already enabled in php.ini'
}

Write-Host 'Verifying mongodb extension load:'
& $phpExe -m | Select-String -Pattern 'mongodb' | ForEach-Object { Write-Host $_ }

if ($LASTEXITCODE -eq 0) {
    Write-Host 'MongoDB extension installed and enabled successfully.'
} else {
    Write-Error 'MongoDB extension may not be loaded. Check php.ini and extension_dir settings.'
}
