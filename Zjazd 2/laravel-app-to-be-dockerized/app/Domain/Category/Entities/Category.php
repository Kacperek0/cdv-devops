<?php

namespace App\Domain\Category\Entities;

use App\Domain\Category\Database\Factories\CategoryFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kblais\Uuid\Uuid;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * @property string id
 * @property string name
 * @property string color
 * @property Collection couplings
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Category extends Model implements Transformable
{
    use TransformableTrait, Uuid, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color'
    ];

    /**
     * @return HasMany
     */
    public function couplings(): HasMany
    {
        return $this->hasMany(CategoryCoupling::class);
    }

    /**
     * @return CategoryFactory
     */
    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
