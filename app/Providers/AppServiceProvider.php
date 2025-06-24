<?php

namespace App\Providers;

use App\Enum\Environment;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 注册应用全局服务

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 启动应用全局服务

        // 仅当本地debug模式下，记录数据库日志
        if (App::environment(Environment::LOCAL->value)) {
            DB::listen(function (QueryExecuted $query) {
                if (config('app.debug')) {
                    $sql = Str::replaceArray('?', $query->bindings, $query->sql);
                    Log::channel('database')->debug($sql);
                }
            });
        }

        DB::listen(function ($query) {
            $date    = now();
            $logPath = storage_path("logs/queries/{$date->format('Y/m')}");
            $logFile = "{$date->format('d')}.log";

            if (!is_dir($logPath)) {
                mkdir($logPath, 0755, true);
            }

            $logFilePath = "{$logPath}/{$logFile}";
            File::append($logFilePath,$query->sql . ' [' . implode(', ', $query->bindings) . ']' . '[' . $query->time . 'ms]' . PHP_EOL);
        });
    }
}
