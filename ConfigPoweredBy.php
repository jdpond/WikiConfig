<?php

/**
 * ConfigPoweredBy
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Jack D. Pond, psitex.com
 * @copyright © 2011 Jack D. Pond
 * @license GNU General Public Licence 2.0 or later
 */

 
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ConfigPoweredBy', 
	'author' => array( 'Jack D. Pond'), 
	'description' => 'Add Powered By Tags',
	'descriptionmsg' => 'ConfigPoweredBy',
);

$wgHooks['SkinGetPoweredBy'][] = 'ConfigPoweredBy';

function ConfigPoweredBy( &$text, $skin ) {
#	$url = htmlspecialchars( "$smwgScriptPath/resources/images/smw_button.png" );
	$url = htmlspecialchars( dirname(__FILE__)."/smw_button.png" );
	$text .= '<a href="http://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki"><img src="' . $url . '" height="31" width="88" alt="Powered by SemanticMediaWiki" /></a>';
	return true;
}
