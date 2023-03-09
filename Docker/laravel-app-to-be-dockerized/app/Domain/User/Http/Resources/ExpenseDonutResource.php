<?php
/**
 * User: gmatk
 * Date: 24.06.2022
 * Time: 15:12
 */

namespace App\Domain\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class ExpenseDonutResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'category' => $this->category->name ?? 'Bez kategorii',
            'total' => $this->total_count,
            'amount' => $this->total_amount,
            'color' => $this->category->color ?? null
        ];
    }
}
