<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace AM\CryptoTop;

use \DateTime;
use \DateTimezone;
use \Logics\Foundation\SQL\SQL;

/**
 * Grabber service starter
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 */

set_time_limit(0);

if (isset($argv) === false) {
    $argv = [];
} //end if

$name = md5(implode("_", $argv));

if (file_exists(__DIR__ . "/cron/" . $name) === true) {
    $pid = file_get_contents(__DIR__ . "/cron/" . $name);
    if (posix_kill($pid, 0)) {
        exit();
    } //end if

} //end if

$pid = posix_getpid();
file_put_contents(__DIR__ . "/cron/" . $name, $pid);

// Config path is first parameter from CLI

$config = $argv[1];

require_once __DIR__ . "/vendor/autoload.php";
require_once $config;

$rating = new CryptoRatingWithWP();
$result = $rating->get();

if ($rating->validate($result) === true) {
    $json = json_encode($result);

    $now = new DateTime("now", new DateTimezone("UTC"));
    $sql = SQL::get("MySQL");
    $sql->exec("INSERT INTO `crypto100` " .
        "SET `data` = " . $sql->sqlText($json) . ", " .
        "`date` = " . $sql->sqlText($now->format("Y-m-d H:i:s"))
    );
} //end if

?>
