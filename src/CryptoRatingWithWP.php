<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace AM\CryptoTop;

use \Agentzilla\HTTP\HTTPclient;

/**
 * Crypto rating with whitepapers
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 */
class CryptoRatingWithWP extends CryptoRating
{

    /**
     * Prepare class to work
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    } //end __construct()


    /**
     * Read tr element
     *
     * @param string $tr Html code of element
     *
     * @return array Tr element data
     */

    protected function readTr(string $tr): array
    {
        $parsed               = $this->parseHTML($tr);
        $parsed["whitepaper"] = $this->_getWhitePaper($parsed["name"]);

        return $parsed;
    } //end readTr()


    /**
     * Get currency white paper
     *
     * @param string $currency Name of crypto currency
     *
     * @return string URL link to whitepaper
     */

    private function _getWhitePaper(string $currency): string
    {
        $link = "";

        $http   = new HTTPclient(BLOCKCHAIR_URL . "/search?q=" . $currency . "+white+paper");
        $result = json_decode($http->get(), true);

        foreach ($result["results"][0]["data"]["data"] as $element) {
            if (preg_match("/" . $currency . "/ui", $element["title"]) > 0) {
                $link = $element["url"];
            } //end if

            break;
        } //end foreach

        return $link;
    } //end _getWhitePaper()


} //end class
