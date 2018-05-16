<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace Tests;

use \PHPUnit\Framework\TestCase;
use \Logics\Tests\InternalWebServer;
use \AM\CryptoTop\CryptoRatingWithWP as CryptoRating;

/**
 * Tests for coinmarketcap grabber with whitepaper document
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 *
 * @runTestsInSeparateProcesses
 */
class CryptoRatingWithWPTest extends TestCase
{

    use InternalWebServer;

    /**
     * Name folder which should be removed after tests
     *
     * @var string
     */
    protected $remotepath;

    /**
     * Testing coinmarketcap
     *
     * @var string
     */
    protected $coinmarketcap;

    /**
     * Testing blockchair
     *
     * @var string
     */
    protected $blockchair;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */

    protected function setUp()
    {
        $this->remotepath    = $this->webserverURL();
        $this->coinmarketcap = $this->remotepath . "/datasets/coinmarketcap";
        $this->blockchair    = $this->remotepath . "/datasets/blockchair";

        define("COINMARKETCAP_URL", $this->coinmarketcap);
        define("BLOCKCHAIR_URL", $this->blockchair);
        define("WHATTOMINE_URL", $this->remotepath . "/datasets/whattomine");
    } //end setUp()


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */

    protected function tearDown()
    {
        unset($this->remotepath);
    } //end tearDown()


    /**
     * Should allow to get cryptocurrency rating
     *
     * @return void
     */

    public function testShouldAllowToGetCryptocurrencyRating()
    {
        define("FILES_COINMARKETCAP_URL", $this->remotepath . "/datasets/files");

        $cryptorating = new CryptoRating();
        $rating       = $cryptorating->get();
//file_put_contents(__DIR__ . "/expected_with_wp.json", json_encode($rating));
        $expected = json_decode(file_get_contents(__DIR__ . "/expected_with_wp.json"), true);
        $this->assertEquals($expected, $rating);
    } //end testShouldAllowToGetCryptocurrencyRating()


    /**
     * Should allow to validate rating results by XML-Schema
     *
     * @return void
     */

    public function testShouldAllowToValidateRatingResultsByXmlSchema()
    {
        define("FILES_COINMARKETCAP_URL", $this->remotepath . "/datasets/files");

        $cryptorating = new CryptoRating();
        $rating       = $cryptorating->get();

        $this->assertTrue($cryptorating->validate($rating));
    } //end testShouldAllowToValidateRatingResultsByXmlSchema()

} //end class

?>
