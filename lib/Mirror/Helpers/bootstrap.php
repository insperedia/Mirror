<?php
/**
 * Author: Serafim
 * Date: 09.07.13 12:47
 * Package: Mirror bootstrap.php 
 */

/**
 * Class Mirror
 */
class Mirror
{
    const VERSION = '1.0.0';

    const MINIMAL_PHP_VERSION = '5.4';
    /**
     * Initialize glasses
     * @var array
     */
    private static $_initGlasses = [
        'Mirror\\Glass\\Std\\Includes',
        'Mirror\\Glass\\Std\\TypeCasting'
    ];

    /**
     * Initialized?
     * @var bool
     */
    private static $_initialized = false;

    /**
     * Initialize
     */
    public static function __init()
    {
        if (self::$_initialized) { exit(-1); }
        require __DIR__ . '/defines.php';
        require __DIR__ . '/../Autoloader.php';

        Mirror\Autoloader::register();
        Mirror\File::__init('FileAdaptor');
        self::$_initialized = true;
    }

    /**
     * Return core version
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Return default glasses
     * @return array
     */
    public static function getDefaultGlasses()
    {
        return self::$_initGlasses;
    }

    /**
     * Return minimal php version
     * @return string
     */
    public static function getMinPhpVersion()
    {
        return self::MINIMAL_PHP_VERSION;
    }
}
Mirror::__init();
function require_mirror($path) { return new Mirror\File($path); }
function include_mirror($path) { return new Mirror\File($path);  }