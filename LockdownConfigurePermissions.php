<?php
if (!defined('MEDIAWIKI')) die();
/*
 * Set the default lockdown permissions for a lockdown wiki
 * For each namespace in the list, set * for sysops, and all others to the groupname + sysops
 * Also, if there are namespaces with additional permissions, add them here too
*/

$curNS = $lockdownStartNS;
foreach($lockdownNameSpaces as $thisNS){
	if ($curNS == $smwgNamespaceIndex) $curNS += 10;
	$wgNamespacePermissionLockdown[$curNS]['*'] = array('sysop');
	foreach ($lockdownDefaultPrivileges as $priv) $wgNamespacePermissionLockdown[$curNS][$priv] = array(strtolower($thisNS),'sysop');
	$wgNamespacePermissionLockdown[$curNS+1]['*'] = array('sysop');
	foreach ($lockdownDefaultPrivileges as $priv) $wgNamespacePermissionLockdown[$curNS+1][$priv] = array(strtolower($thisNS),'sysop');
	$curNS += 2;
}

/*
 * Then add any additional groups allowed access to namespaces from the $lockdownExtraPrivileges array
*/
foreach($lockdownExtraPrivileges as $thisNS => $AddGroups){
	foreach($lockdownDefaultPrivileges as $priv) {
		foreach ($AddGroups as $newGroup){
			$wgNamespacePermissionLockdown[constant("NS_$thisNS")][$priv][] = strtolower($newGroup);
			$wgNamespacePermissionLockdown[constant("NS_".$thisNS."_talk")][$priv][] = strtolower($newGroup);
		}
	}
}

