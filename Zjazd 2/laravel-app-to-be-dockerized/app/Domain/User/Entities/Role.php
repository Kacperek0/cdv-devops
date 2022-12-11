<?php

namespace App\Domain\User\Entities;

use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Permission\Models\Role as BaseRole;

/**
 * @property int id
 * @property string name
 * @property string guard_name
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Role extends BaseRole implements Transformable
{
    use TransformableTrait;

    public const DEFAULT_ROLE = 'user';
    public const AMIN_ROLE = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
