<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace Tests;

use \PHPUnit\Framework\TestCase;
use \Logics\Tests\InternalWebServer;
use \AM\CryptoTop\CryptoRating;

/**
 * Tests for coinmarketcap grabber
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 *
 * @runTestsInSeparateProcesses
 */

class CryptoRatingTest extends TestCase
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

		define("FILES_COINMARKETCAP_URL", $this->remotepath . "/datasets/files");
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
		define("COINMARKETCAP_URL", $this->host);

		$cryptorating = new CryptoRating();
		$rating       = $cryptorating->get();
//file_put_contents(__DIR__ . "/expected.json", json_encode($rating));
		$expected = json_decode(file_get_contents(__DIR__ . "/expected.json"), true);
		$this->assertEquals($expected, $rating);
	    } //end testShouldAllowToGetCryptocurrencyRating()


	/**
	 * Should allow to validate rating results by XML-Schema
	 *
	 * @return void
	 */

	public function testShouldAllowToValidateRatingResultsByXmlSchema()
	    {
		define("COINMARKETCAP_URL", $this->host);

		$cryptorating = new CryptoRating();
		$rating       = $cryptorating->get();

		$this->assertTrue($cryptorating->validate($rating));
	    } //end testShouldAllowToValidateRatingResultsByXmlSchema()


    } //end class


?>
