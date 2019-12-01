<?php namespace ErlangParasu\DebugbarVscode;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Session\SessionManager;
use DebugBar\DataFormatter\DataFormatter;
use DebugBar\DataFormatter\DataFormatterInterface;
use ErlangParasu\DebugbarVscode\Middleware\InjectDebugbarVscode;
use ErlangParasu\DebugbarVscode\Middleware\DebugbarVscodeEnabled;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {     
        $this->app->singleton(LaravelDebugbarVscode::class, function () {
                $debugbarvscode = new LaravelDebugbarVscode($this->app);
                return $debugbarvscode;
            }
        );

        $this->app->alias(LaravelDebugbarVscode::class, 'debugbarvscode');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {     
        $this->registerMiddleware(InjectDebugbarVscode::class);
    }

    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app['router'];
    }
  
    /**
     * Register the DebugbarVscode Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
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