if ( $lockdownApprovedUsersOnlyWiki ) {
	$wgSpecialPageLockdown['Export'] = array('bureaucrat');
	$wgSpecialPageLockdown['Activeusers'] = array('bureaucrat');
	$wgSpecialPageLockdown['Allmessages'] = array('bureaucrat');
	$wgSpecialPageLockdown['Allpages'] = array('bureaucrat');
	$wgSpecialPageLockdown['Ancientpages'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Blankpage'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Blockip'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Blockme'] = array('bureaucrat');
	$wgSpecialPageLockdown['Booksources'] = array('approved');
	$wgSpecialPageLockdown['BrokenRedirects'] = array('bureaucrat');
	$wgSpecialPageLockdown['Categories'] = array('approved');
	#$wgSpecialPageLockdown['Confirmemail'] = array('bureaucrat');
	$wgSpecialPageLockdown['Contributions'] = array('approved');
	$wgSpecialPageLockdown['Deadendpages'] = array('bureaucrat');
	$wgSpecialPageLockdown['DeletedContributions'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Disambiguations'] = array('bureaucrat');
	$wgSpecialPageLockdown['DoubleRedirects'] = array('bureaucrat');
	$wgSpecialPageLockdown['Emailuser'] = array('approved');
	$wgSpecialPageLockdown['Export'] = array('bureaucrat');
	$wgSpecialPageLockdown['Fewestrevisions'] = array('bureaucrat');
	$wgSpecialPageLockdown['FileDuplicateSearch'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Filepath'] = array('bureaucrat');
	$wgSpecialPageLockdown['Import'] = array('bureaucrat');
	$wgSpecialPageLockdown['Ipblocklist'] = array('bureaucrat');
	$wgSpecialPageLockdown['LinkSearch'] = array('approved');
	$wgSpecialPageLockdown['Listfiles'] = array('approved');
	$wgSpecialPageLockdown['Listgrouprights'] = array('bureaucrat');
	$wgSpecialPageLockdown['Listredirects'] = array('bureaucrat');
	$wgSpecialPageLockdown['Listusers'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Lockdb'] = array('bureaucrat');
	$wgSpecialPageLockdown['Log'] = array('bureaucrat');
	$wgSpecialPageLockdown['Lonelypages'] = array('bureaucrat');
	$wgSpecialPageLockdown['Longpages'] = array('bureaucrat');
	$wgSpecialPageLockdown['MergeHistory'] = array('bureaucrat');
	$wgSpecialPageLockdown['MIMEsearch'] = array('bureaucrat');
	$wgSpecialPageLockdown['Mostcategories'] = array('bureaucrat');
	$wgSpecialPageLockdown['Mostimages'] = array('bureaucrat');
	$wgSpecialPageLockdown['Mostlinked'] = array('bureaucrat');
	$wgSpecialPageLockdown['Mostlinkedcategories'] = array('bureaucrat');
	$wgSpecialPageLockdown['Mostlinkedtemplates'] = array('bureaucrat');
	$wgSpecialPageLockdown['Mostrevisions'] = array('bureaucrat');
	$wgSpecialPageLockdown['Movepage'] = array('approved');
	$wgSpecialPageLockdown['Newimages'] = array('approved');
	$wgSpecialPageLockdown['Newpages'] = array('approved');
	$wgSpecialPageLockdown['Popularpages'] = array('approved');
	#$wgSpecialPageLockdown['Preferences'] = array('bureaucrat');
	$wgSpecialPageLockdown['Prefixindex'] = array('approved');
	$wgSpecialPageLockdown['Protectedpages'] = array('approved');
	$wgSpecialPageLockdown['Protectedtitles'] = array('approved');
	$wgSpecialPageLockdown['Randompage'] = array('approved');
	$wgSpecialPageLockdown['Randomredirect'] = array('approved');
	$wgSpecialPageLockdown['Recentchanges'] = array('approved');
	$wgSpecialPageLockdown['Recentchangeslinked'] = array('approved');
	$wgSpecialPageLockdown['RemoveRestrictions'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Resetpass'] = array('bureaucrat');
	$wgSpecialPageLockdown['Revisiondelete'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Search'] = array('bureaucrat');
	$wgSpecialPageLockdown['Shortpages'] = array('approved');
	$wgSpecialPageLockdown['Specialpages'] = array('approved');
	$wgSpecialPageLockdown['Statistics'] = array('bureaucrat');
	$wgSpecialPageLockdown['Tags'] = array('approved');
	$wgSpecialPageLockdown['Uncategorizedcategories'] = array('approved');
	$wgSpecialPageLockdown['Uncategorizedimages'] = array('approved');
	$wgSpecialPageLockdown['Uncategorizedpages'] = array('approved');
	$wgSpecialPageLockdown['Uncategorizedtemplates'] = array('approved');
	$wgSpecialPageLockdown['Undelete'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Unlockdb'] = array('bureaucrat');
	$wgSpecialPageLockdown['Unusedcategories'] = array('bureaucrat');
	$wgSpecialPageLockdown['Unusedimages'] = array('bureaucrat');
	$wgSpecialPageLockdown['Unusedtemplates'] = array('bureaucrat');
	$wgSpecialPageLockdown['Unwatchedpages'] = array('bureaucrat');
	$wgSpecialPageLockdown['Upload'] = array('approved');
	#$wgSpecialPageLockdown['Userlogin'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Userlogout'] = array('bureaucrat');
	#$wgSpecialPageLockdown['Userrights'] = array('bureaucrat');
	$wgSpecialPageLockdown['Version'] = array('approved');
	$wgSpecialPageLockdown['Wantedcategories'] = array('approved');
	$wgSpecialPageLockdown['Wantedfiles'] = array('approved');
	$wgSpecialPageLockdown['Wantedpages'] = array('approved');
	$wgSpecialPageLockdown['Wantedtemplates'] = array('approved');
	#$wgSpecialPageLockdown['Watchlist'] = array('bureaucrat');
	$wgSpecialPageLockdown['Whatlinkshere'] = array('approved');
	$wgSpecialPageLockdown['Withoutinterwiki'] = array('approved');
}
