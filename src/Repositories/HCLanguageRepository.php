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

namespace HoneyComb\Starter\Repositories;

use HoneyComb\Starter\Enum\BoolEnum;
use HoneyComb\Starter\Http\Requests\HCLanguageRequest;
use HoneyComb\Starter\Models\HCLanguage;
use HoneyComb\Starter\Repositories\Traits\HCQueryBuilderTrait;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class HCLanguageRepository
 * @package HoneyComb\Starter\Repositories
 */
class HCLanguageRepository extends HCBaseRepository
{
    use HCQueryBuilderTrait;

    /**
     * @var string
     */
    protected $interfaceCacheKey = '_hc_interface_languages';

    /**
     * @return string
     */
    public function model(): string
    {
        return HCLanguage::class;
    }

    /**
     * @return string
     */
    public function getInterfaceCacheKey(): string
    {
        return $this->interfaceCacheKey;
    }

    /**
     * @param HCLanguageRequest $request
     * @return \Illuminate\Support\Collection|static
     */
    public function getOptions(HCLanguageRequest $request)
    {
        return $this->createBuilderQuery($request)->get()->map(function ($record) {
            return [
                'id' => $record->id,
                'language' => $record->language,
            ];
        });
    }

    /**
     * @return Collection
     * @throws \ReflectionException
     */
    public function getContentLanguages(): Collection
    {
        return $this->makeQuery()
            ->where('is_content', BoolEnum::yes()->id())
            ->get();
    }

    /**
     * @return Collection
     * @throws \ReflectionException
     */
    public function getInterfaceLanguages(): Collection
    {
        return $this->makeQuery()
            ->where('is_interface', BoolEnum::yes()->id())
            ->get();
    }
}
