<?php
if (!defined('MEDIAWIKI')) die();

$lockdownNameSpaces = array();
$lockdownSMWSearchable = array();
$lockdownSMWTalkSearchable = array();
$lockdownExtraPrivileges = array();
$lockdownApprovedUsersOnlyWiki = false ;
$lockdownDefaultPrivileges = array(
							'read','edit','move','delete','create','createpage',
							'createtalk','upload','reupload','reupload-shared','minoredit',
							'writeapi' , 'move-subpages' , 'move-rootuserpages', 'purge',
							'sendemail', 'move-target'
							);
$lockdownStartNS = 100;
$smwgNamespacesWithSemanticLinksAdd = array();
$smwgNamespaceIndex = 100;
