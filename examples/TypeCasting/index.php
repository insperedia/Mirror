<?php
set_include_path(__DIR__ . '/../');
define('MIRROR_NO_CACHE', 1);
#require('lib/Mirror/bootstrap.php');
require 'phar://../Z:/home/Mirror/mirror.phar';
echo Mirror::getVersion();
