<?php
class Some
{
    public static function subtest(resource $svar, string $sany, object $sololo)
    {
        echo 23 . "\n";
    }
}

Some::subtest(
    fopen(__FILE__, 'r'),
    'asdasd',
    (object)['asd' => 23]
);

try {
    Some::subtest(
        fopen(__FILE__, 'r'),
        'asdasd',
        ['asd' => 23] // NOT OBJECT == Exception
    );
} catch (\Exception $e) {
    echo 'Exception: ' . $e->getMessage() . "\n";
}


/*
 * ANOTHER TESTS
 */

function test(int $tsome, $tany = 42)
{
    echo $tsome . ' : ' . $tany . "\n";
}
test(42);
test(23, 42);

try {
    test('error string'); // Exception
} catch (\TypeException $e) {
    echo 'Exception: ' . $e->getMessage(). "\n\n";
}


/*
 * AVAILABLE CASTS
 */
echo 'CASTS: ' . implode(', ', \Mirror\Runtime\TypeCasting::getTypeCasts());





/*** Result: ***
23
Exception: Value `Array([asd] => 23)` is not object
42 : 42
23 : 42
Exception: Value `error string` is not integer

CASTS: int, integer, str, string, object, res, resource, array, double, float, scalar, callable, func, bool, boolean
 */