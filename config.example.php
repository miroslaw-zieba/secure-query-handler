<?php

/******************************************************************************
 *                                                                            *
 *                           StarFrame Framework                              *
 *                                                                            *
 *    © 2024 Mirosław Zięba (www.miroslawzieba.com).                          *
 *                                                                            *
 *    This configuration file is part of the StarFrame Framework and          *
 *    is essential for the proper functioning of the Query class.             *
 *                                                                            *
 *    This code is licensed under the MIT License. You are free to copy,      *
 *    modify, and distribute it as long as you retain this license notice.    *
 *    License details: https://opensource.org/licenses/MIT                    *
 *                                                                            *
 ******************************************************************************/

$starframe_config = [

    // General application configuration
    'app' => [
        'name' => 'Application Name',      // Application name
        'version' => '1.0.0',              // Application version
        'defaultLang' => 'pl-pl',          // Default application language
        'timezone' => 'Europe/Warsaw',     // Timezone
        'projectId' => 'applicationname',  // Project identifier (for unique log files and other resources)
        'maintenanceMode' => false,        // Is the application in maintenance mode
    ],

    // Database configuration
    'db' => [
        'host' => 'localhost',                     // Database server address
        'user' => 'database_username',             // Database username
        'pass' => 'database_password',             // Database password
        'name' => 'database_name',                 // Database name
        'driver' => 'mysql',                       // Database type (mysql, pgsql, sqlsrv)
        'port' => 3306,                            // Port for connection (e.g., 3306 for MySQL)
        'charset' => 'utf8mb4',                    // Character set configuration
        'collation' => 'utf8mb4_unicode_ci',       // Collation
    ],

    // Email configuration for external recipients
    'email' => [
        'smtp' => [
            'enabled' => false,  // Use SMTP to send emails (false = use mail() function)
            'host' => '',        // SMTP server address (leave empty if SMTP is disabled)
            'port' => 0,         // SMTP server port (e.g., 587 for TLS, 465 for SSL, 25 for plain connection)
            'user' => '',        // Username for SMTP server authentication
            'pass' => '',        // SMTP user password
            'encryption' => '',  // Encryption type: 'ssl', 'tls', or empty for no encryption
        ],
        'from' => [
            'email' => 'sender@applicationname.com', // Default sender email address
            'name' => 'Sender Name',                 // Default sender name (displayed in email client)
        ],
    ],

    // Logging, debugging, and cache configuration
    'storage' => [
        // Common base path
        'basePath' => '/home/user/domains/applicationname.com/', // Main prefix for files

        // Logging configuration
        'log' => [
            'enabled' => true,      // Is logging enabled
            'basePath' => 'logs/',  // Subdirectory for logs (relative to basePath)

            // Debugging
            'debug' => [
                'enabled' => true, // Is debugging enabled
            ],

            // Logging targets
            'targets' => [
                'database', // Logs saved to the database
                'file',     // Logs saved to files
                'email',    // Logs sent via email
                'screen',   // Logs displayed on the screen (mainly for debugging)
            ],

            // Email recipients
            'emailRecipients' => [
                'log' => ['logs@applicationname.com'],    // Email addresses for logs
                'debug' => ['debug@applicationname.com'], // Email addresses for debugging
            ],

            // Log files
            'files' => [
                'errorLog' => 'error.log',   // Error log (will be prefixed)
                'sqlLog' => 'sql.log',       // SQL queries log (will be prefixed)
                'eventsLog' => 'events.log', // Events log (will be prefixed)
                'debugLog' => 'debug.log',   // Debugging log (will be prefixed)
            ],

        ],

        // Cache configuration
        'cache' => [
            'enabled' => true,                  // Is cache enabled
            'basePath' => 'cache/',             // Subdirectory for cache files (relative to basePath)
            'file' => 'cache.json',             // Cache file name (will be prefixed)
            'lifetime' => 3600,                 // Cache lifetime in seconds
        ],
    ],

    // Security configuration
    'security' => [
        'errorPointsThreshold' => 500,      // Threshold of points for blocking IPs
    ],

    // Session configuration
    'session' => [
        'name' => 'applicationname_session', // Session name
        'lifetime' => 3600,                  // Session duration in seconds
        'path' => '/',                       // Session path
        'domain' => 'applicationname.com',   // Session domain
        'secure' => true,                    // Is the session secure (HTTPS)
        'httpOnly' => true,                  // Is the session accessible only via HTTP
    ],

    // API configuration
    'api' => [
        'enabled' => true,                                // Is the API enabled
        'keys' => [
            'publicKey' => '8902syrh87u4389fu9834uf84',   // Public API key
            'privateKey' => 'dm894ur890234uf89u4f89u89u', // Private API key
        ],
        'rateLimit' => 1000,                              // Rate limit per hour
    ],

    // Multimedia configuration
    'media' => [
        'maxUploadSize' => 10485760,                      // Maximum upload file size (in bytes)
        'allowedFormats' => ['jpg', 'png', 'gif', 'pdf'], // Allowed file formats
    ],
];
