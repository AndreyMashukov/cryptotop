<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace Tests;

use \PHPUnit\Framework\TestCase;
use \Logics\Tests\InternalWebServer;
use \AM\CryptoTop\Algorithms;

/**
 * Tests for whattomine.com algorithms grabber
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 *
 * @runTestsInSeparateProcesses
 */
class AlgorithmsTest extends TestCase
{

    use InternalWebServer;

    /**
     * Name folder which should be removed after tests
     *
     * @var string
     */
    protected $remotepath;

    /**
     * Testing host
     *
     * @var string
     */
    protected $host;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */

    protected function setUp()
    {
        $this->remotepath = $this->webserverURL();
        $this->host       = $this->remotepath . "/datasets/coinmarketcap";

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
     * Should allow to get cryptocurrencies mining algorithms with default grabber
     *
     * @return void
     */

    public function testShouldAllowToGetCryptocurrenciesMiningAlgorithmsWithDefaultGrabber()
    {
        $grabber    = new Algorithms();
        $algorithms = $grabber->get();

        $expected = json_decode(file_get_contents(__DIR__ . "/algorithms_json.json"), true);
        $this->assertEquals($expected, $algorithms);
    } //end testShouldAllowToGetCryptocurrenciesMiningAlgorithmsWithDefaultGrabber()


    /**
     * Should allow to get cryptocurrencies mining algorithms with defined grabber
     *
     * @return void
     */

    public function testShouldAllowToGetCryptocurrenciesMiningAlgorithmsWithDefinedGrabber()
    {
        define("ALGO_GRABBER_CLASS", \AM\CryptoTop\AlgoGrabberHTML::class);

        $grabber    = new Algorithms();
        $algorithms = $grabber->get();

        $expected = json_decode(file_get_contents(__DIR__ . "/algorithms_html.json"), true);
        $this->assertEquals($expected, $algorithms);
    } //end testShouldAllowToGetCryptocurrenciesMiningAlgorithmsWithDefinedGrabber()


} //end class

?>
