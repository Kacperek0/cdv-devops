<?php
/**
 * User: gmatk
 * Date: 21.06.2022
 * Time: 15:43
 */

namespace App\Domain\Bank\Reports\Decoders\Mbank;

use App\Domain\Bank\Reports\Contracts\ReportDecoderContract;
use JsonException;

/**
 *
 */
class JsonDecoder implements ReportDecoderContract
{
    /**
     * @param string $data
     * @return array
     * @throws JsonException
     */
    public function decode(string $data): array
    {
        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        return $data['transactions'] ?? [];
    }

}
