<?php


declare(strict_types=1);

namespace HoneyComb\Starter\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class HCBaseServiceProvider
 * @package HoneyComb\Starter\Providers
 */
class HCBaseServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $homeDirectory;

    /**
     * List of artisan console commands to register
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Provider controller namespace
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * Provider name
     *
     * @var string|null
     */
    protected $packageName;

    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @throws BindingResolutionException
     */
    public function boot(Router $router)
    {
        /** @var Application $app */
        $app = $this->app;

        $this->commands($this->commands);

        if (!$app->routesAreCached()) {
            $this->loadRoutes($router);
        }

        $this->loadMigrations();

        $this->loadTranslations();

        $this->registerPublishes();
    }

    /**
     * Load package routes
     *
     * @param Router $router
     */
    protected function loadRoutes(Router $router): void
    {
        foreach ($this->getRoutes() as $route) {
            $router->namespace($this->namespace)
                ->group($route);
        }
    }

    /**
     * Get root package path
     *
     * @param string $path
     * @return string
     */
    protected function packagePath(string $path): string
    {
        return $this->homeDirectory . '/../' . $path;
    }

    /**
     * Load package migrations
     * @throws BindingResolutionException
     */
    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));
    }

    /**
     * Load package views
     * @throws BindingResolutionException
     */
    protected function loadViews(): void
    {
        $this->loadViewsFrom($this->packagePath('resources/views'), $this->packageName);
    }

    /**
     * Load package translations
     * @throws BindingResolutionException
     */
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), $this->packageName);
    }

    /**
     *  Registering all vendor items which needs to be published
     * @throws BindingResolutionException
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            $this->packagePath('config') => config_path('/'),
        ], 'config');

        $this->publishes([
            $this->homeDirectory . '/../resources/lang' => base_path('resources/lang/vendor/' . $this->packageName),
        ], 'language');
    }

    /**
     * Get routes
     *
     * @return array
     */
    private function getRoutes(): array
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(realpath($this->packagePath('Routes'))));

        return array_keys(array_filter(iterator_to_array($iterator), function (SplFileInfo $file) {
            return $file->isFile() && substr($file->getFilename(), 0, strlen('routes.')) === (string)'routes.';
        }));
    }
}
