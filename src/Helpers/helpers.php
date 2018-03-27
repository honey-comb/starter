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
 * E-mail: hello@interactivesolutions.lt
 * http://www.interactivesolutions.lt
 */

if (!function_exists('uuid4')) {
    /**
     * Generates uuid4 id
     *
     * @param bool $toString
     * @return \Ramsey\Uuid\UuidInterface|string
     */
    function uuid4(bool $toString = false)
    {
        $uuid4 = Ramsey\Uuid\Uuid::uuid4();

        if ($toString) {
            $uuid4 = $uuid4->toString();
        }

        return $uuid4;
    }
}


if (!function_exists('pluralizeLT')) {
    /**
     * Returns the correct lithuanian word form for given count.
     *
     * @param array $words [žodis, žodžiai, žodžių]
     * @param int $number
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    function pluralizeLT(array $words, int $number): string
    {
        if (count($words) != 3) {
            throw new \InvalidArgumentException('Words array must contain 3 values!');
        }

        if (!is_int($number)) {
            throw new \InvalidArgumentException('number must be an integer!');
        }

        if ($number % 10 == 0 || floor($number / 10) == 1) {
            return $words[2];
        } elseif ($number % 10 == 1) {
            return $words[0];
        } else {
            return $words[1];
        }
    }
}


if (!function_exists('isPackageEnabled')) {
    /**
     * Check if package is registered at config/app.php file
     *
     * @param $provider
     * @return bool
     */
    function isPackageEnabled($provider)
    {
        $registeredProviders = array_keys(app()->getLoadedProviders());

        return in_array($provider, $registeredProviders);
    }
}


if (!function_exists('sanitizeString')) {

    /**
     * Returns a sanitized string, typically for URLs.
     * http://stackoverflow.com/questions/2668854/sanitizing-strings-to-make-them-url-and-filename-safe
     *
     * @param string $string - The string to sanitize.
     * @param bool $forceLowerCase - Force the string to lowercase?
     * @param bool $onlyLetter - If set to *true*, will remove all non-alphanumeric characters.
     *
     * @return mixed|string
     */
    function sanitizeString(string $string, bool $forceLowerCase = false, bool $onlyLetter = false)
    {
        $strip = [
            '~',
            '`',
            '!',
            '@',
            '#',
            '$',
            '%',
            '^',
            '&',
            '*',
            '(',
            ')',
            '_',
            '=',
            '+',
            '[',
            '{',
            ']',
            '}',
            '\\',
            '|',
            ';',
            ':',
            '"',
            '\'',
            '&#8216;',
            '&#8217;',
            '&#8220;',
            '&#8221;',
            '&#8211;',
            '&#8212;',
            'â€”',
            'â€“',
            ',',
            '<',
            '.',
            '>',
            '/',
            '?',
        ];

        $clean = trim(str_replace($strip, '', strip_tags($string)));
        $clean = preg_replace('/\s+/', '-', $clean);
        $clean = ($onlyLetter) ? preg_replace('/[^a-zA-Z0-9]/', '', $clean) : $clean;

        return ($forceLowerCase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}


if (!function_exists('stringToDouble')) {

    /**
     * Formatting 0,15 to 0.15 and etc
     *
     * @param string $value
     * @return mixed
     */
    function stringToDouble($value)
    {
        if (!$value) {
            $value = '0.0';
        }

        return str_replace(',', '.', $value);
    }
}
