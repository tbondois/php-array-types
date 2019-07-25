<?php

namespace TB\ArrayTypes;

use TB\ArrayTypes\Exceptions\ArrayTypeAccessTypeException;
use TB\ArrayTypes\Exceptions\ArrayTypeIndexException;
use TB\Toolbox\Util;

/**
 * Auto-incremented indexed array
 * Like "list" in python
 * @author Thomas Bondois
 */
class ArrayTypeList extends AbstractArrayType
{
    public function __construct(array $array = [])
    {
        if (!Util::is_sequential($array)) {
            throw new ArrayTypeIndexException("Array keys should be be sequential for ArrayTypeList", 90);
        }
        parent::__construct($array);
    }

    public function offsetSet($key, $value)
    {
        if (is_numeric($key)) {
            parent::offsetSet((int)$key, $value);
            $this->ksort();
        } elseif (null === $key) {
            $this->append($value);
        } else {
            throw new ArrayTypeAccessTypeException("forbidden offsetSet for ArrayTypeList", 50);
        }
    }

} // end class
