<?php

namespace Modules\Question\Repository;

use Modules\Question\Entities\Question;

class QuestionRepo
{
    // get list of questions
    public function getQuestions(){
        return Question::with('answers')->where('status', 1)->whereNull('deleted_at')->get();
    }
}
