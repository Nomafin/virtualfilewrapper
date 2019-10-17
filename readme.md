# VirtualFileWrapper

## Description

Provides a stream wrapper class for virtual files to be stored and handled. Supports most major file handling functions of PHP, for example `file_get_contents` and `file_put_contents` and `file_exists`.

## Usage

```php
stream_wrapper_register( 'virtual', 'VirtualFileWrapper' );

file_put_contents( 'virtual://foo.txt', 'bar' );
```