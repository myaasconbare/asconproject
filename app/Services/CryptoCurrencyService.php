<?php

namespace App\Services;

use App\Models\CryptoCurrency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class CryptoCurrencyService
{

    /**
     * @param int|string $id
     * @return CryptoCurrency|null
     */
    public function findById(int|string $id): ?CryptoCurrency
    {
        return CryptoCurrency::find($id);
    }


    /**
     * @param string $pair
     * @return CryptoCurrency|null
     */
    public function findByPair(string $pair): ?CryptoCurrency
    {
        return CryptoCurrency::where('crypto_id', $pair)->first();
    }


    public function getCryptoCurrencyByPaginate()
    {
        return CryptoCurrency::filter(request()->all())->paginate(20);
    }

    /**
     * @param array $data
     * @return array
     */
    public function prepParams(array $data): array
    {
        $image = Arr::get($data, 'image', '');

        return [
            'name' => Arr::get($data, 'name', ''),
            'pair' => strtoupper(Arr::get($data, 'symbol', '')) . '/' . 'USDT',
            'crypto_id' => Arr::get($data, 'id', ''),
            'symbol' => Arr::get($data, 'symbol', ''),
            'image' => is_array($image) ? Arr::get($image, 'large') : $image,
            'meta' => [
                'current_price' => Arr::get($data, 'current_price', ''),
                'market_cap' => Arr::get($data, 'market_cap', ''),
                'total_volume' => Arr::get($data, 'total_volume', ''),
                'high_24h' => Arr::get($data, 'high_24h', ''),
                'low_24h' => Arr::get($data, 'low_24h', ''),
                'price_change_24h' => Arr::get($data, 'price_change_24h', ''),
                'market_cap_change_24h' => Arr::get($data, 'market_cap_change_24h', ''),
                'total_supply' => Arr::get($data, 'total_supply', ''),
            ],
            'is_active' => 1,
        ];
    }

    /**
     *
     * @param array $params
     * @return CryptoCurrency
     */
    public function save(array $params): CryptoCurrency
    {
        return CryptoCurrency::updateOrCreate(
            ['crypto_id' => Arr::get($params, 'crypto_id')],
            $params
        );
    }

    public function cryptoSave(): void
    {
        $coinGeckoService = new CoinGeckoService;

        $topCryptoCurrencies = $coinGeckoService->getTopCryptoCurrencies(100);
        if (!is_null($topCryptoCurrencies)) {
            foreach ($topCryptoCurrencies as $value) {
                $this->save($this->prepParams($value));
            }
        }
    }



    /**
     * @param array $with
     * @return Collection
     */
    public function getActiveCryptoCurrency(array $with = []): Collection
    {
        return CryptoCurrency::with($with)
            ->where('is_active', 1)
            ->get();
    }

    public function getActiveCryptoCurrencyByPaginate()
    {
        return CryptoCurrency::where('is_active', 1)->paginate(20);
    }

    public function getTopGainerLoser(): void
    {
        $coinGeckoService = app(CoinGeckoService::class);
        $crypto  = $coinGeckoService->getTopGainerLoser();

        $this->cryptoUpdate(array_slice($crypto, 0, 10), 'top_gainer');
        $this->cryptoUpdate(array_slice($crypto, -10, 10), 'top_loser');
    }

    protected function cryptoUpdate(array $crypto, string $key): void
    {
        $x = 1;
        foreach ($crypto as $value) {
            $params = $this->prepParams($value);
            $params[$key] = $x;
            $this->save($params);
            $x++;
        }
    }
}
