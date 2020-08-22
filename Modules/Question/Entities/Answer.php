<?php

namespace Modules\Question\Entities;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{   
    protected $table = 'answer';
    protected $fillable = [];

    public function question()
    {
        return $this->belongsTo('Modules\Question\Entities\Question');
    }
}
