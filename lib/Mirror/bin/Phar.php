<?php
/**
 * Author: Serafim
 * Date: 13.07.13 18:18
 * Package: Mirror Phar.php 
 */
namespace Mirror;

require __DIR__ . '/../bootstrap.php';

class Phar
{
    const NAME = '../mirror.phar';
    const PATH = 'Mirror';
    const STUB = 'bootstrap.php';
    const PHAR_SIGN = "\ndefine('__PHAR_ARCHIVE__', true);\n";
    const HALT = "\n__halt_compiler();\n";

    public static function __init()
    {
        $t = microtime(1);
        try {
            if (file_exists(self::dir(self::NAME))) {
                echo 'Phar archive already exists.' . "\n";
                echo 'Remove previous version: ';
                if (file_exists(self::dir(self::NAME) . '.tmp')) {
                    unlink(self::dir(self::NAME) . '.tmp');
                }
                if(!rename(self::dir(self::NAME), self::dir(self::NAME) . '.tmp')) {
                    echo "\n";
                    self::_sayStatus($t, false);
                }
                echo 'OK' . "\n\n";
            }

            $phar = new \Phar(self::dir(self::NAME));
            $phar->buildFromDirectory(
                self::dir(self::PATH . __DS__)
            );
            $phar->delete(self::STUB);
            $content = file_get_contents(self::dir(self::PATH . __DS__ . self::STUB));
            $phar->addFromString(
                self::STUB,
                str_replace('<?php', '<?php' . self::PHAR_SIGN, $content . self::HALT)
            );
            $phar->setDefaultStub(self::STUB);
        } catch(\Exception $e) {
            echo 'Error: ' . ucfirst($e->getMessage()) . "\n";
            self::_sayStatus($t, false);
        }
        self::_sayStatus($t);
        flush();
        self::test();
    }

    private static function _sayStatus($t, $success = true)
    {
        if ($success && file_exists(self::dir(self::NAME) . '.tmp')) {
            unlink(self::dir(self::NAME) . '.tmp');
        } else if (!$success && file_exists(self::dir(self::NAME) . '.tmp')) {
            echo 'Revert previous phar archive.' . "\n";
            if (file_exists(self::dir(self::NAME))) {
                chmod(self::dir(self::NAME) . '.tmp', 666);
                unlink(self::dir(self::NAME));
            }
            rename(self::dir(self::NAME) . '.tmp', self::dir(self::NAME));
        }

        $t  = number_format(microtime(1) - $t, 3) * 1000;
        $ts = date('H:i:s');
        $m = $success ? 'successfully finished' : 'failed';
        echo "Compilation ${m} at ${ts}.\nCompilation time: ${t} ms.\n\n";

        if (!$success) {
            exit(-1);
        }
    }

    private static function test()
    {
        echo "==== run tests ====\n";

        { # create phar iterator
            $iterator   = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator('phar://' . self::dir(self::NAME) . '/')
            );
            $iteratorSize = 0;
            $iteratorFileSize = 0;
            foreach ($iterator as $i)   { if($i->isFile()){
                $iteratorSize++;
                $iteratorFileSize += $i->getSize();
            } }
        }

        { # create source dir iterator
            $target     = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(self::dir(self::PATH))
            );
            $targetSize = 0;
            $targetFileSize = 0;
            foreach ($target as $i)     { if($i->isFile()){
                $targetSize++;
                $targetFileSize += $i->getSize();
            } }
        }

        echo 'Files: ' .
            ($iteratorSize) . ' / ' . ($targetSize) .
            ' (phar/target)' . ".\n" .
            'Status: ' . (
                (
                    ($iteratorSize) > 0 &&
                    ($iteratorSize) === ($targetSize)
                ) ? 'OK' : 'Failed'
            ) . ".\n\n";

        echo 'Size: ' .
            ($iteratorFileSize) . ' bytes + ' . (strlen(self::PHAR_SIGN) + strlen(self::HALT))
            . ' bytes / ' . ($targetFileSize) . ' bytes' .
            ' (phar + signature/target)' . ".\n" .
            'Status: ' . (
                (
                    ($iteratorFileSize) > 0 &&
                    ($iteratorFileSize - (strlen(self::PHAR_SIGN) + strlen(self::HALT))) == ($targetFileSize)
                ) ? 'OK' : 'Failed'
            ) . ".\n\n";
    }

    private static function dir($path = '')
    {
        return str_replace(
            ['/', '\\'],
            __DS__,
            __DIR__ . __DS__ . '../../' . $path
        );
    }

}
Phar::__init();