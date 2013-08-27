#!/bin/bash
# @author Jack D. Pond
# @file
# @ingroup administrative
# @description Script file that adds extensions to mediawiki based on a list
# @param -f configuration file, if not present, defaults to master
# @param -b branch to be used, if not used, defaults to extensions/WikiConfig/Extensions.conf
#       expects a file which contains one line per extension.  Each extension can have an explicit version - but will default to the specified
#       version if not present.
#       @param [extension]:[Version] (lines beginning with # are considered comments)
#       example
#       NSFileRepo:REL1_21

#    export ExtensionsAddr=ssh://jdpond@gerrit.wikimedia.org:29418/mediawiki
#    export    SVNExtensionsAddr=svn+ssh://jdpond@svn.wikimedia.org/svnroot/mediawiki/trunk


trySVN(){
    echo svn checkout "$SVNExtensionsAddr/extensions/$1 extensions/$1"
    svn checkout "$SVNExtensionsAddr/extensions/$1 extensions/$1"
    if [ -f "extensions/$1/.svn" ]; then
        echo loaded extension $1 with SVN >> ExtensionLoader.log
    else
        echo *** Error *** Could not load extension $1
        echo *** Error *** Could not load extension $1 >> "$ThisHomeDir/ExtensionLoader.log"
    fi
}

export	SVNExtensionsAddr=http://svn.wikimedia.org/svnroot/mediawiki/trunk
export	ExtensionsAddr=https://gerrit.wikimedia.org/r/p/mediawiki

export ConfigFile=extensions/WikiConfig/Extensions.conf
export BranchVer=master
export ThisHomeDir=$(pwd)
echo ThisHomeDir: $ThisHomeDir

while getopts ":f::b:" opt; do
    case $opt in
        f)
			export ConfigFile=$OPTARG
            ;;
        b)
            export BranchVer=$OPTARG
            ;;
        \?)
            echo "Invalid option: -$OPTARG" >&2
            exit 1
            ;;
        :)
            echo "Option -$OPTARG requires an argument." >&2
            exit 1
            ;;
    esac
done

if [ ! -f $ConfigFile ]; then
	echo Media Extension File List $ConfigFile does not exist - exiting
	exit 1
fi

echo Starting MediaWiki Extension Loader from $ConfigFile at $(hostname);$(date) > "$ThisHomeDir/ExtensionLoader.log"
while read line; do
	if [ "${line:0:1}" != "#" ] ; then
        export _extension=`echo $line | cut -d: -f1`
        export _version=`echo $line | cut -s -d: -f2`
		[ "$_version" == "" ] && export _version=$BranchVer
		echo Processing Extension: $_extension
		if [ -f "extensions/$_extension/.git" ]; then
			pushd "extensions/$_extension"
			git checkout $_version
			popd
		else
			git clone -n "$ExtensionsAddr/extensions/$_extension.git" "extensions/$_extension" >> "$ThisHomeDir/ExtensionLoader.log"
			if [ -f extensions/$_extension/.git ];then
				pushd "extensions/$_extension"
				echo git checkout -b $_version origin/$_version 
				echo git checkout -b $_version origin/$_version >> "$ThisHomeDir/ExtensionLoader.log"
				git checkout -b $_version origin/$_version >> "$ThisHomeDir/ExtensionLoader.log"
				popd
				echo Adding Submodule $_extension
				echo Adding Submodule $_extension >> "$ThisHomeDir/ExtensionLoader.log"
				echo git submodule add -f "$ExtensionsAddr/extensions/$_extension.git" "extensions/$_extension"
				echo git submodule add -f "$ExtensionsAddr/extensions/$_extension.git" "extensions/$_extension" >> "$ThisHomeDir/ExtensionLoader.log"
				git submodule add --force "$ExtensionsAddr/extensions/$_extension.git" "extensions/$_extension" >> "$ThisHomeDir/ExtensionLoader.log"
				pushd "extensions/$_extension"
				git-review -s -r origin
				popd
			fi
		fi
		if [ ! -f "extensions/$_extension/.git" ]; then
			mkdir extensions/$_extension
			echo **** $_extension is not in git **** trying svn
			trySVN "$_extension" $_version
		fi   		
	fi
done < $ConfigFile
exit 0