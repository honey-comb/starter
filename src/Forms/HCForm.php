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

use HoneyComb\Core\Services\HCLanguageService;
use HoneyComb\Starter\Contracts\HCFormContract;
use Illuminate\Http\Request;

/**
 * Class HCForm
 * @package HoneyComb\Starter\Forms
 */
abstract class HCForm implements HCFormContract
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var HCLanguageService
     */
    protected $languageService;

    /**
     * HCForm constructor.
     * @param Request $request
     * @param HCLanguageService $languageService
     */
    public function __construct(Request $request, HCLanguageService $languageService)
    {
        $this->request = $request;
        $this->languageService = $languageService;
    }

    /**
     * Creating form
     *
     * @param bool $edit
     * @return array
     */
    abstract public function createForm(bool $edit = false): array;

    /**
     * Get Edit structure
     *
     * @return array
     */
    abstract public function getStructureEdit(): array;

    /**
     * Get new structure
     *
     * @return array
     */
    abstract public function getStructureNew(): array;

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
     * Getting submit button label
     *
     * @param bool $edit
     * @return string
     */
    public function getSubmitLabel(bool $edit): string
    {
        return $edit ? trans('HCStarter::core.buttons.update') : trans('HCStarter::core.buttons.create');
    }

    /**
     * @param string $label
     * @param bool $required
     * @param bool $readonly
     * @param bool $hidden
     * @return HCFormField
     */
    public function makeField(
        string $label,
        bool $required = false,
        bool $readonly = false,
        bool $hidden = false
    ): HCFormField {
        return new HCFormField($label, $required, $readonly, $hidden);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getContentLanguages(): array
    {
        return $this->languageService->getFilteredContentLanguages($this->getCurrentLanguage());
    }

    /**
     * @return string
     */
    protected function getCurrentLanguage(): string
    {
        return $this->request->headers->get('hc-lang-content') ?: app()->getLocale();
    }
}