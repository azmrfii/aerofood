<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Window::open();

        // $source = base_path('database/database.sqlite');
        // $target = storage_path('nativephp.sqlite');

        // if (file_exists($source) && !file_exists($target)) {
        //     copy($source, $target);
        // }

        // config([
        //     'database.connections.sqlite.database' => $target,
        // ]);
        config([
            'database.connections.sqlite.database' => base_path('database/database.sqlite'),
        ]);
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [];
    }
}
