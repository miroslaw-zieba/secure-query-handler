
# Secure Query Handler
Secure Query Handler by Mirosław Zięba is an advanced PHP class designed for secure, efficient SQL query management in PHP applications.
This class is optimized for developers who require robust database security, dynamic parameter validation, and automatic transaction handling.

## Features
- **Secure SQL Execution**: Prevents SQL injection attacks with parameterized queries.
- **Automatic Transaction Management**: Commits or rolls back transactions depending on query success or failure.
- **Dynamic Parameter Validation**: Supports custom validation for parameters.
- **Security Logging**: Logs security events with custom error points.
- **Customizable Error Handling**: Retry failed queries and block IPs with repeated violations.

## Badges
![License](https://img.shields.io/badge/license-MIT-blue)
![PHP](https://img.shields.io/badge/php-%3E%3D7.4-777BB4)

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/miroslaw-zieba/secure-query-handler.git
   ```
2. Include the `Query.php` file in your project:
   ```php
   require_once 'path/to/Query.php';
   ```

## Quick Start
```php
require_once 'Query.php';

$dbConfig = [
    'host' => 'localhost',
    'user' => 'your_username',
    'pass' => 'your_password',
    'name' => 'database_name'
];

$query = new Query($dbConfig);
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/')
      ->execute();
```

## Method Documentation

### `__construct($dbConfig = null)`
Initializes the database connection using the provided configuration, including `host`, `user`, `pass`, `name`, and `port`. Defaults to session configuration.

### `setQuery($query)`
Sets the SQL query for execution.

### `addParam($param, $value, $validate = null)`
Adds a parameter with an optional validation pattern (e.g., regex). Logs security events if validation fails.

### `execute()`
Executes the current SQL query, binding parameters and managing transactions.

### Usage Scenarios
#### Simple Select with Default Database
```php
$query = new Query();
$query->setQuery("SELECT * FROM example_table WHERE id = :id")
      ->addParam(':id', 123)
      ->execute();
```

#### Transaction Management Example
```php
$query->setQuery("INSERT INTO users (name, email) VALUES (:name, :email)")
      ->addParam(':name', 'Alice')
      ->addParam(':email', 'alice@example.com')
      ->execute();
```

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
