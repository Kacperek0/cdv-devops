<?php
/**
 * User: gmatk
 * Date: 29.06.2022
 * Time: 09:48
 */

namespace App\Interfaces\Console\Commands;

use App\Infrastructure\Services\Bnip\BnipService;
use App\Infrastructure\Services\Bnip\Exceptions\BnipException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\ContentLengthException;
use PHPHtmlParser\Exceptions\LogicalException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;

/**
 *
 */
class BnipSearchCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'bip:search';

    /**
     * @var string
     */
    protected $description = 'Search BNip';

    /**
     * @throws BnipException
     * @throws GuzzleException
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws ContentLengthException
     * @throws LogicalException
     * @throws NotLoadedException
     * @throws StrictException
     */
    public function handle(): void
    {
        $service = new BnipService();
        $results = $service->findNips($this->ask('Phrase?', 'santander pl'));
        print_r($results);
    }
}
