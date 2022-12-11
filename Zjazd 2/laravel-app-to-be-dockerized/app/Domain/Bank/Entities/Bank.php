<?php

namespace App\Domain\Bank\Entities;

use App\Domain\Bank\Database\Factories\BankFactory;
use App\Domain\Bank\Reports\Contracts\ReportStrategyContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kblais\Uuid\Uuid;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Domain\Bank\Reports\ReportService;

/**
 * @property string id
 * @property string name
 * @property string logo
 * @property boolean active
 */
class Bank extends Model implements Transformable
{
    use TransformableTrait, Uuid, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'logo',
        'active'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * @return BankFactory
     */
    protected static function newFactory(): BankFactory
    {
        return BankFactory::new();
    }

    /**
     * @return string
     */
    public function getIdentificator(): string
    {
        return Str::slug($this->name, '_');
    }

    /**
     * @return ReportStrategyContract|null
     */
    public function getReportStrategy(): ?ReportStrategyContract
    {
        $strategyClass = ReportService::$strategies[$this->getIdentificator()] ?? null;
        if (!$strategyClass) {
            return null;
        }

        return app($strategyClass);
    }

}
