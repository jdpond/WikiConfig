	@echo off
	setlocal
	set ConfigFile=Extensions.conf
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
		pause
		goto :EOF
	)
	echo Starting MediaWiki Extension Loader from %ConfigFile% at %time% %date% > ExtensionLoader.log
	set SVN_SSH="C:/Program Files (x86)/PuTTY/plink.exe"
	for /f "eol=# delims=" %%f in (%ConfigFile%) do call :parseit %%f
	pause
goto :EOF

:parseit
	if not exist %1\.git (
		Echo Cloning %1
		Echo Cloning %1 >>ExtensionLoader.log
		set CheckoutStatus=-n
		if "%BranchVer%" == "false" set CheckoutStatus=
		echo @git clone %CheckoutStatus% ssh://jdpond@gerrit.wikimedia.org:29418/mediawiki/extensions/%1.git
		pause
		echo @git clone %CheckoutStatus% ssh://jdpond@gerrit.wikimedia.org:29418/mediawiki/extensions/%1.git >>ExtensionLoader.log
		@git clone %CheckoutStatus% ssh://jdpond@gerrit.wikimedia.org:29418/mediawiki/extensions/%1.git >>ExtensionLoader.log
		if exist %1\.git (
			call :gitreview %1
			if NOT "%BranchVer%" == "false" (
				pushd %1
				echo branching: %BranchVer% >>ExtensionLoader.log
				echo @git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% 
				echo @git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% >>ExtensionLoader.log
				@git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% >>ExtensionLoader.log
				popd
			)

		) else (
			mkdir %1
			echo **** %1 is not in git **** trying svn
			call :trySVN %1
		)		
	) else (
		if "%BranchVer%" == "false" (
			echo %1 exists
			echo %1\.git already existed, not updating at %time% %date% >> ExtensionLoader.log
		) else (
			pushd %1
			echo branching: %BranchVer% >>ExtensionLoader.log
			echo @git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% 
			echo @git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% >>ExtensionLoader.log
			@git.exe checkout -B %BranchVer% remotes/origin/%BranchVer% >>ExtensionLoader.log
			popd
		)
	)
goto :EOF

:gitreview
	copy "C:\Users\Jack D. Pond\Downloads\Git\commit-msg" %1\.git\hooks
	pushd %1
	call :onlyreview
	popd
goto :EOF

:trySVN
	@svn checkout svn+ssh://jdpond@svn.wikimedia.org/svnroot/mediawiki/trunk/extensions/%1 %1
	if exist %1\.svn (
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