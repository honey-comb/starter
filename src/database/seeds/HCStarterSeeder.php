<?php

declare(strict_types = 1);

namespace HoneyComb\Starter\Database\Seeds;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;

/**
 * Class HCStarterSeeder
 * @package HoneyComb\Starter\Database\Seeds
 */
class HCStarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function run(): void
    {
        $this->call(HCLanguageSeed::class);
    }
}
