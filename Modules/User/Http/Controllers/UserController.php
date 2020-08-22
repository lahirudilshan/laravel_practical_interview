<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Entities\UserAnswer;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * show email sign in UI
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
    }    

    /**
     * store user in db
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);
        
        try{
            $email = $request->input('email');

            $user = User::with(['userAnswers'])->where('email', $email)->first();

            // only feedback not given user can give a feedback 
            if($user && count($user->userAnswers)){
                return redirect()->route('user.feedback')->with([
                    'info' => true,
                    'info.message' => 'You have already given Feedback!'
                ]);
            }else{
                $newUser                = new User();
                $newUser->email         = $request->input('email');
                $newUser->status        = 1;
                $newUser->created_at    = date('Y-m-d H:i:s'); 
                $newUser->updated_at    = date('Y-m-d H:i:s'); 
                $newUser->save();

                if($newUser){
                    // put created user id in session for access in other pages
                    Session::put('user', $newUser->id);
                    return redirect()->route('question');
                }
            }
        }catch(\Exception $e){
            return redirect()->route('user.feedback')->with([
                'error' => true,
                'error.message' => $e->getMessage()
            ]);
        }
    }

    /**
     * store user selected answers in db
     * @param Request $request
     * @return Redirection
     */
    public function answer_store(Request $request)
    {
        $validatedData = $request->validate([
            'answer' => 'required'
        ]);
            
        try{
            $userAnswers = $request->input('answer');

            foreach($userAnswers as $question => $answer){
                $userAnswer                 = new UserAnswer();
                $userAnswer->user_id        = Session::get('user');
                $userAnswer->answer_id      = $answer;
                $userAnswer->question_id    = $question;
                $userAnswer->status         = 1;
                $userAnswer->created_at     = date('Y-m-d H:i:s'); 
                $userAnswer->updated_at     = date('Y-m-d H:i:s'); 
                $userAnswer->save();
            }

            if($userAnswer){
                return redirect()->route('user.feedback.greeting');
            }
        }catch(\Exception $e){
            return redirect()->route('user.feedback')->with([
                'error' => true,
                'error.message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show a message for users
     * @return Renderable
     */
    public function greeting()
    {
        // remove session when user complete the feedback
        Session::flush();
        return view('user::greeting');
    }
}
