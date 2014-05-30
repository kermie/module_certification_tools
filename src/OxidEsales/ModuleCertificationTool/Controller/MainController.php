<?php
/**
 *    This file is part of the OXID module certification tool
 *    The OXID module certification tool is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *    The OXID module certification tool is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *    For further details, see <http://www.gnu.org/licenses/>.
 *
 * @link          http://www.oxid-esales.com
 * @package       OXID module certification tool
 * @copyright (C) OXID eSales AG 2003-2014
 */

namespace OxidEsales\ModuleCertificationTool\Controller;

use OxidEsales\ModuleCertificationTool\Model\CertificationPrice;
use OxidEsales\ModuleCertificationTool\Model\Violation;
use OxidEsales\ModuleCertificationTool\Parser\MdXmlParser;
use OxidEsales\ModuleCertificationTool\Parser\GenericViolationXmlParser;
use OxidEsales\ModuleCertificationTool\View;

/**
 * Class MainController main controller class for the application
 */
class MainController
{

    /**
     * Contains als the configuration values for the application.
     *
     * @var object
     */
    protected $configuration;

    /**
     * Fills the configuration object of the class with given values.
     *
     * @param array $configuration array with all the configuration values
     *
     * @return $this the controller itself
     */
    public function setConfiguration( $configuration )
    {
        $this->configuration = (object)$configuration;

        return $this;
    }

    /**
     * Main Action for running the application.
     *
     * @return $this the controller itself
     * @throws \Exception
     */
    public function indexAction()
    {
        $view = new View();
        $view->setTemplate( 'index' );

        $fileViolationHtmls  = array( 'Error while processing clover xml: file not found' );
        $mdHtml              = "";

        if ( !is_dir( $this->configuration->modulePath ) || !is_readable( $this->configuration->modulePath ) ) {
            throw new \Exception( 'no module found in ' . $this->configuration->modulePath );
        }

        $certificationResult = $this->parseMd();
        if ( !( empty( $certificationResult ) ) ) {
            $mdHtml             = $this->getPrice( $certificationResult );
            $fileViolationHtmls = $this->getFileViolations( $certificationResult );
        }
        $view->assignVariable( 'certificationResult', $mdHtml );
        $view->assignVariable( 'fileViolations', $fileViolationHtmls );

        $genericHtml = $this->parseGeneric();
        $view->assignVariable( 'genericChecks', $genericHtml );

        $html = $view->render();

        if ( false === file_put_contents( $this->configuration->outputFile, $html ) ) {
            throw new \Exception( 'error while writing ' . $this->configuration->outputFile );
        }

        return $this;
    }

    private function getPrice( $certificationResult )
    {
        $certificationPrice = new CertificationPrice( $certificationResult );

        return $certificationPrice->getHtml();
    }

    private function parseMd()
    {
        $mdXmlParser = new MdXmlParser();
        $mdXmlParser->cleanUpXmlFile( $this->configuration->mdXmlFile );
        $certificationResult = $mdXmlParser->parse( $mdXmlParser->getXmlObjectFromFile( $this->configuration->mdXmlFile ) );

        return $certificationResult;
    }

    private function parseGeneric()
    {
        $genericHtml=array();
        $violationXmlParser = new GenericViolationXmlParser();
        foreach(  $this->configuration->additionalTests as $header => $file ){
            $violation = $violationXmlParser->parse( $violationXmlParser->getXmlObjectFromFile( $file ) );
            $genericCheck        = new Violation( $violation, 'genericViolationList' );
            $genericHtml[]       = $genericCheck->setHeading( $header )->getHtml();
        }
        return $genericHtml;
    }

    private function getFileViolations( $certificationResult )
    {
        $fileViolationHtmls = array();
        foreach ( $certificationResult->getViolations() as $ruleName => $fileViolations ) {
            $fileViolations = new Violation( $fileViolations, 'fileViolationTable' );
            $fileViolations->setHeading( $ruleName );
            $fileViolationHtmls[ ] = $fileViolations->getHtml();
        }

        return $fileViolationHtmls;
    }
}
