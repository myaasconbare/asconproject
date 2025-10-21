<?php

namespace App\Services;

use App\Models\CryptoCurrency;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CoinGeckoService
{
    protected string $baseUrl = 'https://api.coingecko.com/api/v3/';

    /**
     * @throws GuzzleException
     */
    public function getCryptoPricesToFlat(string $cryptoId)
    {
        $response = Http::get($this->baseUrl . 'simple/price', [
            'query' => [
                'ids' => $cryptoId,
                'vs_currencies' => implode(',', array_keys($this->getFlatCurrency())),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param int $limit
     * @return array|null
     * @throws GuzzleException
     */
    public function getTopCryptoCurrencies(int $limit = 50): ?array
    {
        try {
            $response = Http::get($this->baseUrl . 'coins/markets', [
                'vs_currency' => 'usd',
                'order' => 'market_cap_desc',
                'per_page' => $limit,
                'page' => 1,
                'sparkline' => false,
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $exception) {

            return null;
        }
    }


    /**
     * @param int $limit
     * @return array|null
     */
    public function getTopGainerLoser(int $limit = 50): ?array
    {
        try {
            $response = Http::get($this->baseUrl . 'coins/markets', [
                'vs_currency' => 'usd',
                'order' => 'percent_change_24h',
                'per_page' => $limit,
                'page' => 1,
                'sparkline' => false,
            ]);

            return json_decode($response->getBody(), true);
        } catch (HttpException $exception) {

            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getCoinByName(string $name)
    {
        $response = Http::get($this->baseUrl . "coins/{$name}");
        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function getCoinRate(CryptoCurrency $cryptoCurrency)
    {

        $response = Http::get($this->baseUrl . 'simple/price', [
            'ids' => $cryptoCurrency->crypto_id,
            'vs_currencies' => 'usd'
        ]);

        return $response->json($cryptoCurrency->crypto_id . '.' . 'usd');
    }

    public function getFlatCurrency(): array
    {
        return include resource_path('data/currency_codes.php');
    }
}
