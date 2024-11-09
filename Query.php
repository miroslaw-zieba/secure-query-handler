<?php
/**
 * Query Class - Secure SQL Query Handler with Multi-DB Support and Security Logging
 * (c) 2024 Mirosław Zięba. All rights reserved.
 * Website: www.miroslawzieba.com
 */

class Query {
    private $pdo;
    private $query;
    private $stmt;
    private $params = [];
    private $cache = [];
    private $logFile = "query_log.txt";
    private $debugMode = false;
    private $adminEmails;
    private $adminIPs;
    private $logTo = [];
    private $currentUserId;
    private $userRoles = [];
    private $lastInsertId;
    private $affectedRows;
    private $transactionStarted = false;
    private $executionTime;
    private $errorPointsThreshold = 1000;
    private $errorDictionary = [
        "SQL_INJECTION_ATTEMPT" => 90,
        "UNAUTHORIZED_ACCESS" => 80,
        "MISSING_PARAMETER" => 20,
        "INVALID_PARAMETER_FORMAT" => 50,
        "INVALID_PARAMETER_VALUE" => 25,
        "MULTIPLE_LOGIN_ATTEMPTS" => 70,
        "DATABASE_MANIPULATION_ATTEMPT" => 100,
        "INVALID_SQL_SYNTAX" => 40,
        "EXCESSIVE_QUERY_EXECUTION" => 60,
        "IP_BLACKLISTED" => 85,
        "CROSS_SITE_SCRIPTING_ATTEMPT" => 75,
        "TAMPERING_WITH_SESSION" => 80,
        "MALICIOUS_PARAMETER_LENGTH" => 50,
        "ACCESS_FROM_UNKNOWN_IP" => 65,
        "INVALID_FILE_ACCESS" => 85,
        "DEBUG_MODE_ENABLED_UNAUTHORIZED" => 70
    ];

    public function __construct($dbConfig = null) {
        $host = $dbConfig['host'] ?? $_SESSION['db']['host'];
        $user = $dbConfig['user'] ?? $_SESSION['db']['user'];
        $pass = $dbConfig['pass'] ?? $_SESSION['db']['pass'];
        $dbname = $dbConfig['name'] ?? $_SESSION['db']['name'];
        $port = $dbConfig['port'] ?? '3306';
        $driver = $dbConfig['driver'] ?? 'mysql';
        $dsn = $this->createDsn($driver, $host, $dbname, $port);

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->logError("Connection failed: " . $e->getMessage());
            throw new Exception("Database connection error.");
        }

        if ($this->isBlockedIP($_SERVER['REMOTE_ADDR'])) {
            throw new Exception("Access denied. Your IP has been blocked due to multiple security violations.");
        }
    }

    private function createDsn($driver, $host, $dbname, $port) {
        switch ($driver) {
            case 'pgsql':
                return "pgsql:host=$host;port=$port;dbname=$dbname";
            case 'sqlsrv':
                return "sqlsrv:Server=$host,$port;Database=$dbname";
            default:
                return "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";
        }
    }

    private function isBlockedIP($ip) {
        $stmt = $this->pdo->prepare("SELECT SUM(points) as total_points FROM sf_events_log WHERE ip_address = :ip");
        $stmt->execute([':ip' => $ip]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['total_points'] >= $this->errorPointsThreshold;
    }

    public function setQuery($query) {
        $this->query = $query;
        return $this;
    }

    public function addParam($param, $value, $validate = null) {
        if ($validate && !$this->validateParam($value, $validate)) {
            $this->logSecurityEvent("INVALID_PARAMETER_VALUE", $param, $value);
            throw new Exception("Validation failed for parameter: $param");
        }
        $this->params[$param] = $value;
        return $this;
    }

    private function validateParam($value, $validate) {
        return preg_match($validate, $value);
    }

    private function logSecurityEvent($eventCode, $param = null, $value = null) {
        $userId = $this->currentUserId ?? 'unknown';
        $ip = $_SERVER['REMOTE_ADDR'];
        $host = gethostbyaddr($ip);
        $points = $this->errorDictionary[$eventCode] ?? 0;

        $stmt = $this->pdo->prepare("INSERT INTO sf_events_log (user_id, type, message, ip_address, host, points, timestamp) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $message = "Event: $eventCode; Param: $param; Value: $value";
        $stmt->execute([$userId, $eventCode, $message, $ip, $host, $points]);
    }

    public function execute() {
        if (isset($this->cache[$this->query])) {
            return $this->cache[$this->query];
        }

        try {
            $startTime = microtime(true);
            $this->stmt = $this->pdo->prepare($this->query);

            foreach ($this->params as $param => $value) {
                $this->stmt->bindValue($param, $value);
            }

            if (!$this->transactionStarted) {
                $this->pdo->beginTransaction();
                $this->transactionStarted = true;
            }

            $this->stmt->execute();
            $this->executionTime = microtime(true) - $startTime;
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->affectedRows = $this->stmt->rowCount();

            if ($this->transactionStarted) {
                $this->pdo->commit();
                $this->transactionStarted = false;
            }

            $result = [
                'success' => true,
                'executionTime' => $this->executionTime,
                'query' => $this->query
            ];

            if (stripos($this->query, 'INSERT') === 0) {
                $result['lastInsertId'] = $this->lastInsertId;
                $result['affectedRows'] = $this->affectedRows;
            } elseif (stripos($this->query, 'UPDATE') === 0 || stripos($this->query, 'DELETE') === 0) {
                $result['affectedRows'] = $this->affectedRows;
            } elseif (stripos($this->query, 'SELECT') === 0) {
                $result['result'] = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['rowCount'] = $this->affectedRows;
            }

            $this->cache[$this->query] = $result;
            return $result;

        } catch (PDOException $e) {
            if ($this->transactionStarted) {
                $this->pdo->rollBack();
                $this->transactionStarted = false;
            }
            $this->logError("Execution failed: " . $e->getMessage());
            throw new Exception("Query execution error.");
        }
    }

    private function logError($message) {
        $logEntry = date("Y-m-d H:i:s") . " - ERROR: $message\n";
        file_put_contents($this->logFile, $logEntry, FILE_APPEND);

        if (in_array("database", $this->logTo)) {
            $this->logToDatabase($logEntry);
        }

        if (in_array("email", $this->logTo)) {
            $this->sendEmail($message);
        }
    }

    private function logToDatabase($logEntry) {
        $stmt = $this->pdo->prepare("INSERT INTO sf_error_logs (log_entry, created_at) VALUES (:logEntry, NOW())");
        $stmt->execute([':logEntry' => $logEntry]);
    }

    public function enableDebugMode($logTo = []) {
        $this->debugMode = true;
        $this->logTo = $logTo;
        return $this;
    }

    public function getLogs() {
        return file_get_contents($this->logFile);
    }
}
