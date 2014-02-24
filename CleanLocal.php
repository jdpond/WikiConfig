<?php
if (!defined('MEDIAWIKI')) die();

$wgRestrictDisplayTitle = false;

#
# Uncomment this to debug
# require_once("$IP/extensions/WikiConfig/debugcode.php");
# $wgShowExceptionDetails= true; // shows the exception details on the screen - good for debugging, but possible security issue


require_once("$IP/extensions/WikiConfig/LockdownSetupVars.php");
/* Semantic MediaWiki requires 10 namespaces starting at the first available.
 * This will move the smw namespaces to start at the namespace below, and will run through this plus 9.
 * Once this has been initialized for this wiki, it should never be changed.  The next available namspace if you want to add
 * more custom namepaces should start at this + 10.  If you're not sure what you're doing with this, LEAVE IT ALONE!
 *
 * If you have already allocated custom namespaces, you should set this value to the first unallocated namespace index
 * Usually you start custom namespaces with 100, so if you've allocated 2 NS, then it would be 104 (Each NS actually takes to indices,
 *     the first for the namespace, the second for the talk of that namespace).
*/
# $smwgNamespaceIndex = 100;

/* Use these values to allocate new custom namespaces using the configuration automation scripts.  Do NOT change the order or do anything but append.
 * MW uses the indexes, so once created, they are unchangeable and will always remain there, even if you change the name of the namespace
*/
$lockdownNameSpaces = array();
$lockdownSMWSearchable = $lockdownNameSpaces;
$lockdownSMWTalkSearchable = $lockdownNameSpaces;
$lockdownApprovedUsersOnlyWiki = true ;
/*
 *$lockdownExtraPrivileges
 *	Designates access to additional user groups for a particular namespace.  In this way, you can allow multiple groups access to a single namespace.
 *  The index value is the namespace and the array indexed are the additional usergroups allowed
*/
#$lockdownExtraPrivileges = array( "ASM" => array("ref"),"REF" => array("asm"));

/* If you wish to have additional namespaces to be enabled for semantic links, or to override the defaults
 * they must be added to this array.
 * NOTE:  by default all namespaces that appear in $lockdownNameSpaces are generally set to true, so you don't have to put them here.
 * !!!Must be done before LockdownSetupPermissions.php is executed to have any effect!!!
*/
# $smwgNamespacesWithSemanticLinksAdd = array(NS_NS1 => false, NS_NS2 => false);

/* Set this line if you want to allow anyone (including not logged in) to view the un-protected namespaces of the wiki
*/
$wgGroupPermissions['*']['read'] = true;

/* Set this line if you want to allow only registered and approved users to access the wiki.  Doing so denies all access to other than approved users.
*/
#$lockdownApprovedUserOnlyWiki = true;

require_once( "$IP/extensions/WikiConfig/CommonLocal.php" );

require_once( "$IP/extensions/Vector/Vector.php" );
$wgDefaultUserOptions['useeditwarning'] = 1;
$wgVectorFeatures['editwarning']['user'] = true;
$wgVectorModules['editwarning']['global'] = true; // Don't enable EditWarning globally
$wgVectorModules['editwarning']['user'] = true; // Allow users to enable EditWarning in their preferences
$wgVectorUseSimpleSearch = true; // Need this as well for SimpleSearch
$wgDefaultSkin = 'vector'; // If you want to change the default skin for new users
$wgVectorUseIconWatch = true; //Enable star icon to add/remove page from watchlist

// UsabilityInitiative/WikiEditor
require_once("$IP/extensions/WikiEditor/WikiEditor.php");
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;  // Default user preference to use toolbar dialogs
$wgWikiEditorModules['toolbar']['global'] = true;  // Enable the WikiEditor toolbar for everyone
$wgWikiEditorModules['toolbar']['user'] = false;  // Don't allow users to turn the WikiEditor toolbar on/off individually

# require_once("$IP/extensions/LiquidThreads/LiquidThreads.php");

require_once( "$IP/extensions/ExternalData/ExternalData.php" );
require_once( "$IP/extensions/Arrays/Arrays.php" );
require_once( "$IP/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php" );
#require_once( "$IP/extensions/Calendar/Calendar.php" );
#require_once( "$IP/extensions/PdfBook/PdfBook.php" );
# require_once( "$IP/extensions/Collection/Collection.php" );
# require_once( "$IP/extensions/Collection/Collection.php" );
require_once( "$IP/extensions/SemanticInternalObjects/SemanticInternalObjects.php" );
require_once( "$IP/extensions/SemanticFormsInputs/SemanticFormsInputs.php" );
#require_once( "$IP/extensions/SemanticQueryFormTool/includes/SQFT_Settings.php") ;
#require_once( "$IP/extensions/UrlGetParameters/UrlGetParameters.php" );
#require_once( "$IP/extensions/AllowGetParamsInWikilinks/AllowGetParamsInWikilinks.php" );

