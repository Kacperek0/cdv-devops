<?php

namespace App\Domain\User\Entities;

use App\Domain\Bank\Entities\Bank;
use App\Domain\Category\Entities\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kblais\Uuid\Uuid;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * @property string id
 * @property string name
 * @property int amount
 * @property User user
 * @property Category category
 * @property Bank bank
 * @property array|null data
 * @property Carbon date_at;
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Expense extends Model implements Transformable
{
    use TransformableTrait, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
        'data'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

}
