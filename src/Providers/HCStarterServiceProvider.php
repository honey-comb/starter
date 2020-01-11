<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Providers;

use HoneyComb\Starter\Helpers\HCResponse;
use HoneyComb\Starter\Repositories\HCBaseRepository;
use HoneyComb\Starter\Repositories\HCLanguageRepository;
use HoneyComb\Starter\Services\HCLanguageService;

/**
 * Class HCStarterServiceProvider
 * @package HoneyComb\Starter\Providers
 */
class HCStarterServiceProvider extends HCBaseServiceProvider
{
    /**
     * @var string
     */
    protected $homeDirectory = __DIR__;

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
    protected $namespace = 'HoneyComb\Starter\Http\Controllers';

    /**
     * Provider name
     *
     * @var string
     */
    protected $packageName = 'HCStarter';

    /**
     *
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            $this->packagePath('config/starter.php'),
            'starter'
        );

        $this->registerRepositories();

        $this->registerServices();

        $this->registerHelpers();
    }

    /**
     *
     */
    private function registerRepositories(): void
    {
        $this->app->singleton(HCBaseRepository::class);
        $this->app->singleton(HCLanguageRepository::class);
    }

    /**
     *
     */
    private function registerServices(): void
    {
        $this->app->singleton(HCLanguageService::class);
    }

    /**
     *
     */
    private function registerHelpers(): void
    {
        $this->app->singleton(HCResponse::class);
    }

}
