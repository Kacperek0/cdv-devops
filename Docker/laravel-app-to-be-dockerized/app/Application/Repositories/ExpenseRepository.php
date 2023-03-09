<?php

namespace App\Application\Repositories;

use App\Application\Dto\Expense\ExpenseMyDto;
use App\Infrastructure\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface ExpenseRepository.
 *
 * @package namespace App\Application\Repositories;
 */
interface ExpenseRepository extends RepositoryInterface
{
    /**
     * @param string $userId
     * @param \App\Application\Dto\Expense\ExpenseMyDto $dto
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function user(string $userId, ExpenseMyDto $dto, int $perPage = 50): LengthAwarePaginator;

    /**
     * @param string $userId
     * @param ExpenseMyDto $dto
     * @return Collection
     */
    public function getDonatChartData(string $userId, ExpenseMyDto $dto): Collection;
}
