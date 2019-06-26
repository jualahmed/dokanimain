<<<<<<< HEAD
@echo off
ECHO "Adding extra environment variables..." >> ..\startup-tasks-log.txt

powershell.exe Set-ExecutionPolicy Unrestricted
powershell.exe .\add-environment-variables.ps1 >> ..\startup-tasks-log.txt 2>>..\startup-tasks-error-log.txt

=======
@echo off
ECHO "Adding extra environment variables..." >> ..\startup-tasks-log.txt

powershell.exe Set-ExecutionPolicy Unrestricted
powershell.exe .\add-environment-variables.ps1 >> ..\startup-tasks-log.txt 2>>..\startup-tasks-error-log.txt

>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
ECHO "Added extra environment variables." >> ..\startup-tasks-log.txt