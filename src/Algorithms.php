<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace AM\CryptoTop;

/**
 * Grabber of mining algorithms
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 */

class Algorithms
    {

	/**
	 * Algo grabber
	 *
	 * @var AlgoGrabber
	 */
	private $_grabber;

	/**
	 * Prepare class to work
	 *
	 * @return void
	 */

	public function __construct()
	    {
		if (defined("ALGO_GRABBER_CLASS") === true)
		    {
			$grabber = ALGO_GRABBER_CLASS;
		    }
		else
		    {
			$grabber = \AM\CryptoTop\AlgoGrabberJson::class;
		    } //end if

		$this->_grabber = new $grabber();
	    } //end __construct()


	/**
	 * Get mining algorithms
	 *
	 * @return array Mining algorithms with currencies tickers
	 */

	public function get():array
	    {
		$asic = $this->_grabber->getAlgorithm("asic");
		$gpu  = $this->_grabber->getAlgorithm("gpu");

		return array_merge($asic, $gpu);
	    } //end get()


    } //end class


?>
