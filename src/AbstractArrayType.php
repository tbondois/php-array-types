<?php

namespace TB\ArrayTypes;

use ArrayObject;
use TB\Toolbox\Util;
use TB\Toolbox\Json;

/**
 * Base class for all array types
 * @author Thomas Bondois
 */
abstract class AbstractArrayType extends ArrayObject
{
    const SORT_ORDER_ASC  = 'ASC';
    const SORT_ORDER_DESC = 'DESC';
    const ITERATOR_CLASS  = "ArrayIterator";
    const FLAG_COMBINED   = self::STD_PROP_LIST | self::ARRAY_AS_PROPS;

    private $___class = null;

    public function __construct(array $array = [])
    {
        parent::__construct($array, static::FLAG_COMBINED, static::ITERATOR_CLASS);
    }

    public function setFlagsCombined()
    {
        $this->setFlags(static::FLAG_COMBINED);
    }

    public function offsetSet($key, $value)
    {
        if (null === $key) {
            $this->append($value);
        } else {
            parent::offsetSet($key, $value);
        }
    }

    public function __get($key)
    {
        $this->getElement($key);
    }

    public function __set($key, $value)
    {
        $this->setElement($key, $value);
    }

    public function __call($key, $args)
    {
        if (is_object($this->___class) && is_callable([$this->___class, $key])) {
            return call_user_func_array([$this->___class, $key], $args);
        }
        return is_callable($c = $this->__get($key)) ? call_user_func_array($c, $args) : null;
    }
    
    public function getObjectCopy() : ArrayTypeMixed
    {
        $clone = clone $this;
        return $clone;
    }

    protected function objectToArray($object)
    {
        $o = [];
        foreach ($object as $key => $value) {
            $o[$key] = is_object($value) ? (array)$value : $value;
        }
        return $o;
    }

    public function import(array $array)
    {
        $this->exchangeArray($array);
        return $this;
    }

    public function importObject($class, $array = [])
    {
        $this->___class = $class;
        if (count($array) > 0) {
            $this->import($array);
        }
        return $this;
    }

    function importCombine(array $keys, array $values)
    {
        $result = array_combine($keys, $values);
        return $this->import($result);
    }

    public function exportAsArray()
    {
        return $this->objectToArray($this->getArrayCopy());
    }

    /**
     * @param string $json
     *
     * @return ArrayTypeMixed
     * @throws \JsonException
     */
    public function importJson(string $json)
    {
        return $this->import(Json::decode($json, true));
    }

    /**
     * @return false|string
     * @throws \JsonException
     */
    public function exportAsJson()
    {
        return Json::encode($this);
    }

    public function getElement($key)
    {
        return $this->offsetGet($key);
    }

