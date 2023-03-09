<?php

namespace App\Domain\User\Entities;

use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * @property int id
 * @property string name
 * @property string guard_name
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Permission extends BasePermission implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
