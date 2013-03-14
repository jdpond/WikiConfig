<?php
if (!defined('MEDIAWIKI')) die();
#
# Uncomment this to debug
#require_once("$IP/extensions/JDPConfig/debugcode.php");
# $wgShowExceptionDetails= true; // shows the exception details on the screen - good for debugging, but possible security issue

/* Semantic MediaWiki requires 10 namespaces starting at the first available.
 * This will move the smw namespaces to start at the namespace below, and will run through this plus 9.
 * Once this has been initialized for this wiki, it should never be changed.  The next available namspace if you want to add
 * more custom namepaces should start at this + 10.  If you're not sure what you're doing with this, LEAVE IT ALONE!
*/
$smwgNamespaceIndex = 100;

/* To add additional namespaces, you're going to usually want to uncomment all three of the following lines.
 * 
 * !!!!IMPORTANT!!!!	Once a namespace is declared, the database is updated and it is referred to by the physical number
 *						in the database. Therefore:
 *						1) NEVER REMOVE A NAMESPACE ONCE ADDED AND;
 *						2) NEVER REARRANGE THE ORDER OF THE NAMESPACES ONCE ADDED;
 *	If you do not follow these instructions, you will find stuff magically moved from one namespace to another irretrievably!!!
 *  @ param $JDPNameSpaces adds a namespace and talk namespace for each in the array, as well as creates a group of the same name
 *  @ param #$JDPSMWSearchable
*/
#$JDPNameSpaces = array("NS1","NS2");
#$JDPSMWSearchable = $JDPNameSpaces;
#$JDPSMWTalkSearchable = $JDPNameSpaces;

/*
 *$JDPExtraPrivileges
 *	Designates access to additional user groups for a particular namespace
 *  The index value is the namespace and the array indexed are the additional usergroups allowed
*/
#$JDPExtraPrivileges = array( "NS1" => array("ns2","ns3"),);


/* If you wish to have additional namespaces to be enabled for semantic links, or to override the defaults
 * they must be added to this array.
 * NOTE:  by default all namespaces that appear in $JDPNameSpaces are generally set to true, so you don't have to put them here.
 * !!!Must be done before JDPLocal.php is executed to have any effect!!!
*/
# $smwgNamespacesWithSemanticLinksAdd = array(NS_NS1 => false, NS_NS2 => false);

require_once("$IP/extensions/JDPConfig/JDPLocal.php");
#
# Add the Syntax high-lighter for code (<source lang= . . .> tag).
#
# require_once("$IP/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php");

/* $wgNewUserNotifSender
 *        Email address of the sender of the email
 *        Defaults to the value of $wgPasswordSender
*/
#$wgNewUserNotifTargets

/* $wgNewUserNotifEmailTargets
 *        Array containing the usernames or identifiers of those who should receive
 *        a notification email. Email will not be sent unless the recipient's
 *        email address has been validated, where this is required in the site
 *        configuration.
 *       
 *        Defaults to the first user (usually the wiki's primary administrator)
*/       
# $wgNewUserNotifEmailTargets = array("jack.pond@psitex.com");

/* $wgUsersNotifedOnAllChanges
 *   Array containing email addresses to which a notification any time a something is changed on this wiki should also be sent
 *	Defaults to no additional addresses
 * 		NOTE: if you want someone to be notified on all changes, Declare this twice so it works for all versions
*/
# $wgUsersNotifedOnAllChanges = $wgUsersNotifedOnAllChanges = array("Jdpond");

$wgPasswordSender = "no-reply@local.psitex.com";

$wgUploadPath = "/MediaWikiImg";
$wgUploadDirectory = "C:\Inetpub\wwwroot\Wiki\MediaWikiImg";
$wgEnableParserCache = false;
$wgCachePages = false;