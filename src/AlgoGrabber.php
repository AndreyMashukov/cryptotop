<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace AM\CryptoTop;

/**
 * Abstract algorithms grabber
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 */
abstract class AlgoGrabber
{

    /**
     * Get mining algorithm list
     *
     * @param string $device Type of mining device
     *
     * @return array Mining algorithms
     */

    abstract public function getAlgorithm(string $device): array;


} //end class

?>
