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

use Illuminate\Http\JsonResponse;

/**
 * Class HCResponse
 * @package HoneyComb\Starter\Helpers
 */
class HCResponse
{
    /**
     * @param string $message
     * @param null $data
     * @param string $redirectUrl
     * @return JsonResponse
     */
    public function success(string $message, $data = null, string $redirectUrl = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'redirectUrl' => $redirectUrl,
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param string $message
     * @param array $errors
     * @param string|null $redirectUrl
     * @param int $status
     * @return JsonResponse
     */
    public function error(
        string $message,
        array $errors = [],
        string $redirectUrl = null,
        int $status = JsonResponse::HTTP_BAD_REQUEST
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'redirectUrl' => $redirectUrl,
        ], $status);
    }
}