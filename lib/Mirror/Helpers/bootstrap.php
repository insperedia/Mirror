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
    const VERSION = '0.0.1 beta';

    const MINIMAL_PHP_VERSION = '5.4';

    /**
     * Initialize glasses
     * @var array
     */
    private static $_initGlasses = [
        'Std\\Includes',
        'Std\\TypeCasting',
        'Std\\Init',
        'Std\\Import'
    ];

    /**
     * Init exceptions
     * @var array
     */
    private static $_initExceptions = [
        'FilterException',
        'PathException',
        'TypeException',
        'ImportException'
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
        foreach (self::$_initExceptions as $e) {
            require __DIR__ . "/../Exceptions/${e}.php";
        }

        require __DIR__ . '/defines.php';
        require __DIR__ . '/../Autoloader.php';

        Mirror\Autoloader::register();
        Mirror\File::__init('FileAdaptor');
        self::$_initialized = true;
    }

    /**
     * Return Tokenizer version
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