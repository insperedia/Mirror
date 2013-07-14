<?php
/**
 * Author: Serafim
 * Date: 14.07.13 1:29
 * Package: Mirror FileAdaptor.php
 */
namespace Mirror\Cache;

use Mirror\Cache;

/**
 * Class FileAdaptor
 * @package Mirror\Cache
 */
class FileAdaptor implements CacheInterface
{
    /**
     * Cache path
     */
    const PATH      = '.cache/';

    /**
     * Check cache (false == need update, true == return from cache)
     * @param $path
     * @return bool
     */
    public function has($path)
    {
        return
            file_exists($this->_getCachePath($path)) &&
            $this->_checkTimestamp($path);
    }

    /**
     * Return cache data
     * @param $path
     * @return string
     */
    public function get($path)
    {
        return file_get_contents($this->_getCachePath($path));
    }

    /**
     * Set new cache
     * @param $path
     * @param $data
     * @return mixed|void
     */
    public function set($path, $data)
    {
        return file_put_contents($this->_getCachePath($path), $data);
    }

    /**
     * Check cache timestamp
     * @param $path
     * @return bool
     */
    private function _checkTimestamp($path)
    {
        return filemtime($this->_getCachePath($path)) >= filemtime($path);
    }

    /**
     * Hashes
     * @var array
     */
    private $_hashes = [];
    /**
     * Convert path to hash
     * @param $path
     * @return string
     */
    private function _getCachePath($path)
    {
        if (isset($this->_hashes[$path])) {
            return $this->_hashes[$path];
        }

        $dir = (defined('__PHAR_ARCHIVE__'))
            ? __PHAR_CACHE__ . __DS__ . self::PATH
            : __DIR__ . __DS__ . self::PATH;
        if (!is_dir($dir)) { mkdir($dir, 0777, true); }

        $hash = $dir . md5($path);
        $this->_hashes[$path] = $hash;
        return $hash;
    }
}