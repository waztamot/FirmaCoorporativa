@echo off

set dirE="C:\SysIT\"
set dirP=
set comd=
set optm=
set optf=
set var=

set dirWinrar1="C:\Program Files\WinRAR\"
set dirWinrar2="C:\Program Files (x86)\WinRAR\"
set dirWinrar3="C:\Archivos de programa\WinRAR\"

set dir7zip1="C:\Program Files\7-Zip\"
set dir7zip2="C:\Program Files (x86)\7-Zip\"
set dir7zip3="C:\Archivos de programa\7-Zip\"

set dirZipGenius1="C:\Program Files\ZipGenius 6\"
set dirZipGenius2="C:\Program Files (x86)\ZipGenius 6\"
set dirZipGenius3="C:\Archivos de programa\ZipGenius 6\"

Title FirmaDigital Tunal

setlocal

if exist %dirZipGenius3%zg.exe (
	set 	ok = 1
	set 	dirP=%dirZipGenius3%
	set		comd=zg -extract
	set		optm=
	set		optf=R1 O0
	goto 	procesar
)

if exist %dirZipGenius2%zg.exe (
	set 	ok = 1
	set 	dirP=%dirZipGenius2%
	set		comd=zg -extract
	set		optm=
	set		optf=R1 O0
	goto 	procesar
)

if exist %dirZipGenius1%zg.exe (
	set 	ok = 1
	set 	dirP=%dirZipGenius1%
	set		comd=zg -extract
	set		optm=
	set		optf=R1 O0
	goto 	procesar
)

if exist %dirWinrar3%UnRAR.exe ( 
	set 	ok = 1
	set 	dirP=%dirWinrar3%
	set		comd=WinRAR x -o+
	set		optm=
	set		optf=
	goto 	procesar
)

if exist %dirWinrar2%UnRAR.exe ( 
	set 	ok = 1
	set 	dirP=%dirWinrar2%
	set		comd=WinRAR x -o+
	set		optm=
	set		optf=
	goto 	procesar
)

if exist %dirWinrar1%UnRAR.exe (
	set 	ok = 1
	set 	dirP=%dirWinrar1%
	set		comd=WinRAR x -o+
	set		optm=
	set		optf=
	goto 	procesar
)

if exist %dir7zip3%7z.exe (
	set 	ok = 1
	set 	dirP=%dir7zip3%
	set		comd=7z x
	set		optm=-yo
	set		optf=
	goto 	procesar
)

if exist %dir7zip2%7z.exe (
	set 	ok = 1
	set 	dirP=%dir7zip2%
	set		comd=7z x
	set		optm=-yo
	set		optf=
	goto 	procesar
)

if exist %dir7zip1%7z.exe (
	set 	ok = 1
	set 	dirP=%dir7zip1%
	set		comd=7z x
	set		optm=-yo
	set		optf=
	goto 	procesar
)
goto error

:procesar
set path=%dirP%;%path%
FOR %%i IN (FirmaDigital*.zip) do (
	%comd% %%~ni.zip %optm%%dirE% %optf%
	echo %comd% %%~ni.zip %optm%%dirE% %optf%
	set var="ok"
)
FOR %%i IN (FirmaDigital*.zip) do (
	del %%~ni.zip
	echo del %%~ni.zip
)
if %var%=="ok" goto fin

:error
echo Error no posee los archivos necesarios
@pause

:fin
REM if %var%=="ok" del ConfigurarFirma.bat
