<?php
if (!defined('MEDIAWIKI')) die();

# Validator
require_once("$IP/extensions/Validator/Validator.php");
$wgImageMagickConvertCommand='C:/Program Files/ImageMagick/convert.exe';

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'standard', 'nostalgia', 'cologneblue', 'monobook':
$wgDefaultSkin = 'vector';  #Must be all lower case
#$wgLogo = "$wgScriptPath/extensions/your135x135.png";
#$wgFavicon = "$wgScriptPath/extensions/favicon.ico";

$wgPageSecurityAllowSysop = true;
$wgShowIPinHeader = false;
#
# Customizations from here down
#
$wgEnableEmail      = true;
$wgEnableUserEmail = true;
$wgEnotifWatchlist = true;
$wgFileExtensions = array('png', 'gif', 'jpg', 'jpeg', 'doc', 'xls', 'pdf', 'ppt', 'pps', 'msg', 'txt', 'rtf', 'dot', 'xlt', 'chm' , 'svg', 'mpp', 'xlsx', 'docx', 'xlsm');
# $wgVerifyMimeType = false;
# $wgStrictFileExtensions = false;

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads       = true;
$wgUseImageResize      = true;
# $wgUseImageMagick = true;
# $wgImageMagickConvertCommand = "/usr/bin/convert";

$wgAllowUserJs = true;
$wgAllowUserCss = true;

# require that users log in to read
# $wgGroupPermissions['*']['read'] = false;

# allow these pages for anonymous users
$wgWhitelistRead = array( 	"Main Page","Special:Userlogin","Special:ConfirmEmail","Special:UserLogout",
							"Special:Invalidateemail","-","MediaWiki:Extraeditbuttons.js",
							"Template:TblStyle","MediaWiki:Common.css","MediaWiki:Common.js",
						);

#Set Default Timezone
$wgLocaltimezone = 'America/New_York';
$oldtz = getenv("TZ");

putenv("TZ=$wgLocaltimezone");
date_default_timezone_set('America/New_York');
# Versions before 1.7.0 used $wgLocalTZoffset as hours.
# After 1.7.0 offset as minutes
$wgLocalTZoffset = date("Z") / 60;
putenv("TZ=$oldtz");

# remove the link to the talk page for non-logged in users
$wgShowIPinHeader = false;

# Permission keys given to users in each group.
# All users are implicitly in the '*' group including anonymous visitors;
# logged-in users are all implicitly in the 'user' group. These will be
# combined with the permissions of all groups that a given user is listed
# in in the user_groups table.

require_once("$IP/extensions/WikiConfig/LockdownSetupPermissions.php");
require_once("$IP/extensions/Lockdown/Lockdown.php");

require_once("$IP/extensions/InputBox/InputBox.php");
require_once("$IP/extensions/NewUserNotif/NewUserNotif.php");

require_once("$IP/extensions/ConditionalShowSection/ConditionalShowSection.php");
#require_once("$IP/extensions/DiscussionThreading/DiscussionThreading.php");
require_once("$IP/extensions/ParserFunctions/ParserFunctions.php");
require_once ("$IP/extensions/StringFunctions/StringFunctions.php");
$wgPFEnableStringFunctions = true;
require_once ("$IP/extensions/StringFunctionsEscaped/StringFunctionsEscaped.php");
require_once("$IP/extensions/NSFileRepo/NSFileRepo.php");

# Semantic Mediawiki 
require_once("$IP/extensions/SemanticMediaWiki/SemanticMediaWiki.php");
require_once("$IP/extensions/WikiConfig/ConfigPoweredBy.php");

# Set up SMW searchable namespaces 
foreach($lockdownSMWSearchable as $taddlinkkey)
	$smwgNamespacesWithSemanticLinks[constant("NS_".strtoupper($taddlinkkey))] = true;

# Set up SMW searchable talk namespaces 
foreach($lockdownSMWSearchable as $taddlinkkey)
	$smwgNamespacesWithSemanticLinks[constant("NS_".strtoupper($taddlinkkey)."_talk")] = true;

# override or add any other namespace searchability
foreach($smwgNamespacesWithSemanticLinksAdd as $taddlinkkey => $taddlink) 
	$smwgNamespacesWithSemanticLinks[$taddlinkkey] = $taddlink;

enableSemantics($_SERVER['SERVER_NAME']);

include_once("$IP/extensions/SemanticForms/SemanticForms.php");

require_once("$IP/extensions/DataTransfer/DataTransfer.php");
require_once("$IP/extensions/HeaderTabs/HeaderTabs.php");
$htUseHistory = true;

$wgEnableParserCache = false;
$wgCachePages = false;

require_once("$IP/extensions/WikiConfig/LockdownConfigurePermissions.php");
