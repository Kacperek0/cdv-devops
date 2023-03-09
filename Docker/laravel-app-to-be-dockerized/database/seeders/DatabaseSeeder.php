<?php

namespace Database\Seeders;

use App\Domain\Bank\Database\Seeders\BankSeeder;
use App\Domain\Category\Database\Seeders\CategorySeeder;
use App\Domain\User\Database\Seeders\OauthClientsSeeder;
use App\Domain\User\Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            OauthClientsSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            BankSeeder::class
        ]);
    }
}
