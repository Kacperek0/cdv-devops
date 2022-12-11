<?php
/**
 * User: gmatk
 * Date: 07.08.2019
 * Time: 19:38
 */

namespace App\Infrastructure\Traits;

/**
 * Trait DomainResolverTrait
 * @package App\Infrastructure\Traits
 */
trait DomainResolverTrait
{
    /**
     * @param string|null $append
     * @return string
     */
    protected function domainPath(string $append = null): string
    {
        $reflection = new \ReflectionClass($this);

        $realPath = dirname($reflection->getFileName(), 2) . '/';

        if (!$append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }
}
