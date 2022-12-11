<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:27
 */

namespace App\Application\Events\Category;

use App\Application\Dto\Category\CategoryDto;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 *
 */
class CategoryCreated extends ShouldBeStored
{
    /**
     * @param CategoryDto $dto
     */
    public function __construct(private CategoryDto $dto)
    {

    }

    /**
     * @return CategoryDto
     */
    public function getDto(): CategoryDto
    {
        return $this->dto;
    }
}
