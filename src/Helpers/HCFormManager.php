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

namespace HoneyComb\Starter\Helpers;

use HoneyComb\Starter\Exceptions\HCException;
use HoneyComb\Starter\Forms\HCForm;
use Illuminate\Support\Arr;

/**
 * Class HCFormManager
 * @package HoneyComb\Starter\Helpers
 */
class HCFormManager
{
    /**
     * Get form from cache or get it from class and than store it to cache
     *
     * @param string $key
     * @param string $type
     * @return array
     * @throws \Exception
     */
    public function getForm(string $key, string $type): array
    {
        $this->regenerateForms();

        $formHolder = cache()->get('hc-forms');

        if (!Arr::has($formHolder, $key) || !class_exists($formHolder[$key])) {
            throw new HCException(trans('HCStarter::starter.error.form_not_found', ['key' => $key]));
        }

        $form = app()->make($formHolder[$key]);

        if (!$form instanceof HCForm) {
            throw new HCException(
                'Class ' . $formHolder[$key] . ' must be instance of HoneyComb\\Starter\\Forms\\HCForm'
            );
        }

        if ($form->authCheck && auth()->guest()) {
            throw new HCException(trans('HCStarter::starter.error.not_authorized'));
        }

        return $form->createForm($type == 'edit');
    }

    /**
     * If forms is not cached than cache them
     */
    private function regenerateForms(): void
    {
        if (!cache()->has('hc-forms')) {
            \Artisan::call('hc:forms');
        }
    }
}