    public function setElement($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    // Methods using Toolbox\Util :

    public function getFirstKey()
    {
        $array = $this->getArrayCopy();
        return Util::array_key_first($array);
    }

    public function getFirstValue()
    {
        $array = $this->getArrayCopy();
        return Util::array_first($array);
    }

    public function getLastKey()
    {
        $array = $this->getArrayCopy();
        return Util::array_last($array);
    }

    public function getLastValue()
    {
        $array = $this->getArrayCopy();
        return Util::iterable_last($array);
    }

    public function getRandomKey()
    {
        $array = $this->getArrayCopy();
        return Util::array_key_random($array);
    }

    public function getRandomValue()
    {
        $array = $this->getArrayCopy();
        return Util::array_value_random($array);
    }

    public function isSequential(): bool
    {
        $array = $this->getArrayCopy();
        return Util::is_sequential($array);
    }

    // Methods using native array_* functions :

    public function hasKey($key)
    {
        return isset($this[$key]);
    }

    public function hasValue($value, $strict = false)
    {
        $array = $this->getArrayCopy();
        return in_array($value, $array, $strict);
    }

    function getKeys($search_value = null, $strict = null)
    {
        $array = $this->getArrayCopy();
        return array_keys($array, $search_value, $strict);
    }

    function getValues()
    {
        $array = $this->getArrayCopy();
        return array_values($array);
    }

    function sum()
    {
        $array = $this->getArrayCopy();
        return array_sum($array);

    }

    function product()
    {
        $array = $this->getArrayCopy();
        return array_product($array);
    }

    function countValues()
    {
        $array = $this->getArrayCopy();
        return array_count_values($array);
    }

    function column($column, $index_key = null)
    {
        $array = $this->getArrayCopy();
        return array_column($array, $column, $index_key);
    }

    public function search($needle)
    {
        $array = $this->getArrayCopy();
        return array_search($needle, $array);
    }

    function array_filter($callback = null, $flag = 0)
    {
        $array = $this->getArrayCopy();
        return array_filter($array, $callback, $flag);
    }

    function map($callback, array ...$othersArrays)
    {
        $array = $this->getArrayCopy();
        return array_map($callback, $array, ...$othersArrays);
    }

    function pad($pad_size, $pad_value)
    {
        $array = $this->getArrayCopy();
        return array_pad($array, $pad_size, $pad_value);
    }

    function unique($sort_flags = SORT_STRING)
    {
        $array = $this->getArrayCopy();
        return array_unique($array, $sort_flags);
    }

    public function lowercaseKeys()
    {
        $array = $this->getArrayCopy();
        return array_change_key_case($array, CASE_LOWER);
    }

    public function uppercaseKeys()
    {
        $array = $this->getArrayCopy();
        return array_change_key_case($array, CASE_UPPER);
    }

    public function lowercaseValues()
    {
        $array = $this->getArrayCopy();
        $array = array_change_key_case(array_flip($array), CASE_LOWER);
        return array_flip($array);
    }

    public function uppercaseValues()
    {
        $array = $this->getArrayCopy();
        $array = array_change_key_case(array_flip($array), CASE_UPPER);
        return array_flip($array);
    }

    public function flip()
    {
        $array = $this->getArrayCopy();
        return array_flip($array);
    }

    public function fill($start_index, $num, $value)
    {
        $result = array_fill($start_index, $num, $value);
        return $this->merge($result);
    }

    public function fillKeys(array $keys, $value)
    {
        $result = array_fill_keys($keys, $value);
        return $this->merge($result);
    }

    function pushAndSave(...$vars)
    {
        $array = $this->getArrayCopy();
        $result = array_push($array, ...$vars);
        return $this->import($result);
    }

    function popAndSave()
    {
        $array = $this->getArrayCopy();
        $result = array_pop($array);
        return $this->import($result);
    }

    public function shiftAndSave()
    {
        $array = $this->getArrayCopy();
        $result = array_shift($array);
        return $this->import($result);
    }

    public function unshiftAndSave(...$vars)
    {
        $array = $this->getArrayCopy();
        $result = array_unshift($array, ...$vars);
        return $this->import($result);
    }

    public function spliceAndSave($offset, $length = null, $replacement = null)
    {
        $array = $this->getArrayCopy();
        $result = array_splice($array, $offset, $length, $replacement);
        return $this->import($result);
    }

    public function slice($offset, $length = null, $preserve_keys = false)
    {
        $array = $this->getArrayCopy();
        return array_slice($array, $offset, $length, $preserve_keys);
    }

    public function merge(array ...$othersArrays)
    {
        $array = $this->getArrayCopy();
        return array_merge($array, ...$othersArrays);
    }

    function mergeRecursive(array ...$othersArrays)
    {
        $array = $this->getArrayCopy();
        return array_merge_recursive($array, ...$othersArrays);
    }

    function replace(array ...$othersArrays)
    {
        $array = $this->getArrayCopy();
        return array_replace($array, ...$othersArrays);
    }

    function replaceRecursive(array ...$othersArrays)
    {
        $array = $this->getArrayCopy();
        return array_replace_recursive($array, ...$othersArrays);
    }

    function intersect(array ...$othersArrays)
    {
        $array = $this->getArrayCopy();
        return array_intersect($array, ...$othersArrays);
    }

    function chunk(int $size, $preserve_keys = null)
    {
        $array = $this->getArrayCopy();
        return array_chunk($array, $size, $preserve_keys);
    }

    function reverse($preserve_keys = null)
    {
        $array = $this->getArrayCopy();
        return array_reverse($array, $preserve_keys);
    }

    function multisortAndSave($order = SORT_REGULAR, $otherArray = null)
    {
        $array = $this->getArrayCopy();
        array_multisort($array, $order, $otherArray);
        return $this->import($array);
    }

    function sortByColumnAndSave($column, $order = SORT_ASC) {
        $array = $this->getArrayCopy();
        $keys = array_column($array, $column);
        array_multisort($keys, $order, $array);
        return $this->import($array);
    }



} // end class
