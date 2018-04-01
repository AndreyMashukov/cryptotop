<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace Tests;

/**
 * Search blockchair responder
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 * @version SVN: $Date: 2018-01-09 11:09:44 +0300 (Tue, 09 Jan 2018) $ $Revision: 2 $
 * @link    $HeadURL: https://svn.btcdaily.ru/crypto100/trunk/tests/datasets/blockchair/index.php $
 */

echo file_get_contents(__DIR__ . "/search?q=" . preg_replace("/\s+/ui", "+", $_GET["q"]) . "/index.html");

?>