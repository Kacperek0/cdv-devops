<?php
/**
 * User: gmatk
 * Date: 28.06.2022
 * Time: 15:48
 */

namespace App\Domain\Bank\Reports\Decoders\Ipko\Mappers;

/**
 *
 */
class DescriptionMapper
{
    /**
     * @var array|string[]
     */
    private array $direct = [
        'Wypłata z bankomatu',
        'Spłata kredytu',
        'Opłata składki ubezpieczeniowej',
        'Opłata'
    ];

    /**
     * @param array $record
     * @return string
     */
    public function get(array $record): string
    {
        $type = $record[2] ?? '';

        if (in_array($type, $this->direct, true)) {
            return $type;
        }

        return sprintf('%s: %s', $type, $this->getAddress($record));
    }

    /**
     * @param $record
     * @return string
     */
    protected function getAddress($record): string
    {
        $title = $record[8] ?? '';
        if (preg_match('#Adres\:(.*)#', $title, $matches)) {
            return $matches[1];
        }

        return $title;
    }
}
