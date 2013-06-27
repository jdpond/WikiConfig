 	@echo off
	setLocal EnableDelayedExpansion
rem	set ExtensionsAddr=ssh://jdpond@gerrit.wikimedia.org:29418/mediawiki
rem	set	SVNExtensionsAddr=svn+ssh://jdpond@svn.wikimedia.org/svnroot/mediawiki/trunk
	set	SVNExtensionsAddr=http://svn.wikimedia.org/svnroot/mediawiki/trunk
	set ExtensionsAddr=https://gerrit.wikimedia.org/r/p/mediawiki

	set ConfigFile=extensions/WikiConfig/Extensions.conf
	set BranchVer=false
	
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
	echo Starting MediaWiki Extension Loader from %ConfigFile% at %time% %date% > ExtensionLoader.log
	set SVN_SSH="C:/Program Files (x86)/PuTTY/plink.exe"
	for /f "eol=# delims=" %%f in (%ConfigFile%) do call :parseit %%f
	pause
goto :EOF

:parseit
	if exist "extensions/%1/.git" (
		if "%BranchVer%" NEQ "false" (
			pushd "extensions/%1"
			echo branching: %BranchVer% >>ExtensionLoader.log
			echo @git checkout -B %BranchVer% remotes/origin/%BranchVer% 
			echo @git checkout -B %BranchVer% remotes/origin/%BranchVer% >>ExtensionLoader.log
			@git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% >>ExtensionLoader.log
			popd
		)
	) else (
		if "%BranchVer%" == "false" (
			set CheckoutStatus=
		) else (
			set CheckoutStatus=-b %BranchVer%
		)
		Echo Adding Submodule %1
		Echo Adding Submodule %1 >>ExtensionLoader.log
		echo @git submodule add  %CheckoutStatus%  --force -- "%ExtensionsAddr%/extensions/%1.git"  "extensions/%1"
		echo @git submodule add  %CheckoutStatus%  --force -- "%ExtensionsAddr%/extensions/%1.git"  "extensions/%1" >>ExtensionLoader.log
		@git submodule add %CheckoutStatus% --force -- "%ExtensionsAddr%/extensions/%1.git" "extensions/%1"
		if exist extensions/%1/.git (
			call :gitreview %1
		)
	)
	if not exist "extensions/%1/.git" (
		mkdir extensions/%1
		echo **** %1 is not in git **** trying svn
		call :trySVN %1
	)		
goto :EOF

:gitreview
	copy "extensions\WikiConfig\commit-msg" ".git\modules\extensions\%1\hooks"extensions\%1\.git\hooks"
	pushd "extensions/%1"
	call :onlyreview
	popd
goto :EOF

:trySVN
	Echo @svn checkout %SVNExtensionsAddr%/extensions/%1 extensions/%1
	@svn checkout %SVNExtensionsAddr%/extensions/%1 extensions/%1
	if exist "extensions/%1/.svn" (
		echo loaded extension %1 with SVN >> ExtensionLoader.log
	) else (
		echo *** Error *** Could not load extension %1
		echo *** Error *** Could not load extension %1 >> ExtensionLoader.log
	)
goto :EOF

:onlyreview
	@git-review -s -r -origin
goto :EOF

:ended