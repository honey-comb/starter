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
use HoneyComb\Starter\Services\HCFormManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class HCFormManagerController
 * @package HoneyComb\Starter\http\controllers
 */
class HCFormManagerController extends Controller
{
    /**
     * @var HCFormManagerService
     */
    private $formManagerService;

    /**
     * HCFormManagerController constructor.
     * @param HCFormManagerService $formManagerService
     */
    public function __construct(HCFormManagerService $formManagerService)
    {
        $this->formManagerService = $formManagerService;
    }

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
            $this->formManagerService->getForm($key)
        );
    }
}
