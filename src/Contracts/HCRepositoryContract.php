<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface RepositoryContract
 * @package HoneyComb\Starter\Contracts
 */
interface HCRepositoryContract
{
    /**
     * @return string
     */
    public function model(): string;

    /**
     * @return Builder
     */
    public function makeQuery(): Builder;
}
