<?php
/**
 * Copyright (C) 2010-2021 Combodo SARL
 *
 *   This file is part of iTop.
 *
 *   iTop is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   iTop is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with iTop. If not, see <http: *www.gnu.org/licenses/>
 *
 */

use Combodo\iTop\Composer\iTopComposer;

$iTopFolder = __DIR__ . "/../../" ;

require_once ("$iTopFolder/approot.inc.php");
require_once (APPROOT."/setup/setuputils.class.inc.php");

if  (php_sapi_name() !== 'cli')
{
	throw new \Exception('This script can only run from CLI');
}

clearstatcache();

$oiTopComposer = new iTopComposer();
$aDeniedButStillPresent = $oiTopComposer->ListDeniedButStillPresent();

echo "\n";
foreach ($aDeniedButStillPresent as $sDir)
{
	if (false === iTopComposer::IsTestDir($sDir))
	{
		echo "ERROR found INVALID denied test dir: '$sDir'\n";
		throw new \Exception("$sDir must end with /Test/ or /test/");
	}

	if (false === file_exists($sDir)) {
		echo "INFO $sDir is in denied list, but not existing on disk => skipping !\n";
		continue;
	}

	try {
		SetupUtils::rrmdir($sDir);
		echo "OK Remove denied test dir: '$sDir'\n";
	}
	catch (\Exception $e) {
		echo "\nFAILED to remove denied test dir: '$sDir'\n";
	}
}


$aAllowedAndDeniedDirs = array_merge(
	$oiTopComposer->ListAllowedTestDir(),
	$oiTopComposer->ListDeniedTestDir()
);
$aExistingDirs = $oiTopComposer->ListAllTestDir();
$aMissing = array_diff($aExistingDirs, $aAllowedAndDeniedDirs);
if (false === empty($aMissing)) {
	echo "Some new tests dirs exists !\n"
		.'  They must be declared either in the allowed or denied list in '.iTopComposer::class." (see N°2651).\n"
		.'  List of dirs:'."\n".var_export($aMissing, true);
}