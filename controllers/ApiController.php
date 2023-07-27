<?php


namespace controllers;


use models\Question;
use models\User;

class ApiController extends Controller{

    public function actionGetrandomsurvey($email, $password){
        $user=User::activeRecord()->select()->where(['email'=>$email, 'password'=>md5($password)])->one();
        if ($user){
            $id=2;
            $questions=Question::activeRecord()->select(['id'])->where(['user_id'=>$user->id])->all();
            $ids=[];
            foreach ($questions as $question){
                $ids[]=$question->id;
            }
            $id=$ids[array_rand($ids)];
            $surveys=Question::activeRecord()->select(['question.id', 'question.text as text', 'answer.text as answer_text', 'answer.votes_number'])->leftJoin('answer', ['question.id'=>'answer.question_id'])->where(['question.id'=>$id])->all();
            $returnArray=[];
            foreach ($surveys as $i=>$survey){
                $returnArray[$survey->text][$i]['answer_text']=$survey->answer_text;
                $returnArray[$survey->text][$i]['votes_number']=$survey->votes_number;
            }
            echo $return=json_encode($returnArray);
        }
        else {
            echo $return=json_encode(['error'=>'User with this credentials is not found!']);
        }
    }
}