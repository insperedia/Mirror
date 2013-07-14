PHP Mirror
==========
http://serafimarts.github.io/Mirror/

#### Использование:

    <?php
    require('phar://mirror.phar');   // или "lib/Mirror/bootstrap.php"
    require_mirror('filename.php');  // указанный файл и все вложенные (с помощью include\require + *_once) будут поддерживать синтаксис Mirror. Так же можно использовать фильтр: "require 'php://filter/read=mirror.filter/resource=FILENAME';"

* [Главная Вики] (https://github.com/SerafimArts/Mirror/wiki)
* @draft [Приведение типов](https://github.com/SerafimArts/Mirror/wiki/Type-Casting)
* @todo [Свойства](https://github.com/SerafimArts/Mirror/wiki/Properties)
* @todo [Перечисления](https://github.com/SerafimArts/Mirror/wiki/Enum)
* @todo [Аспекты](https://github.com/SerafimArts/Mirror/wiki/Aspects)
* @todo Именованные параметры
* @todo Упращенное объявление области видимости свойств\методов

#### Системные требования:

* PHP 5.4+
* Расширения: Не требуются
* Для пересборки .phar архива (lib/Mirror/bin/Phar.php) требуется "phar.readonly = Off" значение в php.ini
* Обратная совместимость: Полная (пока что)
