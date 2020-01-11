<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Helpers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

/**
 * Class HCConfigParseHelper
 * @package HoneyComb\Starter\Helpers
 */
class HCConfigParseHelper
{
    /**
     * Scan folders for honeycomb configuration files
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getConfigFilesSorted()
    {
        $fileSystem = new Filesystem();

        $projectConfig = $fileSystem->glob(app_path('hc-config.json'));
        $packageConfigs = $fileSystem->glob(__DIR__ . '/../../../../*/*/*/hc-config.json');

        $packageConfigs = $this->sortByPriority($packageConfigs);

        $files = array_merge($packageConfigs, $projectConfig);

        return $files;
    }

    /**
     * Sort hc-config.json files by sequence
     *
     * @param array $filePaths
     * @return array
     */
    private function sortByPriority(array $filePaths): array
    {
        $toSort = [];

        foreach ($filePaths as $filePath) {
            $file = json_decode(file_get_contents($filePath), true);

            $sequence = Arr::get($file, 'general.sequence', 0);

            $toSort[$sequence][] = $filePath;
        }

        ksort($toSort);

        return Arr::collapse($toSort);
    }
}
