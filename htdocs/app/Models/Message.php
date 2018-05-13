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
        return $this->belongsTo(Sentence::class, 'id', 'message_id');
    }
}
