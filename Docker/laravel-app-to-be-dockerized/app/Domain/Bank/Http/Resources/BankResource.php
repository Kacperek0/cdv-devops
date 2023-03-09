<?php
/**
 * User: gmatk
 * Date: 23.06.2022
 * Time: 17:55
 */

namespace App\Domain\Bank\Http\Resources;

use App\Domain\Bank\Entities\Bank;
use App\Domain\Bank\Reports\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class BankResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /**
         * @var Bank $resource
         */
        $resource = $this;

        $data = $resource->only(['id', 'name', 'logo']);
        $reportService = new ReportService($resource->getReportStrategy());

        return array_merge($data, [
            'decoders' => $reportService->getAvailableDecoders()
        ]);
    }
}
