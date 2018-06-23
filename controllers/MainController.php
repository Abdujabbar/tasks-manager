<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 10:28 AM
 */
namespace controllers;
use system\App;
use system\Auth;
use system\Controller;
use system\Session;

class MainController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionIndex() {
        $this->render('main/index', []);
    }

    /**
     * @throws \Exception
     */
    public function actionLogin() {
        $login = $this->getRequest()->post('login');
        $password = $this->getRequest()->post('password');


        if(App::getInstance()->getRequest()->isPost()) {
            if(App::getInstance()->getAuthUser()->login($login, $password)) {
                Session::getInstance()->setFlash('success', 'You are successful authorized.');
                $this->redirect("/");
            } else {
                Session::getInstance()->setFlash('danger', 'login or password incorrect');
            }
        }
        $this->render("main/login", ['login' => $login, 'password' => $password]);
    }


    public function actionLogout() {
        $auth = App::getInstance()->getAuthUser();
        $auth->logout();
        Session::getInstance()->setFlash("success", "You are successful logout.");
        $this->redirect("/");
    }


}