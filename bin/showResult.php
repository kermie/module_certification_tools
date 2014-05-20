<?php
/**
 *    This file is part of the OXID module certification tool
 *
 *    The OXID module certification tool is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    The OXID module certification tool is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    For further details, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @package   OXID module certification tool
 * @copyright (C) OXID eSales AG 2003-2014
 */

require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/MdXmlController.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/MdXmlModel.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/XmlModel.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/Violation.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/View.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/MainController.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/XmlController.php');

require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/Model/MdResult.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/Model/ModuleCertificationResult.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/Parser/MdXmlParser.php');
require_once realpath( __DIR__ . '/../src/Com/OxidEsales/ModuleCertificationTool/Parser/ViolationXmlParser.php');

$aConfiguration = array(
    'sModulePath'       => $argv[2],
    'sMdXmlFile'        => $argv[1] . '/oxmd-result.xml',
    'sDirectoryXmlFile' => $argv[1] . '/directory.xml',
    'sGlobalsXmlFile'   => $argv[1] . '/globals.xml',
    'sPrefixXmlFile'    => $argv[1] . '/prefix.xml',
    'sOutputFile'       => $argv[1] . '/report.html'
);

$oController = new MainController();
$oController->setConfiguration( $aConfiguration )->indexAction();
