<?php

namespace App\Domain\Category\Entities;

use App\Domain\Category\Database\Factories\CategoryCouplingFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * @property string id
 * @property string name
 * @property Category $category
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class CategoryCoupling extends Model implements Transformable
{
    use TransformableTrait, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return CategoryCouplingFactory
     */
    protected static function newFactory(): CategoryCouplingFactory
    {
        return CategoryCouplingFactory::new();
    }

}
