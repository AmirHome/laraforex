<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TechnicalIndicator extends Model
{
    protected $fillable = [
                            'open',
                            'high',
                            'low',
                            'close',
                            'bb_up',
                            'bb_middel',
                            'bb_low',
                            'rsi',
                            'mom',
                            'macd_signal',
                            'macd',
                            'macd_hist',
                            'ema10',
                            'ema50',
                            'ema100',
                            'ema200',
                            'symbol_pair',
                            'date',
                            'time',];
}
