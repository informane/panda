<?php

namespace controllers;

use models\User;

class PageController extends Controller{

    protected $title='Site';

    protected function actionIndex(){
        $this->render('page/index');
    }

    protected function actionLogin(){
        if (empty($_SESSION['login'])){
            if(!isset($_GET['User'])){
                $_SESSION['csrf_token']=uniqid('', true);
                $this->render('page/login', [
                    'csrf_token'=>$_SESSION['csrf_token']
                ]);
            }
            else {
                if(isset($_GET['csrf_token']) && !empty($_GET['csrf_token']) && $_GET['csrf_token']==$_SESSION['csrf_token']){
                    $user=User::activeRecord()->select()->where(['email'=>$_GET['User']['email'],'password'=>md5($_GET['User']['password'])])->one();
                    if(!empty($user)){
                        $_SESSION['login']=$user->email;
                        $_SESSION['user_id']=$user->id;
                        unset($_SESSION['csrf_token']);
                        $this->redirect('/survey/cabinet');
                    } else {
                        $this->render('page/login', [
                            'csrf_token'=>$_SESSION['csrf_token'],
                            'error'=>'User with these login and password is not found!'
                        ]);
                    }
                } else {
                    header('HTTP/1.0 403 Forbidden');
                }
            }
        } else {
            $this->redirect('/survey/cabinet');
        }
    }

    protected function actionLogout(){
        $this->logout();
        $this->redirect('/');
    }

    protected function logout(){
        unset($_SESSION['login']);
        unset($_SESSION['user_id']);
    }

    protected function actionRegister(){
        if(isset($_POST['User'])){
            if (isset($_POST['csrf_token']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']){
                $user=new User;
                $user->load($_POST['User']);
                $validResult=$user->validate();
                if ($validResult === true){
                    $user->save();
                    unset($_SESSION['csrf_token']);
                    $this->redirect('/page/login');
                } else {
                    $this->render('page/register', [
                        'csrf_token'=>$_SESSION['csrf_token'],
                        'validErrors'=>$validResult['errors']
                    ]);
                }
            } else {
                header('HTTP/1.0 403 Forbidden');
            }
        } else {
            $_SESSION['csrf_token']=uniqid('', true);
            $this->render('page/register', [
                'csrf_token'=>$_SESSION['csrf_token']
            ]);
        }

    }
}