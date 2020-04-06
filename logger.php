<?php

namespace Php\Exam;

require 'loggerInterface.php';
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

    public function debug($msg)
    {
        $this->insert('debug', $msg);
        echo "debug " . $msg . PHP_EOL;
    }
    public function info($msg)
    {
        $this->insert('info', $msg);
        echo "info " . $msg . PHP_EOL;
    }
    public function notice($msg)
    {
        $this->insert('notice', $msg);
        echo "notice " . $msg . PHP_EOL;
    }
    public function critical($msg)
    {
        $this->insert('critical', $msg);
        echo 'critical ' . $msg . PHP_EOL;
    }
    public function error($msg)
    {
        $this->insert('error', $msg);
        echo 'error ' . $msg . PHP_EOL;
    }

    private function insert($funcName, $msg)
    {
        $insert = "INSERT INTO logs (level, message) VALUES (:level, :message)";
        $stmr = $this->pdo->prepare($insert);
        $stmr->bindValue(':level', $funcName);
        $stmr->bindValue(':message', $msg);
        $stmr->execute();
    }
}
