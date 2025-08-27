<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $databasePath = database_path('database.sqlite');

        // Jika database.sqlite belum ada → buat file kosong
        if (!file_exists($databasePath)) {
            touch($databasePath);

            // Jalankan migrate otomatis
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                Log::error("Auto migrate gagal: " . $e->getMessage());
            }
        }

        if (app()->runningInConsole() && env('NATIVEPHP', false)) {
            config([
                'database.connections.sqlite.database' => base_path('database/database.sqlite'),
            ]);
        }
    }
}
