<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.sql_debug')) {
            DB::listen(function ($query) {
                $logContent = PHP_EOL;
                $logContent .= '-- [' . now()->toDateTimeString() . ']';
                $logContent .= PHP_EOL;
                $logContent .= $query->sql;
                $this->replaceSQlParams($logContent, $query->bindings);
                $logContent .= ';';
                $logContent .= PHP_EOL;
                $logContent .= "-- Tempo: {$query->time}ms";
                Storage::disk('sql-log')->append('log.sql', $logContent);
            });
        }
    }

    private function replaceSQlParams(&$logContent, $parameters)
    {
        foreach ($parameters as $parameter) {
            $positionReplace = strpos($logContent, '?');
            $logContent = substr_replace($logContent, "'$parameter'", $positionReplace, 1);
        }
    }
}
