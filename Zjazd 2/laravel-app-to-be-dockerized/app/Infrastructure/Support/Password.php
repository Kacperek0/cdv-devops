<?php
/**
 * User: gmatk
 * Date: 27.06.2022
 * Time: 18:34
 */

namespace App\Infrastructure\Support;

use Hackzilla\PasswordGenerator\Exception\CharactersNotFoundException;
use Hackzilla\PasswordGenerator\Exception\ImpossibleMinMaxLimitsException;
use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;
use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;

class Password
{
    /**
     * @throws CharactersNotFoundException
     * @throws ImpossibleMinMaxLimitsException
     */
    public static function generate(): string
    {
        $generator = new RequirementPasswordGenerator();
        $generator
            ->setLength(16)
            ->setMinimumCount(ComputerPasswordGenerator::OPTION_UPPER_CASE, 1)
            ->setMinimumCount(ComputerPasswordGenerator::OPTION_LOWER_CASE, 1)
            ->setMinimumCount(ComputerPasswordGenerator::OPTION_NUMBERS, 1);
        return $generator->generatePassword();
    }
}
