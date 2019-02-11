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

/**
 * Class HCFormManager
 * @package HoneyComb\Starter\Helpers
 */
class HCFormManager
{
    /**
     * Get form structure as a json string
     *
     * @param string $key
     * @return string
     * @throws \Exception
     */
    public function getFormAsString(string $key): string
    {
        return json_encode(
            $this->getForm($key),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Get form from cache or get it from class and than store it to cache
     *
     * @param string $key
     * @return array
     * @throws \Exception
     */
    public function getForm(string $key): array
    {
        $this->regenerateForms();

        $formHolder = cache()->get('hc-forms');

        $new = substr($key, 0, -4);
        $edit = substr($key, 0, -5);

        if (array_has($formHolder, $new)) {
            $form = app()->make($formHolder[$new]);

            return $form->createForm();
        }

        if (array_has($formHolder, $edit)) {
            $form = app()->make($formHolder[$edit]);

            return $form->createForm(true);
        }

        throw new \Exception(trans('HCStarter::starter.error.form_not_found', ['key' => $key]));
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
