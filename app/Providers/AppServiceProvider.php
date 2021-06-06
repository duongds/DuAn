<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
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
        $this->loadApplicationHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(255);
        $this->logQuery();
    }

    private function logQuery()
    {
        if (env('LOG_QUERY', true)) {
            $maxSize = 2000000; // ~2Mb
            $nameFix = 'query/sql-' . date('Y-m-d');
            $name = "{$nameFix}.sql";
            $index = 0;
            while (\Storage::disk('local')->exists($name)
                && \Storage::disk('local')->size($name) >= $maxSize) {
                $index += 1;
                $name = "{$nameFix}-{$index}.sql";
            }
            \Storage::disk('local')->append($name, "\r\n Start: ");

            DB::listen(function ($query) use ($name) {
                $binding = $query->bindings;
                $binding = array_map(function ($bd) {
                    if (is_object($bd)) return "'" . (string)$bd->format('Y-m-d H:i:s') . "'";
                    else return "'$bd'";
                }, $binding);

                $boundSql = str_replace(['%', '?'], ['%%', '%s'], $query->sql);
                $boundSql = vsprintf($boundSql, $binding);
                $sql = "-- " . date('d-m-Y H:i:s') . " Time: ({$query->time})\r\n ";
                $sql .= $boundSql;
                $sql .= ';';
                \Storage::disk('local')->append($name, $sql);
            });
        }
    }

    private function listenQuery()
    {
        DB::listen(function ($query) {
            File::append(
                storage_path('/logs/query.log'),
                '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
            );
        });
    }


    /**
     * This function will load all helpers of this application
     *
     * @return void
     */
    protected function loadApplicationHelpers(): void
    {
        $helpers = File::glob(__DIR__ . '/../Utils/*.php');
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }
}
