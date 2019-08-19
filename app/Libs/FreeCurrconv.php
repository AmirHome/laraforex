<?php


namespace App\Libs;
use App\ApiKey;
use App\Log;


class FreeCurrconv
{
    private $apiKey;
    private $apiUrl;
    private $usdTry;
    private $eurTry;
    private $usdEur;
    private $eurUsd;

    public function __construct()
    {
        $this->apiUrl = 'https://free.currconv.com/api/v7/convert';
        $key = getApiKey($this->apiUrl);
        if (!empty($key)){
            $this->apiKey = $key->key;
            $this->setRates();
        }


    }

    public function getUsdTryRate()
    {
        return ['cost'=>number_format($this->usdTry, 4, '.', ''), 'date'=>date('Y-m-d h:i:s')];
    }

    public function getEurTryRate()
    {
        return ['cost'=>number_format($this->eurTry, 4, '.', ''), 'date'=>date('Y-m-d h:i:s')];

    }

    public function getUsdEurRate()
    {
        return ['cost'=>number_format($this->usdEur, 4, '.', ''), 'date'=>date('Y-m-d h:i:s')];

    }

    public function getEurUsdRate()
    {
        return ['cost'=>number_format($this->eurUsd, 4, '.', ''), 'date'=>date('Y-m-d h:i:s')];

    }

    private function setRates()
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$this->apiUrl}?q=USD_TRY,USD_EUR,EUR_TRY,EUR_USD&compact=ultra&apiKey={$this->apiKey}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 87698d6f-b950-4791-9acd-5534d8ff664d",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $obj = json_decode($response, true);

            $this->usdTry = floatval($obj['USD_TRY']);
            $this->usdEur = floatval($obj['USD_EUR']);
            $this->eurTry = floatval($obj['EUR_TRY']);
            $this->eurUsd = floatval($obj['EUR_USD']);        }



    }

}
