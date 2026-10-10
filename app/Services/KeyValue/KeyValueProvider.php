<?php declare(strict_types = 1);

namespace App\Services\KeyValue;

use Illuminate\Support\ServiceProvider;

class KeyValueProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            KeyValueInterface::class,
            KeyValueRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
