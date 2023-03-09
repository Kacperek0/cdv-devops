<?php
/**
 * User: gmatk
 * Date: 01.07.2022
 * Time: 11:50
 */

namespace App\Domain\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Laravel\Passport\Client;

/**
 *
 */
class OauthClientsSeeder extends Seeder
{
    /**
     *
     */
    public function run(): void
    {
        if (Client::count() > 0) {
            return;
        }

        DB::unprepared(
            File::get(storage_path('app/bankcat_public_oauth_clients.sql'))
        );
    }
}
