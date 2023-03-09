<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 17:54
 */

namespace App\Domain\Bank\Http\Controllers;

use App\Application\Repositories\BankRepository;
use App\Domain\Bank\Http\Collections\BankCollection;
use App\Interfaces\Http\Controllers\Controller;

/**
 *
 */
class BankController extends Controller
{
    /**
     * @param BankRepository $repository
     * @return BankCollection
     */
    public function available(BankRepository $repository): BankCollection
    {
        return new BankCollection($repository->active());
    }
}
