<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'message_id',
        's3_file_path',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
