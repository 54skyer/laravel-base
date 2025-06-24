<?php

namespace App\Logging;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class QueryLogChannel
{
    protected array $config;

    public function __construct(array $config)
    {
        // 提供配置，方便扩展自定义的其他额外的操作。
        $this->config = $config;
    }

    public function __invoke(): Logger
    {
        // queries 是日志通道名称
        $log = new Logger('queries');

        $date    = now();
        $logPath = storage_path("logs/queries/{$date->format('Y/m')}");
        $logFile = "{$date->format('d')}.log";

        if (!is_dir($logPath)) {
            mkdir($logPath, 0755, true);
        }

        $handler = new RotatingFileHandler("{$logPath}/{$logFile}", 30, Level::Debug);

        // 格式化日志
        $handler->setFormatter(new LineFormatter(null, null, true, true));

        $log->pushHandler($handler);

        return $log;
    }
}
