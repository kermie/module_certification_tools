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

namespace Com\OxidEsales\ModuleCertificationTool;

use Com\OxidEsales\ModuleCertificationTool\Model\CertificationResult;
use Com\OxidEsales\ModuleCertificationTool\Model\ModuleCertificationResult;

/**
 * Class CertificationPriceController controller class to handle the output of the OXMD module
 */
class CertificationPriceController
{

    private $result;

    public function __construct( CertificationResult $result )
    {
        $this->result = $result;
    }

    /**
     * The path to the output file of OXMD.
     *
     * @var string
     */
    protected $_sFilePath = '';

    /**
     * Returns the HTML code for the output of the OXMD file.
     *
     * @return string HTML code for the output
     */
    public function getHtml()
    {

        $oView = new View();
        $sHtml = $oView->setTemplate( 'certificationPrice' )
            ->assignVariable( 'oCertificationResult', $this->result )
            ->render();

        return $sHtml;
    }

}