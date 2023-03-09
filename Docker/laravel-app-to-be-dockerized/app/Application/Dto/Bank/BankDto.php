<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 12:51
 */

namespace App\Application\Dto\Bank;

/**
 *
 */
class BankDto
{
    /**
     * @var string|null
     */
    private ?string $logo = null;
    /**
     * @var bool
     */
    private bool $active = true;

    /**
     * @param string $uuid
     * @param string $name
     */
    public function __construct(private string $uuid, private string $name)
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
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     */
    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
