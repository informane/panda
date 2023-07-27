<?php

namespace controllers;

use models\Answer;
use models\Question;

class SurveyController extends Controller{

    protected $title='Cabinet';

    protected function beforeAction(){
        parent::beforeAction();
        if(!isset($_SESSION['login'])){
            $this->redirect('/page/login');
        }
    }

    protected function actionCabinet($sortBy=[]){
        $questions=Question::activeRecord()->select()->where(['user_id'=>$_SESSION['user_id']])->orderBy($sortBy)->all();
        $this->render('survey/cabinet', [
            'questions'=>$questions
        ]);
    }

    protected function actionUpdate($id=0){
        if (!isset($_POST['Question'])){
            $_SESSION['csrf_token']=uniqid('', true);
            $question=new Question();
            if ($id){
                $question=Question::activeRecord()->select()->where(['id'=>$id])->one();
                $answers=Answer::activeRecord()->select()->where(['question_id'=>$question->id])->all();
            } else {
                $answers=[];
            }
            $this->render('survey/update', [
                'csrf_token'=>$_SESSION['csrf_token'],
                'question'  =>$question,
                'answers'   =>$answers
            ]);
        } else {
            if (isset($_POST['csrf_token']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
                $question=new Question();
                if ($id) $_POST['Question']['id']=$id;
                $_POST['Question']['user_id']=$_SESSION['user_id'];
                $question->load($_POST['Question']);
                $questionValidResult=$question->validate();
                $question_id=$question->save();
                if (!$question_id) $questionValidResult=false;
                $answers=[];
                $answersValidResults=[];
                $answersValidResult=true;
                foreach ($_POST['Answer'] as $i=>$answerPost){
                    if (empty($answerPost['text']) && empty($answerPost['votes_number'])) continue;
                    $answerPost['question_id']=$question_id;
                    $answers[$i]=new Answer();
                    $answers[$i]->load($answerPost);
                    $answersValidResults[$i]=$answers[$i]->validate();
                    if ($answersValidResults[$i] !== true) $answersValidResult=false;
                }
                if ($answersValidResult === true && $questionValidResult === true){
                    if ($question_id){
                        Answer::sync($question_id, $answers);
                    }
                    unset($_SESSION['csrf_token']);
                    $this->redirect('/survey/cabinet');
                } else {
                    $this->render('survey/update', [
                        'csrf_token'         =>$_SESSION['csrf_token'],
                        'question'           =>$question,
                        'answers'            =>$answers,
                        'questionValidErrors'=>$questionValidResult['errors'],
                        'answersValidErrors' =>$answersValidResults ?? null
                    ]);
                }
            } else {
                header('HTTP/1.0 403 Forbidden');
            }

        }
    }

    protected function actionView($id){
        $question=Question::activeRecord()->select()->where(['user_id'=>$_SESSION['user_id'],'id'=>$id])->one();
        if($question==null){
            header('HTTP/1.0 403 Forbidden');
        }
        $answers=Answer::activeRecord()->select()->where(['question_id'=>$id])->all();
        $this->render('survey/view', [
            'question'=>$question,
            'answers'=>$answers
        ]);
    }

    protected function actionRemove($id){
        if(Question::delete($id)){
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            header('HTTP/1.0 403 Forbidden');
        }
    }
}