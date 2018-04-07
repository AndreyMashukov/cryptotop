<?php

/**
 * PHP version 7.1
 *
 * @package AM\CryptoTop
 */

namespace AM\CryptoTop;

use \Logics\Foundation\SQL\SQL;

/**
 * Storage of crypto rating
 *
 * @author  Andrey Mashukov <a.mashukoff@gmail.com>
 */
class Storage
{

    /**
     * Get last crypto currency rating
     *
     * @return array Last rating
     */

    public function getLast(): array
    {
        $last = [];

        $sql    = SQL::get("MySQL");
        $result = $sql->exec("SELECT `data` FROM `crypto100` " .
            "ORDER BY `date` DESC LIMIT 1");

        $row = $result->getRow();
        if (isset($row["data"]) === true) {
            $last = json_decode($row["data"], true);
        } //end if

        return $last;
    } //end getLast()


} //end class

?>
