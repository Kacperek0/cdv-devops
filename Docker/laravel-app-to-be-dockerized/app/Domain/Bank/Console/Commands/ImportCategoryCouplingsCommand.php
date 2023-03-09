<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 13:36
 */

namespace App\Domain\Bank\Console\Commands;

use App\Application\Aggregations\Category\CategoryAggregation;
use App\Application\Aggregations\CategoryCoupling\CategoryCouplingAggregation;
use App\Application\Dto\Category\CategoryDto;
use App\Application\Dto\CategoryCoupling\CategoryCouplingDto;
use App\Application\Repositories\BankRepository;
use App\Application\Repositories\CategoryCouplingRepository;
use App\Application\Repositories\CategoryRepository;
use App\Domain\Bank\Entities\Bank;
use App\Domain\Bank\Reports\ReportService;
use App\Domain\Bank\Reports\TransactionListModifier;
use App\Domain\Category\Entities\Category;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 *
 */
class ImportCategoryCouplingsCommand extends Command
{
    /**
     *
     */
    public const CREATE_CATEGORY = 'Stwórz kategorię';

    /**
     * @var string
     */
    protected $signature = 'bank:import-category-couplings';
    /**
     * @var string
     */
    protected $description = 'Import some category couplings from banks';

    /**
     * @var Collection
     */
    protected Collection $categories;
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @param BankRepository $bankRepository
     * @param CategoryRepository $categoryRepository
     * @param CategoryCouplingRepository $categoryCouplingRepository
     */
    public function handle(
        BankRepository $bankRepository,
        CategoryRepository $categoryRepository,
        CategoryCouplingRepository $categoryCouplingRepository
    ): void {
        $this->categoryRepository = $categoryRepository;

        $banks = $bankRepository->active();

        $bankChoice = $this->choice('Bank?', $banks->pluck('name')->toArray());
        $fileLocation = $this->ask('File?', storage_path('app/banks/mbank3.csv'));
        /**
         * @var Bank $bank
         */
        $bank = $banks->where('name', $bankChoice)->first();

        if (!File::exists($fileLocation)) {
            $this->error('File not exists');
            return;
        }

        if (!$strategy = $bank->getReportStrategy()) {
            $this->error('Bank strategy not exists');
            return;
        }

        $reportService = new ReportService($strategy);
        $transactions = TransactionListModifier::getExpenses($reportService->getTransactions(
            $reportService->decode(File::get($fileLocation), File::extension($fileLocation))
        ));
        $couplings = $reportService->getCategories($transactions);

        if (count($couplings) === 0) {
            $this->warn('Categories not found!');
            return;
        }

        $this->handleCouplings($couplings, $categoryCouplingRepository);

        $this->info('Category couplings assigned');
    }

    /**
     * @param array $couplings
     * @param CategoryCouplingRepository $categoryCouplingRepository
     */
    protected function handleCouplings(
        array $couplings,
        CategoryCouplingRepository $categoryCouplingRepository
    ): void {
        DB::transaction(function () use ($couplings, $categoryCouplingRepository) {
            foreach ($couplings as $coupling) {
                $this->categories = $this->categoryRepository->all();
                $this->handleCoupling($coupling, $categoryCouplingRepository);
            }
        });
    }

    /**
     * @param string $coupling
     * @param CategoryCouplingRepository $categoryCouplingRepository
     */
    protected function handleCoupling(
        string $coupling,
        CategoryCouplingRepository $categoryCouplingRepository
    ): void {
        if ($categoryCouplingRepository->findByName($coupling)) {
            return;
        }

        /**
         * @var Category $category
         */
        if (!$category = $this->categories->where('name', $coupling)->first()) {
            $options = $this->categories->pluck('name');
            $options->push(self::CREATE_CATEGORY);

            $categoryChoice = $this->choice(
                sprintf('"%s" to couple with:', $coupling),
                $options->toArray()
            );

            $category = $this->getCategory($categoryChoice, $coupling);
        }

        $uuid = (string)Str::uuid();
        CategoryCouplingAggregation::retrieve($uuid)
            ->create(
                new CategoryCouplingDto($uuid, $coupling, $category->getKey())
            )
            ->persist();

        $this->info(sprintf('Assigned %s with %s', $coupling, $category->name));
    }

    /**
     * @param string $name
     * @param string $coupling
     * @return Category|null
     */
    protected function getCategory(string $name, string $coupling): ?Category
    {
        if ($name === self::CREATE_CATEGORY) {
            $faker = Factory::create(config('app.faker_locale'));

            $uuid = (string)Str::uuid();
            CategoryAggregation::retrieve($uuid)
                ->create(
                    new CategoryDto($uuid, $coupling, $faker->unique()->hexColor())
                )
                ->persist();

            return $this->categoryRepository->find($uuid);
        }

        return $this->categories->where('name', $name)->first();
    }
}
