<?php

namespace TB\ArrayTypes;

use TB\ArrayTypes\Exceptions\ArrayTypeAccessTypeException;

/**
 * Auto-incremented indexed array. Not editable after construction
 * Like "tuple" in python
 * @author Thomas Bondois
 */
class ArrayTypeTuple extends ArrayTypeList
{
    /**
     * DOT NOT USE FOR THIS CLASS
     * @deprecated
     */
    public function append($input)
    {
        throw new ArrayTypeAccessTypeException("Forbidden append for ArrayTuple", 90);
    }

    /**
     * DOT NOT USE FOR THIS CLASS
     * @deprecated
     */
    public function exchangeArray($input)
    {
        throw new ArrayTypeAccessTypeException("Forbidden exchangeArray for ArrayTuple", 91);
    }

    /**
     * DOT NOT USE FOR THIS CLASS
     * @deprecated
     */
    public function offsetSet($key, $value)
    {
        throw new ArrayTypeAccessTypeException("Forbidden offsetSet for ArrayTuple", 92);
    }

    /**
     * DOT NOT USE FOR THIS CLASS
     * @deprecated
     */
    public function offsetUnset($offset)
    {
        throw new ArrayTypeAccessTypeException("Forbidden offsetUnset for ArrayTuple", 93);
    }

} // end class
