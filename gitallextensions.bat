 	@echo off
	setLocal EnableDelayedExpansion
rem # @author Jack D. Pond
rem @file
rem @ingroup administrative
rem @description Script file that adds extensions to mediawiki based on a list
rem @param -a Action.Users.list, if not used, defaults to Action.User.list.temp
rem       expects a file which contains one line per extension.  Each extension can have an explicit version - but will default to the specified
rem       version if not present.
rem       @param [extension]:[Version] (lines beginning with # are considered comments)
rem       example
rem       NSFileRepo:REL1_21

rem	set ExtensionsAddr=ssh://jdpond@gerrit.wikimedia.org:29418/mediawiki
rem	set	SVNExtensionsAddr=svn+ssh://jdpond@svn.wikimedia.org/svnroot/mediawiki/trunk
	set	SVNExtensionsAddr=http://svn.wikimedia.org/svnroot/mediawiki/trunk
	set ExtensionsAddr=https://gerrit.wikimedia.org/r/p/mediawiki

	set ConfigFile=extensions/WikiConfig/Extensions.conf
	set BranchVer=master
	set ThisHomeDir=%cd%
	echo ThisHomeDir: %ThisHomeDir%
	
:startloopp
	if "%1"=="" goto loopparams
	if "%1"=="-f" (
		if "%2" NEQ "" (
			set ConfigFile=%2
			shift
		)
		shift
	) else (
		if "%1" == "-b" (
			if "%2" NEQ "" (
				set BranchVer=%2
				shift
			)
			shift
		) else shift
	)
	goto startloopp
:loopparams
	if not exist %ConfigFile% (
		echo Media Extension File List %ConfigFile% does not exist - exiting
		goto :EOF
	)
	echo Starting MediaWiki Extension Loader from %ConfigFile% at %time% %date% > "%ThisHomeDir%/ExtensionLoader.log"
	set SVN_SSH="C:/Program Files (x86)/PuTTY/plink.exe"
	for /f "eol=# delims=" %%f in (%ConfigFile%) do call :parseit %%f
	pause
goto :EOF

:parseit
	For /F "tokens=1* delims=:" %%a IN (%1) DO (
		set extension_name=%%a
		set extension_rev=%%b
	)
	if "!extension_rev!" == "" ( set extension_rev=!BranchVer! )
	echo Processing Extension: !extension_name!
	if exist "extensions/!extension_name!/.git" (
		pushd "extensions/!extension_name!"
		git checkout !extension_rev!
		popd
	) else (
		git clone -n "!ExtensionsAddr!/extensions/!extension_name!.git" "extensions/!extension_name!" >>"!ThisHomeDir!/ExtensionLoader.log"
		if exist extensions/!extension_name!/.git (
			pushd "extensions/!extension_name!"
			echo git checkout -b !extension_rev! origin/!extension_rev! 
			echo git checkout -b !extension_rev! origin/!extension_rev! >>"!ThisHomeDir!/ExtensionLoader.log"
			git checkout -b !extension_rev! origin/!extension_rev! >>"!ThisHomeDir!/ExtensionLoader.log"
			popd
			Echo Adding Submodule !extension_name!
			Echo Adding Submodule !extension_name! >>"!ThisHomeDir!/ExtensionLoader.log
			echo git submodule add --force "!ExtensionsAddr!/extensions/!extension_name!.git" "extensions/!extension_name!"
			echo git submodule add --force "!ExtensionsAddr!/extensions/!extension_name!.git" "extensions/!extension_name!" >>"!ThisHomeDir!/ExtensionLoader.log"
			git submodule add --force "!ExtensionsAddr!/extensions/!extension_name!.git" "extensions/!extension_name!" >>"!ThisHomeDir!/ExtensionLoader.log"
			call :gitreview !extension_name!
		)
	)
	if not exist "extensions/!extension_name!/.git" (
		mkdir extensions/%1
		echo **** %1 is not in git **** trying svn
		call :trySVN %1
	)		
goto :EOF

:gitreview
	copy "extensions/WikiConfig/commit-msg" "extensions/%1/.git/hooks"
	pushd "extensions/%1"
	call :onlyreview
	popd
goto :EOF

:trySVN
	Echo @svn checkout %SVNExtensionsAddr%/extensions/%1 extensions/%1
	svn checkout %SVNExtensionsAddr%/extensions/%1 extensions/%1
	if exist "extensions/%1/.svn" (
		echo loaded extension %1 with SVN >> ExtensionLoader.log
	) else (
		echo *** Error *** Could not load extension %1
		echo *** Error *** Could not load extension %1 >> "%ThisHomeDir%/ExtensionLoader.log"
	)
goto :EOF

:onlyreview
	git-review -s -r -origin
goto :EOF

:ended