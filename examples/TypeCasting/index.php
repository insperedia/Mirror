<?php
define('MIRROR_NO_CACHE', 1);
#require('phar://../../mirror.phar');
require '../../lib/Mirror/bootstrap.php';
require_mirror('test.php');