<?php
/**
 * User: gmatk
 * Date: 12.05.2021
 * Time: 11:34
 */

namespace App\Infrastructure\Contracts;

use Illuminate\Console\Scheduling\Schedule;

/**
 * Interface ScheduleContract
 * @package Pokato\Support\Contracts
 */
interface ScheduleContract
{
    /**
     * @param Schedule $schedule
     */
    public function handle(Schedule $schedule): void;
}
