<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = false;
    protected $fillable = [
        'answer',
    ];
    public function sentence()
    {
        return $this->belongsTo(Keyword::class, 'id', 'message_id');
    }
}
