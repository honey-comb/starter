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

namespace HoneyComb\Starter\Views;

use HoneyComb\Starter\Contracts\HCDataTableContract;
use HoneyComb\Starter\Contracts\HCDataTableHeaderContract;

/**
 * Class HCDataList
 * @package HoneyComb\Starter\Views
 */
class HCDataTable implements HCDataTableContract
{
    const GET = 'GET';
    const POST = 'POST';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * HCDataList constructor.
     * @param string $key
     * @param string|null $source
     */
    public function __construct(string $key, string $source = null)
    {
        $this->data = $this->getDefaultStructure($key, $source);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->data['key'];
    }

    /**
     * @param string $title
     * @return HCDataTableContract
     */
    public function setTitle(string $title): HCDataTableContract
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @param string|null $source
     * @return HCDataTableContract
     */
    public function setSource(string $source = null): HCDataTableContract
    {
        $this->data['source'] = $source;

        return $this;
    }

    /**
     * @param string $method
     * @return HCDataTableContract
     */
    public function setMethod(string $method): HCDataTableContract
    {
        $this->data['method'] = strtoupper($method);

        return $this;
    }

    /**
     * @param array $data
     * @return HCDataTableContract
     */
    public function setData(array $data): HCDataTableContract
    {
        $this->data['data'] = $data;

        return $this;
    }

    /**
     * @param string $field
     * @param string|null $label
     * @param callable|null $callable
     * @return HCDataTableContract
     */
    public function addHeader(string $field, string $label = null, callable $callable = null): HCDataTableContract
    {
        $header = new HCDataTableHeader($field, $label);

        if (!is_null($callable)) {
            $headerInstance = $callable($header);

            if($headerInstance instanceof HCDataTableHeaderContract) {
                $header = $headerInstance;
            }
        }

        $this->data['headers'][] = $header->toArray();

        return $this;
    }

    /**
     * @param string $key
     * @param string|null $source
     * @return array
     */
    public function getDefaultStructure(string $key, string $source = null): array
    {
        return [
            'key' => $key,
            'source' => $source,
            'method' => self::GET,
            'title' => null,
            'headers' => [],
            'data' => [],
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
