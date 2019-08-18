<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Log extends Model
{
    protected $fillable = ['url',
                        'method',
                        'status',
                        'message'];
}
