<?php
/**
 * Author: Serafim
 * Date: 09.07.13 15:26
 * Package: Mirror Filter.php 
 */
namespace Mirror;

/**
 * Class Filter
 * @package Mirror
 */
class Filter extends \php_user_filter
{
    /**
     * Filter name
     */
    const NAME = 'mirror.filter';

    /**
     * Filter string
     */
    const FILTER = 'php://filter/read=%s/resource=%s';

    /**
     * Filter resource prefix
     */
    const FILTER_PREFIX = 'filter#';

    /**
     * Register new filter
     * @throws \FilterException
     */
    public static function __init()
    {
        try {
            stream_filter_register(self::NAME, __CLASS__);
        } catch (\Exception $e) {
            throw new \FilterException($e);
        }
    }

    /**
     * Filter callbacks
     * @var array
     */
    private static $_filter = [];

    /**
     * Filter function => php_user_filter
     * @param $in
     * @param $out
     * @param $consumed
     * @param $closing
     * @return int|void
     */
    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            foreach (self::$_filter as $filter) {
                $bucket->data = $filter($bucket->data, self::$_path);
            }
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return !$closing ? PSFS_PASS_ON : PSFS_FEED_ME;
    }

    /**
     * Add filter callback
     * @param $filter
     * @return resource
     */
    public static function subscribe($filter)
    {
        $id = self::FILTER_PREFIX . count(self::$_filter);
        self::$_filter[$id] = $filter;
        return $id;
    }

    /**
     * Remove filter by filter resource
     * @param $id
     * @return true
     * @throws \OverflowException
     * @throws \TypeException
     */
    public static function remove($id)
    {
        if (!preg_match('%' . self::FILTER_PREFIX . '[0-9]+%is', $id)) {
            throw new \TypeException("Variable `${id}` is not filter resource");
        }
        if (!isset(self::$_filter[$id])) {
            throw new \OverflowException('Can not remove filter. Filter not found.');
        }
        unset(self::$_filter[$id]);
        return true;
    }

    /**
     * Current filter file path
     * @var string
     */
    private static $_path = '';

    /**
     * Return filter path
     * @param $path
     * @return string
     */
    public static function get($path)
    {
        self::$_path = realpath($path);
        return sprintf(self::FILTER, self::NAME, $path);
    }
}
Filter::__init();