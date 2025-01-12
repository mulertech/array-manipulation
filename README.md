
# ArrayManipulation

___
[![Latest Version on Packagist](https://img.shields.io/packagist/v/mulertech/array-manipulation.svg?style=flat-square)](https://packagist.org/packages/mulertech/array-manipulation)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mulertech/array-manipulation/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mulertech/array-manipulation/actions/workflows/tests.yml)
[![GitHub PHPStan Action Status](https://img.shields.io/github/actions/workflow/status/mulertech/array-manipulation/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/mulertech/array-manipulation/actions/workflows/phpstan.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/mulertech/array-manipulation.svg?style=flat-square)](https://packagist.org/packages/mulertech/array-manipulation)
[![Test Coverage](https://raw.githubusercontent.com/mulertech/array-manipulation/main/badge-coverage.svg)](https://packagist.org/packages/mulertech/array-manipulation)
___

This class manipulates and organizes arrays

___

## Installation

###### _Two methods to install Application package with composer :_

1.
Add to your "**composer.json**" file into require section :

```
"mulertech/array-manipulation": "^2.0"
```

and run the command :

```
php composer.phar update
```

2.
Run the command :

```
php composer.phar require mulertech/array-manipulation "^2.0"
```

___

## Usage

<br>

###### _Check if an array is associative or not :_

```
ArrayManipulation::isAssoc([['name' => 'john'], ['name' => 'jack']]);

// true
```

<br>

###### _Check if an array is list or not :_

```
ArrayManipulation::isList([1, 2, 3, 4, 5]);

// true
```

<br>

###### _List of duplicates values :_

```
ArrayManipulation::listOfDuplicates([1, 2, 3, 33, 8, 33, 4, 806, 402, 806]);

// [33, 806]
```

<br>

###### _Add a "number" key (or another name) and its number into an associative array :_

```
ArrayManipulation::addNumberKey([['name' => 'john'], ['name' => 'jack']]);

// [['name' => 'john', 'number' => 1], ['name' => 'jack', 'number' => 2]]
```

<br>

###### _Find differences by name (it can be used to compare old and new array) :_

```
$first =  ['akey' => 'avalue', 'anotherkey' => 'secondvalue',  'thirdkey' => 'oldvalue'];
$second = ['akey' => 'avalue', 'anotherkey' => 'notsamevalue', 'thirdkey' => 'newvalue'];
ArrayManipulation::findDifferencesByName($first, $second);

// ['anotherkey' => ['secondvalue', 'notsamevalue'], 'thirdkey' => ['oldvalue', 'newvalue']];
```

<br>

###### _Order by one or two column (you can choose the name of the columns and the asc or desc order for each) :_

```
$array = [
    ['firstcolumn' => 'apple', 'secondcolumn' => 'zorro', 'thirdcolumn' => 'masked man'],
    ['firstcolumn' => 'banana', 'secondcolumn' => 'superman', 'thirdcolumn' => 'masked man'],
    ['firstcolumn' => 'cherry', 'secondcolumn' => 'batman', 'thirdcolumn' => 'masked man'],
    ['firstcolumn' => 'coconut', 'secondcolumn' => 'alibaba', 'thirdcolumn' => 'unmasked man'],
    ['firstcolumn' => 'pineapple', 'secondcolumn' => 'Tom sawyer', 'thirdcolumn' => 'unmasked man']
];

ArrayManipulation::orderByColumn($array, 'thirdcolumn', 'desc', 'secondcolumn'); // default order is asc

// result :
[
    ['firstcolumn' => 'coconut', 'secondcolumn' => 'alibaba', 'thirdcolumn' => 'unmasked man'],<br>
    ['firstcolumn' => 'pineapple', 'secondcolumn' => 'Tom sawyer', 'thirdcolumn' => 'unmasked man'],<br>
    ['firstcolumn' => 'cherry', 'secondcolumn' => 'batman', 'thirdcolumn' => 'masked man'],<br>
    ['firstcolumn' => 'banana', 'secondcolumn' => 'superman', 'thirdcolumn' => 'masked man'],<br>
    ['firstcolumn' => 'apple', 'secondcolumn' => 'zorro', 'thirdcolumn' => 'masked man'],<br>
];
```

<br>

###### _Add a value into an array by indicated the key, the value and keys up to final key,_
###### _it can create the final key or add the value into an array in this final key :_

1. Add a key and its value :

```
$array = [
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

ArrayManipulation::addKeyValue($array, 'keytoaddvalue', ['a first value'], 'subtest3', 'othersub');

// result :
[
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
```

2. Add a value to an existing key :

```
$array = [
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

ArrayManipulation::addKeyValue($array, 'keytoaddvalue', 'an other value', 'subtest3', 'othersub');

// result :
[
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
```

<br>

###### _Remove a key and its value into an array by indicated the key and keys up to final key :_

```
$array = [
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

ArrayManipulation::removeKey($array, 'subtest3', 'othersub', 'keytoremove');

// Result :
[
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
```
