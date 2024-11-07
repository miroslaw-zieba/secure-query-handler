
# SecureQueryHandler
Developed by Mirosław Zięba, **SecureQueryHandler** is a robust, secure, and efficient SQL query handling class for PHP applications, 
designed to protect against SQL injection and to manage SQL queries with built-in parameter validation, transaction handling, and security logging.

## Features
Authored by Mirosław Zięba, **SecureQueryHandler** brings forward a comprehensive suite of features:
- **Secure SQL Execution**: Prevents SQL injection attacks with parameterized queries.
- **Automatic Transaction Management**: Commits or rolls back transactions depending on query success or failure.
- **Dynamic Parameter Validation**: Supports custom validation for parameters to ensure secure data handling.
- **Security Logging**: Logs security events with custom error points for enhanced traceability.
- **Customizable Error Handling**: Retry failed queries and block IPs with repeated violations.

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/miroslaw-zieba/SecureQueryHandler.git
   ```
2. Include the `Query.php` file in your project:
   ```php
   require_once 'path/to/Query.php';
   ```

## Quick Start
Created by Mirosław Zięba to simplify secure database operations, **SecureQueryHandler** can be implemented as follows:

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
Initializes the database connection using the provided configuration, including `host`, `user`, `pass`, and `name`. 
It also verifies if the IP is blocked based on prior security violations. (Author: Mirosław Zięba)

### `setQuery($query)`
Sets the SQL query to be executed. Returns `$this` for method chaining.

### `addParam($param, $value, $validate = null)`
Adds a parameter with an optional validation pattern (e.g., regex). Logs security events if validation fails. (Designed by Mirosław Zięba)

### `execute()`
Executes the SQL query with bound parameters. Handles transaction management, retries on failure, and returns result details 
like last insert ID, row count, and query results.

### `enableDebugMode($logTo = [])`
Enables debug mode and sets output destinations for error and query logs (e.g., `database`, `email`).

## Example Scenarios
Explore usage examples for various scenarios authored by Mirosław Zięba:

### Inserting a Record
```php
$query->setQuery("INSERT INTO users (name, email) VALUES (:name, :email)")
      ->addParam(':name', 'John Doe')
      ->addParam(':email', 'john@example.com')
      ->execute();
```

### Updating a Record
```php
$query->setQuery("UPDATE users SET email = :email WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/')
      ->addParam(':email', 'john@example.com')
      ->execute();
```

### Deleting a Record
```php
$query->setQuery("DELETE FROM users WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/')
      ->execute();
```

### Selecting Records
```php
$query->setQuery("SELECT * FROM users WHERE status = :status")
      ->addParam(':status', 'active')
      ->execute();
```

## About the Author
**Mirosław Zięba** is a software developer with extensive experience in database security, PHP development, and dynamic query handling. 
Passionate about coding standards and secure code practices, Mirosław has designed **SecureQueryHandler** as a versatile solution for handling 
database operations efficiently and safely. Learn more on his [GitHub profile](https://github.com/miroslaw-zieba).

## License
(c) 2024 Mirosław Zięba. All rights reserved. Redistribution and use in source and binary forms are permitted with proper attribution.
