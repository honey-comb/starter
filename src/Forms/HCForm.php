<?php
/**
 * @copyright 2019 innovationbase
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
 * Contact InnovationBase:
 * E-mail: hello@innovationbase.eu
 * https://innovationbase.eu
 */

declare(strict_types = 1);

namespace HoneyComb\Starter\Forms;

use HoneyComb\Starter\Contracts\HCFormContract;
use HoneyComb\Starter\Enum\HCFormTypeEnum;
use HoneyComb\Starter\Services\HCLanguageService;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionException;

/**
 * Class HCForm
 * @package HoneyComb\Starter\Forms
 */
abstract class HCForm implements HCFormContract
{
    /**
     * @var bool
     */
    public $authCheck = true;

    /**
     * @var bool
     */
    public $multiLanguage = false;

    /**
     * Creating form
     *
     * @param string|null $type
     * @return array
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    public function createForm(string $type = null): array
    {
        $data = [
            'storageUrl' => $this->getStorageUrl($type),
            'buttons' => $this->getButtons($type),
            'structure' => $this->getStructure($type),
        ];

        if ($this->multiLanguage) {
            $data['languages'] = $this->getContentLanguages();
        }

        return $data;
    }

    /**
     * @param string|null $type
     * @return string
     */
    abstract public function getStorageUrl(string $type = null): string;

    /**
     * Getting structure
     *
     * @param string|null $type
     * @return array
     * @throws ReflectionException
     */
    public function getStructure(string $type = null): array
    {
        if ($type === HCFormTypeEnum::edit()->id()) {
            return $this->getStructureEdit();
        }

        return $this->getStructureNew();
    }

    /**
     * @param string|null $type
     * @return  array
     * @throws ReflectionException
     */
    public function getButtons(string $type = null): array
    {
        $label = trans('HCStarter::starter.button.create');

        if ($type === HCFormTypeEnum::edit()->id()) {
            $label = trans('HCStarter::starter.button.update');
        }

        return [
            $this->makeButton($label)
                ->submit()
                ->toArray(),
        ];
    }

    /**
     * Get Edit structure
     *
     * @return array
     */
    public function getStructureEdit(): array
    {
        return [];
    }

    /**
     * Get new structure
     *
     * @return array
     */
    public function getStructureNew(): array
    {
        return [];
    }

    /**
     * @param string $label
     * @return HCFormField
     */
    public function makeField(string $label): HCFormField
    {
        return new HCFormField($label);
    }

    /**
     * @param string $label
     * @return HCFormButton
     */
    public function makeButton(string $label): HCFormButton
    {
        return new HCFormButton($label);
    }

    /**
     * @return array
     * @throws BindingResolutionException
     */
    protected function getContentLanguages(): array
    {
        return app()->make(HCLanguageService::class)->getFilteredContentLanguages($this->getCurrentLanguage());
    }

    /**
     * @return string
     */
    protected function getCurrentLanguage(): string
    {
        return request()->headers->get(config('starter.header_content_language_key')) ?: app()->getLocale();
    }
}
