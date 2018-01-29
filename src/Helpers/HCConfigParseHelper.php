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
 * E-mail: info@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

declare(strict_types = 1);

namespace HoneyComb\Starter\Helpers;

use Illuminate\Filesystem\Filesystem;

class HCConfigParseHelper
{
    /**
     * Scan folders for honeycomb configuration files
     *
     * @return array
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

            $sequence = array_get($file, 'general.sequence', 0);

            $toSort[$sequence][] = $filePath;
        }

        ksort($toSort);

        return array_collapse($toSort);
    }
}
