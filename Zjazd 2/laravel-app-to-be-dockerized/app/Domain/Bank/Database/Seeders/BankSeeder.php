<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:46
 */

namespace App\Domain\Bank\Database\Seeders;

use App\Application\Repositories\BankRepository;
use App\Application\Aggregations\Bank\BankAggregation;
use App\Application\Dto\Bank\BankDto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BankSeeder extends Seeder
{
    protected array $banks = [
        [
            'name' => 'mBank',
            'active' => true
        ],
        [
            'name' => 'iPKO',
            'active' => false
        ],
    ];

    public function __construct(private BankRepository $repository)
    {

    }

    public function run(): void
    {
        if ($this->repository->count() > 0) {
            return;
        }

        foreach ($this->banks as $bank) {
            $uuid = (string)Str::uuid();

            $dto = new BankDto($uuid, $bank['name']);
            $dto->setActive($bank['active']);

            BankAggregation::retrieve($uuid)
                ->create($dto)
                ->persist();
        }
    }
}
