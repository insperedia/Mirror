PHP Mirror
==========
http://phpmirror.org/

[see](https://github.com/SerafimArts/Mirror/blob/master/CHANGELOG.md)

#### Использование:

    <?php
    require('phar://mirror.phar');   // или "lib/Mirror/bootstrap.php"
    require_mirror('filename.php');  // указанный файл и все вложенные (с помощью include\require + *_once) будут поддерживать синтаксис Mirror. Так же можно использовать фильтр: "require 'php://filter/read=mirror.filter/resource=FILENAME';"

- Краткие примеры возможностей доступны в каталоге *examples*
- Полное описание всего и вся, возможность добавить идею, обсуждения и проч. будет скоро доступно по основному сайту: http://phpmirror.org/


З.Ы. Котаны, у меня работа, семья и пара проектов, так что могу тормозить немного с фиксами\билдами, без обид :3

#### Системные требования:

* PHP 5.4+
* Расширения: Не требуются
* Для пересборки .phar архива (lib/Mirror/bin/Phar.php) требуется "phar.readonly = Off" значение в php.ini
* Обратная совместимость: Полная (пока что)
