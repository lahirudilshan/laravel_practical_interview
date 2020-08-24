<?php

namespace Modules\Question\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\UserAnswer;
use Modules\Question\Repository\QuestionRepo;
use Modules\User\Repository\UserRepo;

class QuestionController extends Controller
{
    private $questionRepo;
    private $userRepo;

    public function __construct(QuestionRepo $questionRepo, UserRepo $userRepo){
        $this->questionRepo = $questionRepo; 
        $this->userRepo     = $userRepo; 
    }
    /**
     * Display a listing of questions
     * @return Renderable
     */
    public function index()
    {
        $questions = $this->questionRepo->getQuestions();
        return view('question::index', compact('questions'));
    }

    

    /**
     * Show summery of feedbacks
     * @param request $request
     * @return Renderable || Response
     */
    public function summery(Request $request)
    {
        $tableHeaderHTML    = '';
        $tableBodyHTML      = '';
        $charts             = '<div class="col-12"><h5 class="mb-4">SUMMERY</h5></div>';
        $response           = [];
        $chartData          = [];

        $startDate  = $request->input('startDate');
        $endDate    = $request->input('endDate');

        $questions = $this->questionRepo->getQuestions();
        
        foreach($questions as $question){
            $tableHeaderHTML .= '<td>'.($question->name ?? '-').'</td>';

            $charts .= 
                '<div class="col-4 mx-auto">
                    <canvas id="chart_'.$question->id.'" data-question-id="'.$question->id.'" data-label="'.$question->name.'" class="charts p-4" width="400" height="400"></canvas>
                </div>';
        }

        if($startDate || $endDate){
            // get user feedbacks from database
            $userFeedbacks  = $this->userRepo->getUserFeedbacks($startDate, $endDate, ['limit' => 2]);
            // get data from charts
            $chartData      = $this->userRepo->getChartData($startDate, $endDate);

            if($userFeedbacks){
                foreach($userFeedbacks as $feedback){
                    $tableBodyHTML .= '<tr>';
                    $tableBodyHTML .= '<td>'.($feedback->email ?? '-').'</td>';

                    if($feedback->userAnswers){
                        foreach($feedback->userAnswers as $userAnswer){    
                            $tableBodyHTML .= '<td>'.($userAnswer->answer->name ?? '-').'</td>';
                        }
                    }

                    // if user not give answers to every questions then generate - for spaces
                    $remainIteration = count($questions) - count($feedback->userAnswers);

                    if($remainIteration){
                        $tableBodyHTML .= str_repeat('<td>-</td>', $remainIteration);
                    }

                    $tableBodyHTML .= '</tr>';
                }

                $response['pagination'] = (string) $userFeedbacks->links();
                $response['chartsHTML'] = $charts;
            }
        }
        
        if($tableBodyHTML == ''){
            if($request->isMethod('post')){
                $tableBodyHTML = '<tr><td class="text-center" colspan="'.(count($questions) + 1).'">Feedback(s) not found!</td></tr>';
            }else{
                $tableBodyHTML = '<tr><td class="text-center" colspan="'.(count($questions) + 1).'">Use Filter for better Result!</td></tr>';
            }

            // if validations fails
            if($startDate == ''){
                $response['errors']['startDate'] = ['message' => 'Please select start date.'];
            }

            if($endDate == ''){
                $response['errors']['endDate'] = ['message' => 'Please select end date.'];
            }

            $response['success'] = false;
            $response['data'] = $tableBodyHTML;
        }else{
            $response['success'] = true;
            $response['data'] = $tableBodyHTML;
        }
        
        if($request->isMethod('post')){
            // response json when filtering data using ajax
            $response['chartData'] = $chartData;

            return Response()->json($response);
        }else{
            return view('question::summery', compact('tableHeaderHTML', 'tableBodyHTML', 'questions',));
        }
    }
}
