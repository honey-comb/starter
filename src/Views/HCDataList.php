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

/**
 * Class HCDataList
 * @package HoneyComb\Starter\Views
 */
class HCDataList
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $headers = [];

    /**
     * HCDataList constructor.
     * @param string $key
     * @param string $source
     */
    public function __construct(string $key, string $source)
    {
        $this->data = [
            'key' => $key,
            'source' => $source,
        ];

        $this->setMethod('get');
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
     * @return HCDataList
     */
    public function addTitle(string $title): HCDataList
    {
        $this->data['title'] = $title;

        return $this;
    }

    /**
     * @param string $method
     * @return HCDataList
     */
    public function setMethod(string $method): HCDataList
    {
        $this->data['method'] = strtoupper($method);

        return $this;
    }

    /**
     * @param string $field
     * @param string $label
     * @param bool $sortable
     * @return HCDataList
     */
    public function headerAddText(string $field, string $label, bool $sortable = false): HCDataList
    {
        return $this->addHeader('text', $field, $label, $sortable);
    }

    /**
     * @param string $field
     * @param string $label
     * @param bool $sortable
     * @return HCDataList
     */
    public function headerAddHtml(string $field, string $label, bool $sortable = false): HCDataList
    {
        return $this->addHeader('html', $field, $label, $sortable);
    }

    /**
     * @param string $field
     * @param string $label
     * @return HCDataList
     */
    public function headerAddCheckbox(string $field, string $label): HCDataList
    {
        return $this->addHeader('checkBox', $field, $label);
    }

    /**
     * @param string $field
     * @param string $label
     * @param bool $external
     * @param string $url
     * @param bool $sortable
     * @return HCDataList
     */
    public function headerAddUrl(
        string $field,
        string $label,
        bool $external = true,
        string $url = '',
        bool $sortable = false
    ): HCDataList {
        $properties = [
            'url' => $url,
            'external' => $external,
        ];

        return $this->addHeader('url', $field, $label, $sortable, $properties);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->data['headers'] = $this->headers;

        return $this->data;
    }

    /**
     * @param string $type
     * @param string $field
     * @param string|null $label
     * @param bool $sortable
     * @param array $properties
     * @return HCDataList
     */
    private function addHeader(
        string $type,
        string $field,
        string $label = null,
        bool $sortable = false,
        array $properties = []
    ): HCDataList {
        $this->headers[] = [
            'type' => $type,
            'field' => $field,
            'label' => $label,
            'sortable' => $sortable,
            'properties' => $properties,
        ];

        return $this;
    }
}
