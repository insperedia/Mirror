<?php
/**
 * Author: Serafim
 * Date: 09.07.13 12:50
 * Package: Mirror bootstrap.php 
 */
if (defined('__PHAR_ARCHIVE__')) {
    define('__PHAR_CACHE__', str_replace(
        'phar://', '', dirname(__DIR__)
    ));
}

require __DIR__ . '/Helpers/bootstrap.php';