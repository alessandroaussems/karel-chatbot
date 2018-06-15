<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'keywords';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $nullable = [
        'message_id'
    ];
    protected $fillable = [
        'keyword',
        'message_id',
    ];
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
