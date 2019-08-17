<?php


namespace App\Libs;


class AlphaVantage
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = '0ZAKNLTUR1PF3NM6';
        $this->apiUrl = 'https://www.alphavantage.co/query';
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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$this->apiUrl}?function=$fnc&from_currency=$from&to_currency=$to&apikey={$this->apiKey}",
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
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
