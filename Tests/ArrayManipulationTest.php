<?php

namespace MulerTech\ArrayManipulation\Tests;

use MulerTech\ArrayManipulation\ArrayManipulation;
use PHPUnit\Framework\TestCase;

class ArrayManipulationTest extends TestCase
{
    public function testIsAssociative()
    {
        static::assertTrue(ArrayManipulation::isAssoc(['a' => 'b', 'c' => 'd']));
    }

    public function testIsList()
    {
        static::assertTrue(ArrayManipulation::isList([0 => 'a', 1 => 'b', 2 => 'c']));
    }

    public function testAddNumberKey()
    {
        static::assertEquals(
            [0 => ['name' => 'toto', 'number' => 1], 1 => ['name' => 'titi', 'number' => 2]],
            ArrayManipulation::addNumberKey([0 => ['name' => 'toto'], 1 => ['name' => 'titi']])
        );
    }

    public function testListOfDuplicates()
    {
        static::assertEquals([33, 806], ArrayManipulation::listOfDuplicates([1, 2, 3, 33, 8, 33, 4, 806, 402, 806]));
    }

    public function testListOfDuplicatesEmptyArray()
    {
        static::assertEquals([], ArrayManipulation::listOfDuplicates([]));
    }

    public function testFindDifferencesByName()
    {
        $first = ['akey' => 'avalue', 'anotherkey' => 'secondvalue', 'thirdkey' => 'oldvalue'];
        $second = ['akey' => 'avalue', 'anotherkey' => 'notsamevalue', 'thirdkey' => 'newvalue'];
        $expected = [
            'anotherkey' => ['secondvalue', 'notsamevalue'],
            'thirdkey' => ['oldvalue', 'newvalue']
        ];
        static::assertEquals($expected, ArrayManipulation::findDifferencesByName($first, $second));
    }

    public function testOrderByOneColumn()
    {
        $array = [
            0 => ['firstcolumn' => 'apple', 'secondcolumn' => 'zorro'],
            1 => ['firstcolumn' => 'banana', 'secondcolumn' => 'superman'],
            2 => ['firstcolumn' => 'cherry', 'secondcolumn' => 'batman'],
            3 => ['firstcolumn' => 'coconut', 'secondcolumn' => 'alibaba'],
            4 => ['firstcolumn' => 'pineapple', 'secondcolumn' => 'Tom sawyer']
        ];
        $expected = [
            0 => ['firstcolumn' => 'coconut', 'secondcolumn' => 'alibaba'],
            1 => ['firstcolumn' => 'cherry', 'secondcolumn' => 'batman'],
            2 => ['firstcolumn' => 'banana', 'secondcolumn' => 'superman'],
            3 => ['firstcolumn' => 'pineapple', 'secondcolumn' => 'Tom sawyer'],
            4 => ['firstcolumn' => 'apple', 'secondcolumn' => 'zorro']
        ];
        static::assertEquals($expected, ArrayManipulation::orderByColumn($array, 'secondcolumn'));
    }

    public function testOrderByTwoColumns()
    {
        $array = [
            0 => ['firstcolumn' => 'apple', 'secondcolumn' => 'zorro', 'thirdcolumn' => 'masked man'],
            1 => ['firstcolumn' => 'banana', 'secondcolumn' => 'superman', 'thirdcolumn' => 'masked man'],
            2 => ['firstcolumn' => 'cherry', 'secondcolumn' => 'batman', 'thirdcolumn' => 'masked man'],
            3 => ['firstcolumn' => 'coconut', 'secondcolumn' => 'alibaba', 'thirdcolumn' => 'unmasked man'],
            4 => ['firstcolumn' => 'pineapple', 'secondcolumn' => 'Tom sawyer', 'thirdcolumn' => 'unmasked man']
        ];
        $expected = [
            0 => ['firstcolumn' => 'coconut', 'secondcolumn' => 'alibaba', 'thirdcolumn' => 'unmasked man'],
            1 => ['firstcolumn' => 'pineapple', 'secondcolumn' => 'Tom sawyer', 'thirdcolumn' => 'unmasked man'],
            2 => ['firstcolumn' => 'cherry', 'secondcolumn' => 'batman', 'thirdcolumn' => 'masked man'],
            3 => ['firstcolumn' => 'banana', 'secondcolumn' => 'superman', 'thirdcolumn' => 'masked man'],
            4 => ['firstcolumn' => 'apple', 'secondcolumn' => 'zorro', 'thirdcolumn' => 'masked man']
        ];
        static::assertEquals($expected, ArrayManipulation::orderByColumn($array, 'thirdcolumn', 'desc', 'secondcolumn'));
    }

