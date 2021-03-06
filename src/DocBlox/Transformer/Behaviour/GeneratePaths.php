<?php
/**
 * DocBlox
 *
 * PHP Version 5
 *
 * @category   DocBlox
 * @package    Transformer
 * @subpackage Behaviour
 * @author     Mike van Riel <mike.vanriel@naenius.com>
 * @copyright  2010-2011 Mike van Riel / Naenius (http://www.naenius.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       http://docblox-project.org
 */

/**
 * Behaviour that adds generated path information on the File elements.
 *
 * @category   DocBlox
 * @package    Transformer
 * @subpackage Behaviour
 * @author     Mike van Riel <mike.vanriel@naenius.com>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       http://docblox-project.org
 */
class DocBlox_Transformer_Behaviour_GeneratePaths implements
    DocBlox_Transformer_Behaviour_Interface
{
    /** @var DocBlox_Core_Log */
    protected $logger = null;

    /**
     * Sets the logger for this behaviour.
     *
     * @param DocBlox_Core_Log $log
     *
     * @return void
     */
    public function setLogger(DocBlox_Core_Log $log = null)
    {
        $this->logger = $log;
    }

    /**
     * Adds extra information to the structure.
     *
     * This method enhances the Structure information with the following information:
     * - Every file receives a 'generated-path' attribute which contains the path on the filesystem where the docs for
     *   that file van be found.
     *
     * @param DOMDocument $xml
     *
     * @return DOMDocument
     */
    public function process(DOMDocument $xml)
    {
        if ($this->logger) {
            $this->logger->log('Adding path information to each xml "file" tag');
        }

        $xpath = new DOMXPath($xml);
        $qry = $xpath->query("/project/file[@path]");

        /** @var DOMElement $element */
        foreach ($qry as $element) {
            $files[] = $element->getAttribute('path');
            $element->setAttribute('generated-path', $this->generateFilename($element->getAttribute('path')));
        }

        return $xml;
    }

    /**
     * Converts a source file name to the name used for generating the end result.
     *
     * @param string $file
     *
     * @return string
     */
    public function generateFilename($file)
    {
        $info = pathinfo(str_replace(DIRECTORY_SEPARATOR, '_', trim($file, DIRECTORY_SEPARATOR . '.')));
        return 'db_' . $info['filename'] . '.html';
    }

}