<?php
/**
 * User: gmatk
 * Date: 29.06.2022
 * Time: 09:30
 */

namespace App\Infrastructure\Services\Bnip;

use App\Infrastructure\Services\Bnip\Exceptions\BnipException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\ContentLengthException;
use PHPHtmlParser\Exceptions\LogicalException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;

/**
 *
 */
class BnipService
{
    /**
     *
     */
    protected const URL = 'http://bnip.pl';

    /**
     * @var Client
     */
    private Client $client;

    /**
     *
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::URL,
        ]);
    }

    /**
     * @param string $phrase
     * @return array
     * @throws BnipException
     * @throws GuzzleException
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws ContentLengthException
     * @throws LogicalException
     * @throws NotLoadedException
     * @throws StrictException
     */
    public function findNips(string $phrase): array
    {
        $params = [
            'form_params' => [
                'q' => $phrase,
                'szukaj' => 'Szukaj'
            ]
        ];

        $response = $this->client->request('POST', '/', $params);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new BnipException(__('Bnip request error!'));
        }

        $body = (string)$response->getBody();
        $body = iconv('iso-8859-2', 'UTF-8', $body);
        $body = preg_replace('#iso-8859-2#','UTF-8', $body);

        $dom = new Dom();
        $dom->loadStr($body);
        $tables = $dom->find('table');

        if ($tables->count() === 0) {
            throw new BnipException(__('Bnip HTML error!'));
        }

        $table = $tables[0];
        $rows = $table->find('tr');

        $results = [];
        foreach ($rows as $row) {
            $results[] = [
                'name' => $row->find('td.td_l h3')->text,
                'nip' => $row->find('td.td_r')->text
            ];
        }

        return $results;
    }
}
