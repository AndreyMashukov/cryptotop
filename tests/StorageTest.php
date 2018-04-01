<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace Tests;

use \PHPUnit\Framework\TestCase;
use \Logics\Tests\InternalWebServer;
use \Logics\Foundation\SQL\SQL;
use \AM\CryptoTop\Storage;
use \DateTimezone;
use \DateTime;

/**
 * Test for crypto rating storage
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 *
 * @runTestsInSeparateProcesses
 */

class StorageTest extends TestCase
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
	 * Config file
	 *
	 * @var string
	 */
	protected $configname;

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
		define("WHATTOMINE_URL", $this->remotepath . "/datasets/whattomine");

		$config = "<?php\n\n" .
		    "define('DBNAME', 'test');\n" .
		    "define('DBHOST', 'localhost');\n" .
		    "define('DBPASS', 'J-65tv14cn');\n" .
		    "define('DBUSER', 'root');\n\n" .
		    "define('FILES_COINMARKETCAP_URL', '" . $this->remotepath . "/datasets/files" . "');\n" .
		    "define('WHATTOMINE_URL', '" . $this->remotepath . "/datasets/whattomine" . "');\n" .
		    "define('BLOCKCHAIR_URL', '" . $this->blockchair . "');\n" .
		    "define('COINMARKETCAP_URL', '" . $this->coinmarketcap . "');\n\n" .
		    "?>";

		$this->configname = __DIR__ . "/config.php";
		file_put_contents($this->configname, $config);

		define("DBNAME", "test");
		define("DBUSER", "root");
		define("DBPASS", "J-65tv14cn");
		define("DBHOST", "localhost");

		exec("mysql -u root -pJ-65tv14cn --database=test < " . __DIR__ . "/sql/crypto100.sql");
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

		$sql = SQL::get("MySQL");
		$sql->exec("DROP TABLE `crypto100`");
		unlink($this->configname);
	    } //end tearDown()


	/**
	 * Should allow to get saved crypto rating data
	 *
	 * @return void
	 */

	public function testShouldAllowToGetSavedCryptoRatingData()
	    {
		exec("php " . __DIR__ . "/../Run.php " . $this->configname);

		$expected = json_decode(file_get_contents(__DIR__ . "/expected_with_wp.json"), true);

		$storage = new Storage();
		$last    = $storage->getLast();
		$this->assertEquals($expected, $last);
	    } //end testShouldAllowToGetSavedCryptoRatingData()


    } //end class


?>