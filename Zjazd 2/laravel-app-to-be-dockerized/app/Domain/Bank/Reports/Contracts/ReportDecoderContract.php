<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 15:43
 */

namespace App\Domain\Bank\Reports\Contracts;

/**
 *
 */
interface ReportDecoderContract
{
    /**
     * @param string $data
     * @return array
     */
    public function decode(string $data): array;
}
