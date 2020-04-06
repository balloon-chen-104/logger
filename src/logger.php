<?php

namespace Php\Exam;

use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    private $pdo;

    public function __construct()
    {
        $pdo = new \PDO('sqlite:syslog.sqlite3');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $pdo->exec("CREATE TABLE IF NOT EXISTS logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            level VARCHAR(10) NOT NULL,
            message TEXT NOT NULL
        )");

        $this->pdo = $pdo;
    }

    public function emergency($message, array $context = array())
    {
    }
    public function alert($message, array $context = array())
    {
    }
    public function critical($message, array $context = array())
    {
        $this->insert('critical', $message);
        echo 'critical ' . $message . PHP_EOL;
    }
    public function error($message, array $context = array())
    {
        $this->insert('error', $message);
        echo 'error ' . $message . PHP_EOL;
    }
    public function warning($message, array $context = array())
    {
    }
    public function notice($message, array $context = array())
    {
        $this->insert('notice', $message);
        echo "notice " . $message . PHP_EOL;
    }
    public function info($message, array $context = array())
    {
        $this->insert('info', $message);
        echo "info " . $message . PHP_EOL;
    }
    public function debug($message, array $context = array())
    {
        $this->insert('debug', $message);
        echo "debug " . $message . PHP_EOL;
    }
    public function log($level, $message, array $context = array())
    {
    }
    
    private function insert($funcName, $message)
    {
        $insert = "INSERT INTO logs (level, message) VALUES (:level, :message)";
        $stmr = $this->pdo->prepare($insert);
        $stmr->bindValue(':level', $funcName);
        $stmr->bindValue(':message', $message);
        $stmr->execute();
    }
}
