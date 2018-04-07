<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace AM\CryptoTop;

use \DOMDocument;
use \DOMXPath;
use \Logics\Foundation\HTTP\HTTPclient;

/**
 * Abstract algorithms grabber
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 */
class AlgoGrabberHTML extends AlgoGrabber
{

    /**
     * Get mining algorithm list
     *
     * @param string $device Type of mining device
     *
     * @return array Mining algorithms
     */

    public function getAlgorithm(string $device): array
    {
        $algorithms = [];

        $urls = [
            "asic" => WHATTOMINE_URL . "/asic",
            "gpu"  => WHATTOMINE_URL . "/coins",
        ];

        $http = new HTTPclient($urls[$device]);
        $html = $http->get();
        $dom  = new DOMDocument("1.0", "utf-8");
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $list = $xpath->query("//table[@class='table table-hover table-vcenter']/tbody/tr/td[1]");
        foreach ($list as $element) {
            $td     = $dom->saveHTML($element);
            $parsed = $this->_parseHTML($td);

            if (count($parsed) > 0 && isset($parsed["ticker"]) === true) {
                $parsed["device"]              = $device;
                $algorithms[$parsed["ticker"]] = $parsed;
            } //end if

        } //end foreach

        return $algorithms;
    } //end getAlgorithm()


    /**
     * Parse HTML code
     *
     * @param string $html Table element to parse
     *
     * @return array Parsed data
     */

    private function _parseHTML(string $html): array
    {
        $parsed = [];

        $dom = new DOMDocument("1.0", "utf-8");
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $fields = [
            "name"      => "//td/div/a | //td/div[last() - 1]",
            "algorithm" => "//td/div[last()]//text()",
        ];

        foreach ($fields as $name => $path) {
            $list = $xpath->query($path);
            if ($list->length > 0) {
                $parsed[$name] = preg_replace("/(\n+|\s+)/ui", "", $list[0]->textContent);
            } //end if

        } //end foreach

        if (count($parsed) === 2) {
            if (preg_match("/(?P<name>[A-Za-z]+)\((?P<ticker>[A-Za-z]+)\)/ui", $parsed["name"], $result) > 0) {
                $parsed["ticker"] = $result["ticker"];
                $parsed["name"]   = $result["name"];
            } //end if

            if (preg_match("/(?P<first>[A-Za-z]+)\((?P<second>[0-9A-Za-z]+)\)/ui", $parsed["algorithm"], $result) > 0) {
                $parsed["algorithm"] = $result["first"] . " (" . $result["second"] . ")";
            } //end if

        } //end if

        return $parsed;
    } //end _parseHTML()


} //end class

?>
