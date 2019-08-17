<?php

namespace App\Libs;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class DBFirebase {

    public $fbDatabase;
    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(public_path().'/../droidforex-6c516-firebase-adminsdk-98xf2-9857c69504.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://droidforex-6c516.firebaseio.com/')
            ->create();
        $this->fbDatabase = $firebase->getDatabase();

    }

    public function getEurTryChild($path){
        return $this->fbDatabase->getReference('/forex/latest/EUR_TRY/'.$path)->getValue();
    }
    public function getUsdTryChild($path){
        return $this->fbDatabase->getReference('/forex/latest/USD_TRY/'.$path)->getValue();
    }
    public function getUsdEurChild($path){
        return $this->fbDatabase->getReference('/forex/latest/USD_EUR/'.$path)->getValue();
    }

    public function setEurTryCost($values){
        return $this->fbDatabase->getReference('/forex/latest/EUR_TRY')->set($values);
    }
    public function setUsdTryCost($values){
        return $this->fbDatabase->getReference('/forex/latest/USD_TRY')->set($values);
    }
    public function setUsdEurCost($values){
        return $this->fbDatabase->getReference('/forex/latest/USD_EUR')->set($values);
    }


}
