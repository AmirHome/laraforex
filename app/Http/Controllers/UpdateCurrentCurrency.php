<?php

namespace App\Http\Controllers;

use App\Libs\FreeCurrconv;
use Illuminate\Http\Request;
use App\Libs\DBFirebase;
use App\Libs\AlphaVantage;


class UpdateCurrentCurrency extends Controller
{
    protected $dbFirebase;
    protected $vantage;
    protected $currconv;

    public function __construct(DBFirebase $dbFirebase,
                                AlphaVantage $vantage,
                                FreeCurrconv $currconv
    ) {
        $this->dbFirebase = $dbFirebase;
        $this->vantage = $vantage;
        $this->currconv = $currconv;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $current = $this->currconv->getUsdTryRate();
        $forecast = ['next_hour'=>['cost'=>'7.3', 'status'=>'0.901'], 'tomorrow'=>['cost'=>'7.3', 'status'=>'0.901']];
        if(!empty($current)) {
            $this->dbFirebase->setUsdTryCost(array_merge($current, $forecast));
        }

        $current = $this->currconv->getEurTryRate();
        $forecast = ['next_hour'=>['cost'=>'7.3', 'status'=>'0.901'], 'tomorrow'=>['cost'=>'7.3', 'status'=>'0.901']];
        if(!empty($current)) {
            $this->dbFirebase->setEurTryCost(array_merge($current, $forecast));
        }

        $current = $this->currconv->getUsdEurRate();
        $forecast = ['next_hour'=>['cost'=>'7.3', 'status'=>'0.901'], 'tomorrow'=>['cost'=>'7.3', 'status'=>'0.901']];
        if(!empty($current)){

            $this->dbFirebase->setUsdEurCost(array_merge($current,$forecast));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
