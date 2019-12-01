<?php

namespace ErlangParasu\DebugbarVscode;

use Laravel\Lumen\Application;

class LumenServiceProvider extends ServiceProvider
{
    /** @var  Application */
    protected $app;

    /**
     * Get the active router.
     *
     * @return Application
     */
    protected function getRouter()
    {
        return $this->app->router;
    }

    /**
     * Register the DebugbarVscode Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $this->app->middleware([$middleware]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['debugbarvscode'];
    }
}
