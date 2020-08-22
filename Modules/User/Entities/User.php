<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['email'];

    public function userAnswers() {
        return $this->hasMany('Modules\User\Entities\UserAnswer');
    }
}
