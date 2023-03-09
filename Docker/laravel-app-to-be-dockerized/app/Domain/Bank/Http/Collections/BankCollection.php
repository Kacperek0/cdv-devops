<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 17:55
 */

namespace App\Domain\Bank\Http\Collections;

use App\Domain\Bank\Http\Resources\BankResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BankCollection extends ResourceCollection
{
    public $collects = BankResource::class;
}
