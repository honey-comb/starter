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
use HoneyComb\Starter\Services\HCLanguageService;

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
     * @param bool $edit
     * @return array
     */
    public function createForm(bool $edit = false): array
    {
        $data = [
            'storageUrl' => $this->getStorageUrl($edit),
            'buttons' => $this->getButtons($edit),
            'structure' => $this->getStructure($edit),
        ];

        if ($this->multiLanguage) {
            $data['languages'] = $this->getContentLanguages();
        }

        return $data;
    }

    /**
     * @param bool $edit
     * @return string
     */
    abstract public function getStorageUrl(bool $edit): string;

    /**
     * Getting structure
     *
     * @param bool $edit
     * @return array
     */
    public function getStructure(bool $edit): array
    {
        if ($edit) {
            return $this->getStructureEdit();
        } else {
            return $this->getStructureNew();
        }
    }

    /**
     * @param bool $edit
     * @return array
     */
    public function getButtons(bool $edit): array
    {
        $label = $edit ? trans('HCStarter::starter.button.update') : trans('HCStarter::starter.button.create');

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
