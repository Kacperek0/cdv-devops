<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 14:08
 */

namespace App\Application\Dto\CategoryCoupling;

/**
 *
 */
class CategoryCouplingDto
{
    /**
     * @param string $uuid
     * @param string $name
     * @param string $category_id
     */
    public function __construct(private string $uuid, private string $name, private string $category_id)
    {

    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
    }
}
