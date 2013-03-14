<?php
if (!defined('MEDIAWIKI')) die();
#  Below is for debug and should be commented out when finished
#
/**
 * The debug log file should be not be publicly accessible if it is used, as it
 * may contain private data.  But it must be in a directory to which PHP run
 * within your Web server can write.
 */
 
/* To debug within MediaWiki, you can use the vtitle() script.  Example (including method name from which debug is called):
	wfDebug( __METHOD__."::name: $name\n" );
 **/

/**
 * To debug within a mainenance script (or a redirect script), you should use wfDebugLog($script,$text);
 * wfDebugLog( 'img_auth::', __METHOD__."action: $action\n" );
 */
 
/** If you want to debug arrays, use the output buffer functions to capture the output, then send the captured string.  Example:

	ob_start();
	var_dump($yourvar);
	$lresult = ob_get_clean();
	wfDebug( __METHOD__."::lresult: $lresult\n" );

	if you want to debug localsettings, you need to use the following syntax:
	ob_start();
	var_dump($smwgNamespacesWithSemanticLinksAdd);
	$lresult = ob_get_clean();
	error_log(__METHOD__."smwgNamespacesWithSemanticLinksAdd(before)::".$lresult."\n", 3, $wgDebugLogFile);

**/
error_reporting(E_ALL);
ini_set("display_errors", 1);
$wgShowExceptionDetails = true;
$wgShowSQLErrors = true;
$wgDebugDumpSql = true;
$wgDebugLogFile         = "$IP/debug_log.txt";
#
# Profiling / debugging
#

/** Enable for more detailed by-function times in debug log */
$wgProfiling = true;
/** Only record profiling info for pages that took longer than this */
$wgProfileLimit = 0.0;
/** Don't put non-profiling info into log file */
$wgProfileOnly = false;
/** Log sums from profiling into "profiling" table in db. */
$wgProfileToDatabase = false;
/** Only profile every n requests when profiling is turned on */
$wgProfileSampleRate = 1;
/** If true, print a raw call tree instead of per-function report */
$wgProfileCallTree = false;
/** If not empty, specifies profiler type to load */
$wgProfilerType = '';

/** Settings for UDP profiler */
$wgUDPProfilerHost = '127.0.0.1';
$wgUDPProfilerPort = '3811';

/** Detects non-matching wfProfileIn/wfProfileOut calls */
$wgDebugProfiling = true;
/** Output debug message on every wfProfileIn/wfProfileOut */
$wgDebugFunctionEntry = 1;
/** Lots of debugging output from SquidUpdate.php */
$wgDebugSquid = false;

function JDPVarDump($arrval)
{
	ob_start();
	var_dump($arrval);
	return(ob_get_clean());
}

function JDPBackTrace()
{
	$result = "";
	$x=debug_backtrace();
	$notthis = false;
	foreach ($x as $thiscall){
		if ($notthis){
				$result .= "JDPBackTrace::".
					(isset($thiscall["file"]) ? " file: ".$thiscall["file"] : "" ).
					(isset($thiscall["line"]) ? "(".$thiscall["line"].")" : "" ).
					(isset($thiscall["type"]) ? " type: ".$thiscall["type"]." " : "" ).
					(isset($thiscall["function"]) ? " function: ".$thiscall["function"]." " : "" ).
					(isset($thiscall["class"]) ? " class: ".$thiscall["class"]." " : "" ).
					" args: ".count($thiscall["args"])."\n";
		} else $notthis = true;
	}
	return ($result);
}