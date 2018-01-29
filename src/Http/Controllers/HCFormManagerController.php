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

namespace HoneyComb\Starter\Http\Controllers;

use Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class HCFormManagerController
 * @package HoneyComb\Starter\http\controllers
 */
class HCFormManagerController extends Controller
{
    /**
     * Get form structure as json object
     *
     * @param string $key
     * @return JsonResponse
     * @throws \Exception
     */
    public function getStructure(string $key): JsonResponse
    {
        return response()->json(
            $this->getForm($key)
        );
    }

    /**
     * Get form structure as a json string
     *
     * @param string $key
     * @return string
     * @throws \Exception
     */
    public function getStructureAsString(string $key): string
    {
        return json_encode($this->getForm($key));
    }

    /**
     * Get form from cache or get it from class and than store it to cache
     *
     * @param string $key
     * @return array
     * @throws \Exception
     */
    private function getForm(string $key): array
    {
        if (!cache()->has('hc-forms')) {
            \Artisan::call('hc:forms');
        }

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

        throw new \Exception('Form not found: ' . $key);
    }
}