#require_once( "$IP/extensions/FCKeditor/FCKeditor.php" );

#OpenID Setup
define('Auth_OpenID_RAND_SOURCE', null);
require_once( "$IP/extensions/OpenID/OpenID.setup.php" );

$wgWhitelistRead[] = "Special:OpenIDLogin";
$wgGroupPermissions['*']['viewedittab']=false;
$wgGroupPermissions['sysop']['viewedittab']=true;
$wgGroupPermissions['bureaucrat']['viewedittab']=true;

require_once( "$IP/extensions/ConfirmEdit/ConfirmEdit.php");
require_once( "$IP/extensions/ConfirmEdit/ReCaptcha.php");
$wgCaptchaClass = 'ReCaptcha';
$wgReCaptchaPublicKey = '6Lcs2swSAAAAADkmNC86S72hGZj5AdaRyE9KYWGT';
$wgReCaptchaPrivateKey = '6Lcs2swSAAAAADlQoYcSpaexLbZHuS4wTs1p1xAu';

$wgCaptchaTriggers['edit']          = false; 
$wgCaptchaTriggers['create']        = false; 
$wgCaptchaTriggers['addurl']        = false; 
$wgCaptchaTriggers['createaccount'] = true;
$wgCaptchaTriggers['badlogin']      = true;



$sfgRenameMainEditTab=true;
# $wgMessageCache->addMessages( array('sf_editsource' => "Edit Data"), 'en' );
#
# Each privilege you want to lock out will specify only those given privileges will be allowed.
# Each privilege and group must be explicitly stated or lockdown doesn't happen for that privilege
#
# Implicit group for all visitors

# define( 'NS_WIDGET' , 498 );
# require_once( "$IP/extensions/Widgets/Widgets.php" );
# $wgGroupPermissions['sysop']['editwidgets'] = true;


#$wgNewUserNotifSender
#        Email address of the sender of the email
#        Defaults to the value of $wgPasswordSender
#
#$wgNewUserNotifTargets
#        Array containing the usernames or identifiers of those who should receive
#        a notification email. Email will not be sent unless the recipient's
#        email address has been validated, where this is required in the site
#        configuration.
#        
#        Defaults to the first user (usually the wiki's primary administrator)
#        

require_once("$IP/extensions/NewUserNotif/ExtendedParamsExample.php");
# require_once("$IP/extensions/VisualEditor/VisualEditor.php");
 
// OPTIONAL: Enable VisualEditor in other namespaces
// By default, VE is only enabled in NS_MAIN
//$wgVisualEditorNamespaces[] = NS_PROJECT;
 
// Enable by default for everybody
$wgDefaultUserOptions['visualeditor-enable'] = 1;
 
// Don't allow users to disable it
$wgHiddenPrefs[] = 'visualeditor-enable';
 
// OPTIONAL: Enable VisualEditor's experimental code features
//$wgVisualEditorEnableExperimentalCode = true;

$wgNewUserNotifEmailTargets = array( "accessapprover@".$_SERVER['SERVER_NAME'] );

# Set up to notify specified user(s) of all changes
$wgEnotifWatchlist = true;

## Declare this twice so it works for all versions
# $wgUsersNotifiedOnAllChanges = $wgUsersNotifedOnAllChanges = array( 'sysop' );

#        Array containing email addresses to which a notification should also be sent
#        Defaults to no additional addresses
$wgPasswordSender = "no-reply@".$_SERVER['SERVER_NAME'];

$wgUploadPath = "/".$wgSitename."/img_auth.php";
$wgUploadDirectory = realpath("$IP/../".$wgSitename."IMG");

$wgFileExtensions[] = "mdb";

$wgShowExceptionDetails= true;

$wgFileExtensions[] = "zip";
$wgFileExtensions[] = "conf";

# this is required if you are going to allow uploading of zip files (may not be recommended)

foreach ($wgMimeTypeBlacklist as $xtype) if ($xtype <> 'application/zip') $tmpType[] = $xtype;
$wgMimeTypeBlacklist = $tmpType;
unset($tmpType);

$wgLogo = "{$wgScriptPath}/extensions/PSITexLogo.png";
$wgFavicon = "{$wgScriptPath}/extensions/favicon.ico";

/*
ob_start();
foreach($lockdownNameSpaces as $thisNS)
{
	echo ("$thisNS: ".constant("NS_".$thisNS)." \n");
	echo ($thisNS."_talk: ".constant("NS_".$thisNS."_talk")." \n");
	var_dump($wgNamespacePermissionLockdown[constant("NS_$thisNS")]);
	echo "\n";
	var_dump($wgNamespacePermissionLockdown[constant("NS_".$thisNS."_talk")]);
}
$lresult = ob_get_clean();
error_log(__METHOD__."\n$lresult\n", 3, $wgDebugLogFile);
*/
