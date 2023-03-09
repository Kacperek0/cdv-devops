<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 20:28
 */

namespace App\Domain\User\Http\Controllers\Expense;

use App\Application\Exceptions\ExpenseException;
use App\Application\Repositories\ExpenseRepository;
use App\Application\Services\Expense\ExpenseServiceContract;
use App\Application\Dto\Expense\ExpenseMyDto;
use App\Domain\User\Http\Collections\ExpenseCollection;
use App\Domain\User\Http\Requests\ExpenseChartRequest;
use App\Domain\User\Http\Requests\MyExpenseRequest;
use App\Domain\User\Http\Requests\StoreExpensesRequest;
use App\Domain\User\Http\Resources\ExpenseDonutResource;
use App\Interfaces\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class ExpenseController extends Controller
{
    /**
     * @param StoreExpensesRequest $request
     * @param ExpenseServiceContract $expenseService
     * @return JsonResponse
     * @throws ExpenseException
     */
    public function store(StoreExpensesRequest $request, ExpenseServiceContract $expenseService): JsonResponse
    {
        $expenseService->storeFromUploadedFile(
            $request->user()->getKey(),
            $request->input('bank'),
            $request->file('file')
        );

        return response()->json();
    }

    /**
     * @param MyExpenseRequest $request
     * @param ExpenseRepository $repository
     * @return ExpenseCollection
     */
    public function user(MyExpenseRequest $request, ExpenseRepository $repository): ExpenseCollection
    {
        $dto = new ExpenseMyDto(
            Carbon::parse($request->input('from'))->startOfDay(),
            Carbon::parse($request->input('to'))->endOfDay()
        );

        return new ExpenseCollection(
            $repository
                ->with(['category', 'bank'])
                ->user(
                    $request->user()->getKey(),
                    $dto,
                    $request->input('perPage'),
                )
        );
    }

    /**
     * @param ExpenseChartRequest $request
     * @param ExpenseRepository $repository
     * @return JsonResponse
     */
    public function donut(ExpenseChartRequest $request, ExpenseRepository $repository): JsonResponse
    {
        $dto = new ExpenseMyDto(
            Carbon::parse($request->input('from'))->startOfDay(),
            Carbon::parse($request->input('to'))->endOfDay()
        );

        return response()->json([
            'series' => ExpenseDonutResource::collection($repository
                ->with(['category'])
                ->getDonatChartData(
                    auth()->user()->getKey(),
                    $dto
                ))
        ]);
    }
}
