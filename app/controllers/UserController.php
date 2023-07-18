<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\UsersModel;

class UserController extends InitController
{
    public function actionProfile()
    {
        echo "Страница профиля";
        var_dump($this->route);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['login', 'registration'],
                        'roles' => [UserOperations::RoleGuest],
                        'matchCallbak' => function () {
                            $this->redirect('/user/profile');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionRegistration()
    {
        $this->view->title = 'Регистрация';
        $error_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_registration_form'])) {
            $username = !empty($_POST['username']) ? $_POST['username'] : null;
            $login = !empty($_POST['login']) ? $_POST['login'] : null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
            if (empty($username)) {
                $error_message .= "Введите ваше имя!<br>";
            }
            if (empty($login)) {
                $error_message .= "Введите ваш логин!<br>";
            }
            if (empty($password)) {
                $error_message .= "Введите пароль!<br>";
            }
            if (empty($confirm_password)) {
                $error_message .= "Введите повторный пароль!<br>";
            }
            if (($password != $confirm_password)) {
                $error_message .= "Пароли не совпадают!<br>";
            }
            if (empty($error_message)) {
                $userModel = new UsersModel();
                $user_id = $userModel->addNewUser($username, $login, $password);
                if (!empty($user_id)) {
                    $this->redirect('/user/profile');
                }
            }
        }
        $this->render('registration', [
            'error_message' => $error_message
        ]);
    }
}