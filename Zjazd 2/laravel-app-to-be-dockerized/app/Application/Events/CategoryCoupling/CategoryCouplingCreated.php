<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 14:08
 */

namespace App\Application\Events\CategoryCoupling;

use App\Application\Dto\CategoryCoupling\CategoryCouplingDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class CategoryCouplingCreated extends ShouldBeStored
{
    /**
     * @param CategoryCouplingDto $dto
     */
    public function __construct(private CategoryCouplingDto $dto)
    {

    }

    /**
     * @return CategoryCouplingDto
     */
    public function getDto(): CategoryCouplingDto
    {
        return $this->dto;
    }
}
