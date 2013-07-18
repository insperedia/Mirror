<?php
/**
 * Author: Serafim
 * Date: 09.07.13 1:38
 * Package: Mirror Autoloader.php
 */
namespace Mirror;

/**
 * Class Autoloader
 * @package Mirror
 */
class Autoloader
{
    /**
     * Register autoloader
     */
    public static function register()
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Preload class from Mirror package
     * @param $class
     * @throws \PathException
     */
    public static function autoload($class)
    {
        $namespace = explode(__NS__, __CLASS__)[0];
        if (!self::_checkClass($namespace, $class)) { return; }
        $path = self::_getClassPath($class);
        if (file_exists($path)) {
            require $path;
            return;
        }
        throw new \PathException("Can not preload class ${class}. File ${path} not exists");
    }

    /**
     * Проверка существования класса
     * @param $name
     * @return bool
     */
    public static function checkClass($name)
    {
        try {
            return class_exists($name);
        } catch(\PathException $e) {
            return false;
        }
    }

    /**
     * Check autoload class is subclass of current package
     * @param $namespace
     * @param $class
     * @return bool
     */
    private static function _checkClass($namespace, $class)
    {
        if (strpos($class, $namespace) !== 0) {
            return false;
        }
        return true;
    }

    /**
     * Return include path by class name
     * @param $class
     * @return string
     */
    private static function _getClassPath($class)
    {
        $path = implode(__DS__, array_slice(explode(__NS__, $class), 1));
        return __DIR__ . __DS__ . $path . '.php';
    }
}