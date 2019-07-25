<?php

namespace TB\ArrayTypes;

use TB\ArrayTypes\Exceptions\ArrayTypeAccessTypeException;
use TB\ArrayTypes\Exceptions\ArrayTypeIndexException;
use TB\Toolbox\Util;

/**
 * Associative non-sequential array
 * Like "dictionary" in python
 * @author Thomas Bondois
 */
class ArrayTypeDictionary extends AbstractArrayType
{
    public function __construct(array $array = [])
    {
        if (Util::is_sequential($array)) {
            throw new ArrayTypeIndexException("Array keys should not be be sequential for ArrayTypeDictionary", 90);
        }
        parent::__construct($array);
    }

    /**
     * DOT NOT USE FOR THIS CLASS
     * @deprecated
     */
    public function append($value)
    {
        throw new ArrayTypeAccessTypeException("Forbidden append for ArrayTypeDictionary", 70);
    }

} // end class
