[![Travis](https://img.shields.io/travis/Devtronic/call-user-func-assoc.svg)](https://travis-ci.org/Devtronic/call-user-func-assoc)
[![Packagist](https://img.shields.io/packagist/v/devtronic/call-user-func-assoc.svg)](https://packagist.org/packages/devtronic/call-user-func-assoc)
[![GitHub license](https://img.shields.io/badge/license-LGPL3.0-blue.svg)](https://raw.githubusercontent.com/devtronic/call-user-func-assoc/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/devtronic/call-user-func-assoc.svg)](https://packagist.org/packages/devtronic/call-user-func-assoc)

# Call User Func Assoc

Calls a function with an associative array.

## Installation
Install it via composer
```sh
$ composer require devtronic/call-user-func-assoc
```

## Usage
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

function sayHello($name, $age = '*not set*')
{
    echo sprintf("Hello, my name is %s and I'm %s years old", $name, $age);
}

call_user_func_assoc('sayHello', ['Julian', 23]);
// Hello, my name is Julian and I'm 23 years old

call_user_func_assoc('sayHello', [23, 'Julian']);
// Hello, my name is 23 and I'm Julian years old

call_user_func_assoc('sayHello', ['age' => 23, 'name' => 'Julian']);
// Hello, my name is Julian and I'm 23 years old

call_user_func_assoc('sayHello', ['name' => 'Julian']);
// Hello, my name is Julian and I'm *not set* years old

```

## Testing
`$ phpunit`