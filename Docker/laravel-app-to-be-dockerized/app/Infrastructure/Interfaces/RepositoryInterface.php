<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 09:51
 */

namespace App\Infrastructure\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface as BaseRepositoryInterface;

/**
 *
 */
interface RepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $where
     * @param string $columns
     * @return mixed
     */
    public function count(array $where = [], $columns = '*');
}
