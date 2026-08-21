@echo off
setlocal
cd /d "%~dp0"

echo ==========================================
echo   KUNCHEAP - LOCAL SETUP / START
ECHO ==========================================

if not exist .env (
    echo [1/5] Creating .env from .env.example...
    copy /Y .env.example .env >nul
) else (
    echo [1/5] .env already exists - keeping it.
)

if exist "C:\xampp\php\php.exe" (
    set "PHP_BIN=C:\xampp\php\php.exe"
) else (
    set "PHP_BIN=php"
)

if not exist vendor\autoload.php (
    echo [2/5] Installing Composer dependencies...
    where composer >nul 2>nul
    if errorlevel 1 (
        echo.
        echo ERROR: Composer was not found.
        echo Install Composer, then run this file again.
        pause
        exit /b 1
    )
    call composer install
    if errorlevel 1 (
        echo.
        echo ERROR: composer install failed.
        pause
        exit /b 1
    )
) else (
    echo [2/5] Composer dependencies already installed.
)

echo [3/5] Clearing cached Laravel configuration...
"%PHP_BIN%" artisan config:clear
if errorlevel 1 (
    echo.
    echo NOTE: If this says database "shopgame" does not exist, create/import shopgame.sql in phpMyAdmin first.
    pause
    exit /b 1
)

findstr /B /C:"APP_KEY=" .env | findstr /X /C:"APP_KEY=" >nul
if not errorlevel 1 (
    echo [4/5] Generating APP_KEY...
    "%PHP_BIN%" artisan key:generate --force
    if errorlevel 1 (
        pause
        exit /b 1
    )
) else (
    echo [4/5] APP_KEY already exists.
)

echo [5/5] Clearing application caches...
"%PHP_BIN%" artisan optimize:clear
if errorlevel 1 (
    pause
    exit /b 1
)

echo.
echo READY.
echo Before testing forgot-password, open .env and replace:
echo   MAIL_PASSWORD=THAY_MAT_KHAU_EMAIL_O_DAY
echo with your mailbox password.
echo.
echo Make sure MySQL is running and database "shopgame" has been imported from shopgame.sql.
echo.
echo Starting Laravel at http://127.0.0.1:8000
"%PHP_BIN%" artisan serve --host=127.0.0.1 --port=8000

endlocal
