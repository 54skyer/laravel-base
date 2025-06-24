<?php

namespace App\Providers;

use App\Logging\QueryLogChannel;
use Illuminate\Support\ServiceProvider;

class QueryLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 启动一个自定义的查询日志类
        $this->app->extend('log.queries', function ($app) {
            return new QueryLogChannel($app['config']['logging.channels.queries']);
        });
    }
}
