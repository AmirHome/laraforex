<?php


namespace App\Libs;
use App\ApiKey;
use App\Log;

class AlphaVantage
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://www.alphavantage.co/query';
        $key = $this->getApiKey();
        $this->apiKey = $key->key;

    }

    public function getUsdEurRate()
    {

        $from = 'USD';
        $to = 'EUR';
        $fnc = 'CURRENCY_EXCHANGE_RATE';

        $res = $this->sendRequest($fnc, $from, $to);
        $res = json_decode($res,true);

        if (isset($res['Realtime Currency Exchange Rate'])){

            return ['cost'=> $res['Realtime Currency Exchange Rate']['5. Exchange Rate'],
                'date'=> $res['Realtime Currency Exchange Rate']['6. Last Refreshed']];
        }

        return [];

    }

    public function getUsdTryRate()
    {

        $from = 'USD';
        $to = 'TRY';
        $fnc = 'CURRENCY_EXCHANGE_RATE';

        $res = $this->sendRequest($fnc, $from, $to);
        $res = json_decode($res,true);

        if (isset($res['Realtime Currency Exchange Rate'])){

            return ['cost'=> $res['Realtime Currency Exchange Rate']['5. Exchange Rate'],
                'date'=> $res['Realtime Currency Exchange Rate']['6. Last Refreshed']];
        }

        return [];

    }

    public function getEurTryRate()
    {

        $from = 'EUR';
        $to = 'TRY';
        $fnc = 'CURRENCY_EXCHANGE_RATE';

        $res = $this->sendRequest($fnc, $from, $to);
        $res = json_decode($res,true);

        if (isset($res['Realtime Currency Exchange Rate'])){

            return ['cost'=> $res['Realtime Currency Exchange Rate']['5. Exchange Rate'],
                'date'=> $res['Realtime Currency Exchange Rate']['6. Last Refreshed']];
        }

        return [];

    }

    /**
     * @param string $fnc
     * @param string $from
     * @param string $to
     * @return bool|string
     */
    protected function sendRequest(string $fnc, string $from, string $to)
    {
        $this->setTryKey();

        $curl = curl_init();

        $options = [CURLOPT_URL => "{$this->apiUrl}?function=$fnc&from_currency=$from&to_currency=$to&apikey={$this->apiKey}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_POSTFIELDS => "",
                    CURLOPT_HTTPHEADER => array(
                        "Postman-Token: 556b42b8-d349-454d-89c8-ea96dbd7b496",
                        "cache-control: no-cache"
                    ),
        ];

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

            $this->setLog($options, 0, $err);
            return $err;
        } else {
            $this->setLog($options, 1);
            return $response;
        }
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        $key = ApiKey::select('key')
            ->where('url', $this->apiUrl)
            ->orderBy('try')
            ->first();
        return $key;
    }

    protected function setTryKey(): void
    {
        $key = ApiKey::where('url', $this->apiUrl)
            ->where('key', $this->apiKey)
            ->first();
        $key->try = $key->try + 1;
        $key->save();
    }

    /**
     * @param array $options
     * @param int $status
     * @param string $err
     */
    protected function setLog(array $options, int $status, string $err = null): void
    {
        Log::create([
            'url' => $options[CURLOPT_URL],
            'method' => $options[CURLOPT_CUSTOMREQUEST],
            'status' => $status,
            'message' => $err,
        ]);
    }
}
