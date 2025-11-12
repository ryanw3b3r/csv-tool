# CSV Tool

Author: Ryan Weber

## Setup

1. Run `composer install`.
2. Place in a PHP 7+ server environment (tested with Nginx server and PHP 8.3).
3. Upload a CSV file with format: `Category,Price,Amount`. Sample file is in `/data` folder.

## Features

- Class-based logic with own MVC-like framework
- Proper autoloading via Composer PSR-4
- Graceful error handling
- Clean number formatting
