<?php

namespace MulerTech\ArrayManipulation;

use RuntimeException;

/**
 * Class ArrayManipulation
 * @package MulerTech\ArrayManipulation
 * @author Sébastien Muler
 */
class ArrayManipulation
{
    /**
     * @param array<int|string, mixed> $array
     * @return bool
     */
    public static function isAssoc(array $array): bool
    {
        return !array_is_list($array);
    }

    /**
     * @param array<int|string, mixed> $array
     * @return bool
     */
    public static function isList(array $array): bool
    {
        return array_is_list($array);
    }

    /**
     * Find the duplicates and store it into the return array
     * @param array<int|string, mixed> $array
     * @return array<int, mixed>
     */
    public static function listOfDuplicates(array $array = []): array
    {
        return array_values(array_diff_assoc($array, array_unique($array)));
    }

    /**
     * Add a number key and the current number :
     * Example : [0 => ['name' => 'toto'], 1 => ['name' => 'titi']]
     * Becomes : [0 => ['name' => 'toto', 'number' => 1], 1 => ['name' => 'titi', 'number' => 2]]
     * @param array<int, array<string, mixed>> $array
     * @param string $indexNumber
     * @return array<int, array<string, mixed>>
     */
    public static function addNumberKey(array $array, string $indexNumber = 'number'): array
    {
        if (self::isAssoc($array)) {
            throw new RuntimeException(
                'Class ArrayManipulation, function addNumberKey. The array must be a list.'
            );
        }

        return array_map(
            static function ($value) use (&$i, $indexNumber) {
                $value[$indexNumber] = ++$i;
                return $value;
            },
            $array
        );
    }

    /**
     * Find differences between first and second array
     * Return array : [key_name => [first_value, second_value]]
     * @param array<int|string, mixed> $first
     * @param array<int|string, mixed> $second
     * @return array<int|string, array<int, mixed>>
     */
    public static function findDifferencesByName(array $first, array $second): array
    {
        $differences = [];
        $first = array_diff_assoc($first, $second);

        foreach ($first as $key => $value) {
            if ($value !== $second[$key]) {
                $differences[$key] = [$value, $second[$key]];
            }
        }

        return $differences;
    }

    /**
     * @param array<int, array<string, mixed>> $array
     * @param string $column
     * @param string $order 'asc' or 'desc' order
     * @param string|null $secondColumn
     * @param string|null $secondOrder
     * @return array<int, array<string, mixed>>
     */
    public static function orderByColumn(
        array $array,
        string $column,
        string $order = 'asc',
        ?string $secondColumn = null,
        ?string $secondOrder = null
    ): array {
        $arrayColumn = array_column($array, $column);
        $sortOrder = (strtolower($order) === 'asc') ? SORT_ASC : SORT_DESC;
        $sortFlag = SORT_FLAG_CASE | SORT_STRING;

        if ($secondColumn === null) {
            array_multisort($arrayColumn, $sortOrder, $sortFlag, $array);

            return $array;
        }

        $secondSort = ($secondOrder !== null && strtolower($secondOrder) === 'desc') ? SORT_DESC : SORT_ASC;

        array_multisort(
            $arrayColumn,
            $sortOrder,
            $sortFlag,
            array_column($array, $secondColumn),
            $secondSort,
            $sortFlag,
            $array
        );

        return $array;
    }

    /**
     * Add a key and its value into the array by following the key indexes.
     * @param array<int|string, mixed> $array
     * @param string $key
     * @param mixed $value
     * @param string ...$index
     * @return array<int|string, mixed>
     */
    public static function addKeyValue(array $array, string $key, mixed $value, string ...$index): array
    {
        if (empty($index)) {
            if (isset($array[$key]) && self::isList($array[$key])) {
                $array[$key][] = $value;
                return $array;
            }

            $array[$key] = $value;
            return $array;
        }

        $firstIndex = array_shift($index);

        $array[$firstIndex] = self::addKeyValue($array[$firstIndex], $key, $value, ...$index);

        return $array;
    }

    /**
     * Remove a key and its value into the array by following the key indexes.
     * @param array<int|string, mixed> $array
     * @param string ...$index
     * @return array<int|string, mixed>
     */
    public static function removeKey(array $array, string ...$index): array
    {
        if (empty($index)) {
            return $array;
        }

        $firstIndex = array_shift($index);

        if (!empty($index) && !empty($array[$firstIndex])) {
            $array[$firstIndex] = self::removeKey($array[$firstIndex], ...$index);

            return $array;
        }

        if (!empty($array[$firstIndex])) {
            unset($array[$firstIndex]);
        }

        return $array;
    }
}
