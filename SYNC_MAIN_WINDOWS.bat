@echo off
setlocal EnableExtensions
cd /d "%~dp0"

echo ==============================================
echo   KUNCHEAP - DONG BO MAIN VE LOCALHOST

echo   Thu muc: %CD%
echo ==============================================
echo.

where git >nul 2>nul
if errorlevel 1 (
    echo [LOI] May chua co Git hoac Git chua nam trong PATH.
    echo Cai Git for Windows roi mo lai file nay.
    pause
    exit /b 1
)

if not exist artisan (
    echo [LOI] Khong tim thay file artisan trong thu muc hien tai.
    echo Hay dat file nay o thu muc goc Laravel.
    pause
    exit /b 1
)

set "ENV_BACKUP=%TEMP%\kuncheap_env_backup_%RANDOM%.txt"
if exist .env (
    copy /y .env "%ENV_BACKUP%" >nul
    echo [OK] Da sao luu .env tam thoi.
)

if not exist .git (
    echo [1/5] Khoi tao Git cho ban ZIP hien tai...
    git init
    if errorlevel 1 goto :fail
)

for /f "delims=" %%R in ('git remote 2^>nul') do (
    if /I "%%R"=="origin" git remote remove origin >nul 2>nul
)

git remote add origin https://github.com/bdsmfsdkv/web-tu-n-v-.git
if errorlevel 1 goto :fail

echo [2/5] Tai code main moi nhat tu GitHub...
git fetch --depth=1 origin main
if errorlevel 1 goto :fail

echo [3/5] Dong bo source theo origin/main...
git reset --hard origin/main
if errorlevel 1 goto :fail

if exist "%ENV_BACKUP%" (
    copy /y "%ENV_BACKUP%" .env >nul
    del /q "%ENV_BACKUP%" >nul 2>nul
    echo [OK] Da khoi phuc .env cua ban.
)

echo [4/5] Xoa cache Laravel cu...
if exist C:\xampp\php\php.exe (
    C:\xampp\php\php.exe artisan view:clear
    C:\xampp\php\php.exe artisan config:clear
    C:\xampp\php\php.exe artisan cache:clear
) else (
    php artisan view:clear
    php artisan config:clear
    php artisan cache:clear
)

echo [5/5] Hoan tat.
echo.
echo Code local da trung voi GitHub main.
echo Ban co the chay lai: C:\xampp\php\php.exe artisan serve
echo.
pause
exit /b 0

:fail
echo.
echo [LOI] Dong bo that bai. .env cua ban van duoc giu lai.
if exist "%ENV_BACKUP%" (
    copy /y "%ENV_BACKUP%" .env >nul
    del /q "%ENV_BACKUP%" >nul 2>nul
)
pause
exit /b 1
