<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livechat extends Model
{
    protected $table = 'livechats';
    public $timestamps = false;
    protected $fillable = [
        'session_id',
    ];
    public function session()
    {
        return $this->belongsTo(Session::class, 'id', 'session_id');
    }
}
