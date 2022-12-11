<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:28
 */

namespace App\Application\Dto\Category;

/**
 *
 */
class CategoryDto
{
    /**
     * @param string $uuid
     * @param string $name
     * @param string $color
     */
    public function __construct(private string $uuid, private string $name, private string $color)
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
    public function getColor(): string
    {
        return $this->color;
    }
}
