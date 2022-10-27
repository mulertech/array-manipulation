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
     * @param array $array
     * @return bool
     */
    public function isAssociativeArray(array $array): bool
    {
        return !array_key_exists(0, $array);
    }

    /**
     * Find the duplicates and store it into the return array
     * @param array $array
     * @return array
     */
    public static function listOfDuplicates(array $array = []): array
    {
        if (!empty($array)) {
            $count_values = array_count_values($array);
            return array_keys($count_values, 2);
        }
        return [];
    }

    /**
     * Add a number key and the current number :
     * Example : [0 => ['name' => 'toto'], 1 => ['name' => 'titi']]
     * Becomes : [0 => ['name' => 'toto', 'number' => 1], 1 => ['name' => 'titi', 'number' => 2]]
     * @param array $array
     * @param string $indexNumber
     * @return array
     */
    public static function addNumberKey(array $array, string $indexNumber = 'number'): array
    {
        $i = 1;
        foreach ($array as &$value) {
            $value[$indexNumber] = $i++;
        }
        return $array;
    }

    /**
     * Find differences between first and second array
     * Return array : [key_name => [first_value, second_value]]
     * @param array $first
     * @param array $second
     * @return array
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
     * @param array $array
     * @param string $column
     * @param string $order 'asc' or 'desc' order
     * @param string|null $second_column
     * @param string|null $second_order
     * @return array
     */
    public static function orderByColumn(
        array $array,
        string $column,
        string $order = 'asc',
        string $second_column = null,
        string $second_order = null
    ): array {
        $array_column = array_column($array, $column);
        if (empty($second_column)) {
            array_multisort(
                $array_column,
                (strtolower($order) === 'asc') ? SORT_ASC : SORT_DESC,
                 SORT_FLAG_CASE | SORT_STRING,
                $array
            );
        } else {
            $array_second_column = array_column($array, $second_column);
            array_multisort(
                $array_column,
                (strtolower($order) === 'asc') ? SORT_ASC : SORT_DESC,
                SORT_FLAG_CASE | SORT_STRING,
                $array_second_column,
                (!empty($second_order) && strtolower($second_order) === 'desc') ? SORT_DESC : SORT_ASC,
                SORT_FLAG_CASE | SORT_STRING,
                $array
            );
        }
        return $array;
    }

    /**
     * Add a key and its value into the array by following the key indexes.
     * @param array $array
     * @param string $key
     * @param mixed $value
     * @param string ...$index
     * @return array
     */
    public static function addKeyValue(array $array, string $key, $value, string ...$index): array
    {
        if (empty($index)) {
            throw new RuntimeException('Class ArrayManipulation, function addKeyValue. At least one argument $index is required.');
        }
        $firstIndex = array_shift($index);
        if (empty($index)) {
            //Numeric array
            if (isset($array[$firstIndex][$key]) && is_array($array[$firstIndex][$key]) && array_key_exists(0, $array[$firstIndex][$key])) {
                $array[$firstIndex][$key][] = $value;
                return $array;
            }
            //Associative array
            $array[$firstIndex][$key] = $value;
            return $array;
        }
        $array[$firstIndex] = self::addKeyValue(...array_merge([$array[$firstIndex]], [$key], [$value], $index));
        return $array;
    }

    /**
     * Remove a key and its value into the array by following the key indexes.
     * @param array $array
     * @param string ...$index
     * @return array
     */
    public static function removeKey(array $array, string ...$index): array
    {
        if (empty($index)) {
            throw new RuntimeException('Class ArrayManipulation, function removeKey. At least one argument $index is required.');
        }
        $firstIndex = array_shift($index);
        if (empty($index)) {
            if (!empty($array[$firstIndex])) {
                unset($array[$firstIndex]);
            }
            return $array;
        }
        $array[$firstIndex] = self::removeKey(...array_merge([$array[$firstIndex]], $index));
        return $array;
    }
}
