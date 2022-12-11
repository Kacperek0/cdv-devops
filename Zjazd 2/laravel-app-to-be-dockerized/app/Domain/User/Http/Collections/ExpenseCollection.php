<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 13:44
 */

namespace App\Domain\User\Http\Collections;

use App\Domain\User\Http\Resources\ExpenseResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 *
 */
class ExpenseCollection extends ResourceCollection
{
    /**
     * @var string
     */
    public $collects = ExpenseResource::class;
}
