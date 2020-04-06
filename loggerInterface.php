<?php

namespace Psr\Log;

interface LoggerInterface
{
    public function debug($msg);
    public function info($msg);
    public function notice($msg);
    public function critical($msg);
    public function error($msg);
}
