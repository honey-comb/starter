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

namespace HoneyComb\Starter\Http\Controllers;

use Cache;
use HoneyComb\Starter\Exceptions\HCException;
use HoneyComb\Starter\Helpers\HCFormManager;
use HoneyComb\Starter\Helpers\HCResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class HCFormManagerController
 * @package HoneyComb\Starter\http\controllers
 */
class HCFormManagerController extends Controller
{
    /**
     * @var HCFormManager
     */
    private $formManager;

    /**
     * @var HCResponse
     */
    private $response;

    /**
     * HCFormManagerController constructor.
     * @param HCFormManager $formManager
     * @param HCResponse $response
     */
    public function __construct(HCFormManager $formManager, HCResponse $response)
    {
        $this->formManager = $formManager;
        $this->response = $response;
    }

    /**
     * Get form structure as json object
     *
     * @param string $key
     * @param string|null $type
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function getStructure(string $key, string $type = null): JsonResponse
    {
        try {
            $form = $this->formManager->getForm($key, $type);
        } catch (HCException $exception) {
            return $this->response->error($exception->getMessage());
        }

        return $this->response->success('OK', $form);
    }
}
