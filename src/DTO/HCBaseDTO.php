<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\DTO;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * Class HCBaseDTO
 * @package HoneyComb\Starter\DTO
 */
abstract class HCBaseDTO implements JsonSerializable, Arrayable
{
    /**
     * @return array
     */
    final public function jsonSerialize(): array
    {
        return $this->jsonData();
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return $this->jsonData();
    }

    /**
     * @return array
     */
    abstract protected function jsonData(): array;

    /**
     * @return array
     */
    abstract protected function jsonDataList(): array;
}
