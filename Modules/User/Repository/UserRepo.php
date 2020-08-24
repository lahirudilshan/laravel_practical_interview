<?php

namespace Modules\User\Repository;

use Modules\User\Entities\User;
use Modules\User\Entities\UserAnswer;

class UserRepo
{
    /**
     * get user feedbacks from database
     * @param startData
     * @param endData
     * @param pagination
     * @return userFeedback
     */
    public function getUserFeedbacks($startDate, $endDate, $pagination){
        $user = User::with(['userAnswers.answer.question']);

        $user->whereHas('userAnswers', function($q) use($startDate, $endDate){            
            if($startDate){
                $q->whereDate('user_answer.created_at', '>=', $startDate);
            }

            if($endDate){
                $q->whereDate('user_answer.created_at', '<=', $endDate);
            }
        });

        if($pagination){
            return $user->paginate($pagination['limit']);
        }else{
            return $user->get();
        }
    }

    /**
     * get data form charts
     * @param startData
     * @param endData
     * @return UserAnswers
     */
    public function getChartData($startDate, $endDate){
        $userAnswer = userAnswer::selectRaw('*, count(answer_id) as answer_count')
            ->with(['answer', 'question'])
            ->groupBy(['question_id', 'answer_id']);

        if($startDate){
            $userAnswer->whereDate('created_at', '>=', $startDate);
        }

        if($endDate){
            $userAnswer->whereDate('created_at', '<=', $endDate);
        }

        return $userAnswer->get();
    }
}
