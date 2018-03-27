<?php
/**
 * @copyright 2018 interactivesolutions
 *  
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *  
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *  
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *  
 * Contact InteractiveSolutions:
 * E-mail: hello@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

declare(strict_types = 1);

namespace HoneyComb\Starter\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

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

        $this->loadViews();

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
        /** @var string $route */
        foreach ($this->getRoutes() as $route) {
            $router->group(['namespace' => $this->namespace], function () use ($route) {
                require $this->packagePath($route);
            });
        }
    }

    /**
     * Get routes
     *
     * @return array
     */
    private function getRoutes(): array
    {
        $fileSystem = new Filesystem();

        $file = json_decode(
            $fileSystem->get($this->packagePath('hc-config.json')),
            true
        );

        return array_get($file, 'routes', []);
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
     */
    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));
    }

    /**
     * Load package views
     */
    protected function loadViews(): void
    {
        $this->loadViewsFrom($this->packagePath('resources/views'), $this->packageName);
    }

    /**
     * Load package translations
     */
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), $this->packageName);
    }

    /**
     *  Registering all vendor items which needs to be published
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            $this->packagePath('config') => config_path('/'),
        ], 'config');
    }
}
