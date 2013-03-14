<?php
if (!defined('MEDIAWIKI')) die();
/*
 * Set up the namespaces access for lockdown Defaults
 * lockdown wikis generally require user registration to access more than the first page
 * Additionally, namespaces are widely used to protect information that is limited to users
 * who belong to the groups with the same name as the namespaces.
 * this sets everything up accordingly.
*/

if ( $lockdownApprovedUsersOnlyWiki ) {
	# Implicit group for all visitors
	$wgGroupPermissions['*']['createaccount'] = true;
	foreach ($lockdownDefaultPrivileges as $priv) $wgGroupPermissions['*'][$priv] = false;

	# Implicit group for all logged-in accounts
	$wgGroupPermissions['user']['createaccount'] = true;
	foreach ($lockdownDefaultPrivileges as $priv) $wgGroupPermissions['user'][$priv] = false;

	# Approved accounts
	foreach ($lockdownDefaultPrivileges as $priv) $wgGroupPermissions['approved'][$priv] = true;

	# Sysops
	foreach ($lockdownDefaultPrivileges as $priv) $wgGroupPermissions['sysop'][$priv] = true;
}

$curNS = $lockdownStartNS;
foreach($lockdownNameSpaces as $thisNS){
	if ($curNS == $smwgNamespaceIndex) $curNS += 10;
	$ucNS = strtoupper($thisNS);

# define numeric namespaces
	define("NS_$ucNS",$curNS);
	define("NS_".$ucNS."_talk", $curNS+1);

# define as extra namespaces
	$wgExtraNamespaces[$curNS] = $ucNS; 
	$wgExtraNamespaces[$curNS+1] = $ucNS."_talk";

# Indicate these namespaces are actually eligible to have content
	$wgContentNamespaces[] = $curNS;
	$wgContentNamespaces[] = $curNS+1;

# Make Namespaces unincludable as templates
	$wgNonincludableNamespaces[] = $curNS;
	$wgNonincludableNamespaces[] = $curNS+1;

# Add new group accounts corresponding to NS Name
	$wgGroupPermissions[strtolower($thisNS)]['read'] = false;
	$curNS += 2;
}
