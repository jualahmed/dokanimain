<<<<<<< HEAD
@echo off
ECHO "Starting PHP installation..." >> ..\startup-tasks-log.txt

md "%~dp0appdata"
cd "%~dp0appdata"
cd ..

reg add "hku\.default\software\microsoft\windows\currentversion\explorer\user shell folders" /v "Local AppData" /t REG_EXPAND_SZ /d "%~dp0appdata" /f
"..\resources\WebPICmdLine\webpicmdline" /Products:PHP53,SQLDriverPHP53IIS /AcceptEula  >> ..\startup-tasks-log.txt 2>>..\startup-tasks-error-log.txt
reg add "hku\.default\software\microsoft\windows\currentversion\explorer\user shell folders" /v "Local AppData" /t REG_EXPAND_SZ /d %%USERPROFILE%%\AppData\Local /f

=======
@echo off
ECHO "Starting PHP installation..." >> ..\startup-tasks-log.txt

md "%~dp0appdata"
cd "%~dp0appdata"
cd ..

reg add "hku\.default\software\microsoft\windows\currentversion\explorer\user shell folders" /v "Local AppData" /t REG_EXPAND_SZ /d "%~dp0appdata" /f
"..\resources\WebPICmdLine\webpicmdline" /Products:PHP53,SQLDriverPHP53IIS /AcceptEula  >> ..\startup-tasks-log.txt 2>>..\startup-tasks-error-log.txt
reg add "hku\.default\software\microsoft\windows\currentversion\explorer\user shell folders" /v "Local AppData" /t REG_EXPAND_SZ /d %%USERPROFILE%%\AppData\Local /f

>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
ECHO "Completed PHP installation." >> ..\startup-tasks-log.txt