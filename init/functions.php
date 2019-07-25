<?php

use TB\ArrayTypes\ArrayTypeMixed;
use TB\ArrayTypes\ArrayTypeDictionary;
use TB\ArrayTypes\ArrayTypeList;
use TB\ArrayTypes\ArrayTypeTuple;

if (!function_exists("array_type_mixed")) {
    function array_type_mixed(array $array)
    {
        return new ArrayTypeMixed($array);
    }
}
if (!function_exists("array_type_dictionary")) {
    function array_type_dictionary(array $array)
    {
        return new ArrayTypeDictionary($array);
    }
}
if (!function_exists("array_type_list")) {
    function array_type_list(array $array)
    {
        return new ArrayTypeList($array);
    }
}
if (!function_exists("array_type_tuple")) {
    function array_type_tuple(array $array)
    {
        return new ArrayTypeTuple($array);
    }
}
