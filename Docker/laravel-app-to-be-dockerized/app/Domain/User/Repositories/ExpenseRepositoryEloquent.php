<?php

namespace App\Domain\User\Repositories;

use App\Application\Dto\Expense\ExpenseMyDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Application\Repositories\ExpenseRepository;
use App\Domain\User\Entities\Expense;
use App\Application\Validators\ExpenseValidator;

/**
 * Class ExpenseRepositoryEloquent.
 *
 * @package namespace App\Temp\Repositories;
 */
class ExpenseRepositoryEloquent extends BaseRepository implements ExpenseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Expense::class;
    }

    /**
     * @param string $userId
     * @param ExpenseMyDto $dto
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function user(string $userId, ExpenseMyDto $dto, int $perPage = 50): LengthAwarePaginator
    {
        return $this
            ->scopeQuery(function ($query) use ($userId, $dto) {
                return $query
                    ->where('user_id', $userId)
                    ->whereBetween('date_at', [$dto->getFrom(), $dto->getTo()])
                    ->orderBy('date_at', 'DESC')
                    ->orderBy('created_at', 'DESC');
            })
            ->paginate($perPage);
    }

    /**
     * @param string $userId
     * @param ExpenseMyDto $dto
     * @return Collection
     */
    public function getDonatChartData(string $userId, ExpenseMyDto $dto): Collection
    {
        return $this
            ->scopeQuery(function ($query) use ($userId, $dto) {
                return $query
                    ->select([
                        'category_id',
                        DB::raw('count(*) as total_count'),
                        DB::raw('sum(amount) as total_amount')
                    ])
                    ->where('user_id', $userId)
                    ->whereBetween('date_at', [$dto->getFrom(), $dto->getTo()])
                    ->groupBy('category_id');
            })->all();
    }
}