    public function testAddValueInAssociativeSimpleArray()
    {
        $test = ['key' => 'value'];
        $expected = ['key' => 'value', 'keytoadd' => 'value to add'];

        $this->assertEquals($expected, ArrayManipulation::addKeyValue($test, 'keytoadd', 'value to add'));
    }

    public function testAddValueInAssociativeArray()
    {
        $test = [
            'key'=> [
                'subKey' => 'subValue'
            ],
        ];

        $expected = [
            'key'=> [
                'subKey' => 'subValue',
                'subKeyToAdd' => 'value to add'
            ],
        ];

        $this->assertEquals($expected, ArrayManipulation::addKeyValue($test, 'subKeyToAdd', 'value to add', 'key'));
    }

    public function testAddValueInNumericArray()
    {
        $test = [
            'key'=> [
                'value'
            ],
        ];

        $expected = [
            'key'=> [
                'value',
                'value to add'
            ],
        ];

        $this->assertEquals($expected, ArrayManipulation::addKeyValue($test, 'key', 'value to add'));
    }

    public function testAddKeyValue()
    {
        $test = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b'
                ]
            ]
        ];
        $expected = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b',
                    'keytoaddvalue' => 'value to add'
                ]
            ]
        ];
        $this->assertEquals($expected, ArrayManipulation::addKeyValue($test, 'keytoaddvalue', 'value to add', 'subtest3', 'othersub'));
    }

    public function testAddKeyValueWithFirstNumericArray()
    {
        $test = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b'
                ]
            ]
        ];
        $expected = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b',
                    'keytoaddvalue' => ['a first value']
                ]
            ]
        ];
        $this->assertEquals($expected, ArrayManipulation::addKeyValue($test, 'keytoaddvalue', ['a first value'], 'subtest3', 'othersub'));
    }

    public function testAddKeyValueWithSecondNumericArray()
    {
        $test = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b',
                    'keytoaddvalue' => ['a first value']
                ]
            ]
        ];
        $expected = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b',
                    'keytoaddvalue' => ['a first value', 'an other value']
                ]
            ]
        ];
        $this->assertEquals($expected, ArrayManipulation::addKeyValue($test, 'keytoaddvalue', 'an other value', 'subtest3', 'othersub'));
    }

    public function testRemoveSimpleKey()
    {
        $test = [
            'key' => 'value',
        ];

        $this->assertEquals([], ArrayManipulation::removeKey($test, 'key'));
    }
    public function testRemoveKey()
    {
        $test = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b',
                    'keytoremove' => 'goodbye'
                ]
            ]
        ];
        $expected = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
            'subtest2' => [
                'subsubsecondtest1' => 'another value a',
                'subsubsecondtest2' => 'another value b',
                'subsubsecondtest3' => 'another value c',
                'subsubsecondtest4' => 'another value d',
            ],
            'subtest3' => [
                'othersub' => [
                    'subsubsub1' => 'value a',
                    'subsubsub2' => 'value b',
                ]
            ]
        ];
        $this->assertEquals($expected, ArrayManipulation::removeKey($test, 'subtest3', 'othersub', 'keytoremove'));
    }

    public function testRemoveKeyNotExists()
    {
        $test = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
        ];
        $expected = [
            'subtest1' => [
                'subsubtest1' => 'a value',
                'subsubtest2' => 'b value',
                'subsubtest3' => 'c value'
            ],
        ];
        $this->assertEquals($expected, ArrayManipulation::removeKey($test, 'subtest3', 'othersub', 'keytoremove'));
    }
}
