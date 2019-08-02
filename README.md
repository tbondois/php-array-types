PHP Array Types
=======================


Presentation
---------------
Define some new array classes for PHP, based ArrayObject and inspired by Python types : [dictionary, list, tuple][1].

Using array object is way faster than using regular array.

Installation in a project
---------------

```
composer require tbondois/php-array-types
```

Update it  in a project
---------------

```
composer update tbondois/php-array-types
```

Usage
---------------

```php
require 'vendor/autoload.php';

$array = array_type_mixed(["value1", 5 => "value2", "key3" => "value3"]);
$reversed = $array->reverse();

$tuple = array_type_tuple(["value1", "value2", "value3"]);
$tuple[] = "value4"; // throw an exception

$list = array_type_list(["value1", "value2", "value3"]);
$list[3] = "value4"; // works

$dict = array_type_dictionary(['key1' => "value1", 'key2' => "value2", 'key3' =>"value3"])
$dict['key4'] = "value4"; // works
$dict[] = "value5"; // throw an exception
```

Project Links
---------------
* [On GitHub][2]
* [On Packagist][4]

Author
---------------
* [Thomas Bondois][4]


References
---------------
[1]: https://en.wikiversity.org/wiki/Python_Programming/Tuples_and_Sets
[2]: https://github.com/tbondois/php-array-types
[3]: https://packagist.org/packages/tbondois/php-array-types
[4]: https://thomas.bondois.info
