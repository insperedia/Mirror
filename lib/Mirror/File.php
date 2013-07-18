<?php
/**
 * Author: Serafim
 * Date: 11.07.13 18:17
 * Package: Mirror File.php 
 */
namespace Mirror;

use Mirror\Cache;
use Mirror\Tokenizer;
use Mirror\Filter;

/**
 * Class File
 * @package Mirror
 */
class File
{
    /**
     * Subscribe on filter
     */
    public static function __init($adaptor)
    {
        $adaptor    = '\\Mirror\\Cache\\' . $adaptor;
        $cache      = new Cache(new $adaptor());

        Filter::subscribe(function($source, $path) use ($cache){
            if ($cache->has($path)) {
                return $cache->get($path);
            }
            $data = (new Tokenizer($source, $path))->getData();
            $cache->set($path, $data);
            return $data;
        });
    }

    /**
     * New Mirror file
     * @param string $path
     */
    public function __construct($path)
    {
        require Filter::get($path);
    }
}