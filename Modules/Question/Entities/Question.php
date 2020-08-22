<?php

namespace Modules\Question\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{   
    protected $table = 'question';
    protected $fillable = [];

    public function answers() {
        return $this->hasMany('Modules\Question\Entities\Answer');
    }
}
