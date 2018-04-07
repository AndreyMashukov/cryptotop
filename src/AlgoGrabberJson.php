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
class AlgoGrabberJson extends AlgoGrabber
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
            "asic" => WHATTOMINE_URL . "/asic.json",
            "gpu"  => WHATTOMINE_URL . "/coins.json",
        ];

        $http = new HTTPclient($urls[$device]);
        $json = json_decode($http->get(), true);

        foreach ($json["coins"] as $name => $currency) {
            if ($currency["tag"] !== "NICEHASH") {
                $algorithms[$currency["tag"]] = [
                    "name"      => $name,
                    "algorithm" => $currency["algorithm"],
                    "ticker"    => $currency["tag"],
                    "device"    => $device,
                ];
            } //end if

        } //end foreach

        return $algorithms;
    } //end getAlgorithm()


} //end class

?>
