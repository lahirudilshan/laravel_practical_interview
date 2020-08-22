<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answer';
    protected $fillable = ['answer_id', 'status', 'created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function answer() {
        return $this->belongsTo('Modules\Question\Entities\Answer');
    }

    public function question() {
        return $this->belongsTo('Modules\Question\Entities\Question');
    }
}
