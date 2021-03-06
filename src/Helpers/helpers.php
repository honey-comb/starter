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

if (!function_exists('uuid4')) {
    /**
     * Generates uuid4 id
     *
     * @param bool $toString
     * @return \Ramsey\Uuid\UuidInterface|string
     * @throws Exception
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

if (!function_exists('isUuid')) {
    /**
     * Check if given string is uuid format
     *
     * @param string $string
     * @return bool
     */
    function isUuid(string $string): bool
    {
        $UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        return (bool)preg_match($UUIDv4, $string);
    }
}


if (!function_exists('array_splice_after_key')) {
    /**
     * https://stackoverflow.com/a/40305210/657451
     *
     * @param $array
     * @param $key
     * @param $array_to_insert
     * @return array
     */
    function array_splice_after_key(&$array, $key, $array_to_insert)
    {
        $key_pos = array_search($key, array_keys($array));
        if ($key_pos !== false) {
            $key_pos++;
            $second_array = array_splice($array, $key_pos);
            $array = array_merge($array, $array_to_insert, $second_array);
        }

        return $array;
    }
}


/*
* @Source: http://eosrei.net/comment/287
*
* Inserts a new key/value before the key in the array.
*
* @param $key
*   The key to insert before.
* @param $array
*   An array to insert in to.
* @param $new_key
*   The key to insert.
* @param $new_value
*   An value to insert.
*
* @return
*   The new array if the key exists, FALSE otherwise.
*
* @see array_insert_after()
*/
if (!function_exists('array_insert_before')) {
    function array_insert_before($key, array &$array, $new_key, $new_value)
    {
        if (array_key_exists($key, $array)) {
            $new = [];
            foreach ($array as $k => $value) {
                if ($k === $key) {
                    $new[$new_key] = $new_value;
                }
                $new[$k] = $value;
            }

            $array = $new;
        }
    }
}


/*
 * @Source: http://eosrei.net/comment/287
 *
 * Inserts a new key/value after the key in the array.
 *
 * @param $key
 *   The key to insert after.
 * @param $array
 *   An array to insert in to.
 * @param $new_key
 *   The key to insert.
 * @param $new_value
 *   An value to insert.
 *
 * @return
 *   The new array if the key exists, FALSE otherwise.
 *
 * @see array_insert_before()
 */
if (!function_exists('array_insert_after')) {
    function array_insert_after($key, array &$array, $new_key, $new_value)
    {
        if (array_key_exists($key, $array)) {

            $new = [];
            foreach ($array as $k => $value) {
                $new[$k] = $value;
                if ($k == $key) {
                    $new[$new_key] = $new_value;
                }
            }

            $array = $new;
        }
    }
}
