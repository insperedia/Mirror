<?php
class Some
{
    public static function __init()
    {
        echo 'Вызов метода из класса' . "\n";
    }
}

function __init()
{
    echo 'Тупо функция (не должна вызываться)' . "\n";
}

class Any
{
    public function __init()
    {
        echo 'Просто метод - не должен взываться' . "\n";
    }
}

class Some1
{
    static function __init()
    {
        echo 'Метод без указания public' . "\n";
    }
}

class Any1
{
    private static function __init()
    {
        echo 'Метод с private модификатором' . "\n";
    }
}

class Any2
{
    protected static function __init()
    {
        echo 'Метод с protected модификатором' . "\n";
    }
}

class Some2
{
    static public function __init()
    {
        echo 'Метод с модификаторами "наоборот"' . "\n";
    }
}

