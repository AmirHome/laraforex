<?php

use App\ApiKey;

if (! function_exists('getApiKey')) {
    /**
     * @return mixed
     */
    function getApiKey($apiUrl)
    {
        $key = ApiKey::select('key')
            ->where('url', $apiUrl)
            ->orderBy('try')
            ->first();
        return $key;
    }
}
