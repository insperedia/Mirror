<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Serafim
 * Date: 17.07.13 13:47
 * Package: Mirror Import.php 
 */
namespace Mirror\Glass\Std;

use Mirror\Autoloader;
use Mirror\Finder;
use Mirror\Finder\Group;

class Import
{
    private $_tokens = [];

    public function __construct($tokens)
    {
        $this->_tokens = $tokens;
        $scopes = (new Finder('import', ';', $tokens, Finder::TYPE_CONTENT))->getScopes();
        foreach ($scopes as $s) {
            $s->delete();
            $nameArray = array_slice($s->find([T_STRING, T_NS_SEPARATOR]), 1);
            $name = '';
            foreach ($nameArray as $token) {
                $name .= $token->getContent();
            }
            $this->_import($name, $nameArray[0]);
        }
    }

    /**
     * Подгружает новую призму
     * @param $name
     * @param $token
     * @return mixed
     * @throws \ImportException
     */
    private function _import($name, $token)
    {
        $ns = '\\Mirror\\' . $name;
        if (Autoloader::checkClass($ns)) {
            return new $ns($this->_tokens);
        }
        $line = $token->getLine();
        $file = $token->getSourceFile();
        throw new \ImportException("Can not import glass `${name}`. In file ${file} on line ${line}.");
    }
}