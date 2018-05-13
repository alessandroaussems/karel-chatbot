<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    protected $table = 'sentences';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $nullable = [
        'message_id'
    ];
    protected $fillable = [
        'sentence',
        'message_id',
    ];
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
