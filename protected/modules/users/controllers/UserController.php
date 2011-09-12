<?php

class UserController extends BaseController
{
    const ERROR_PASSWORD_RECOVER_AUTH = 'Вы не можете восстановить пароль будучи авторизованным!';
    
    
    public static function actionsTitles() 
    {
        return array(
            "Login"  => "Авторизация",
            "Logout" => "Выход",
            "Export" => "Экспорт",
        );
    }
    

    public function filters()
    {   
        return array('accessControl');
    }


    public function loadModel($id)
    {
        $model=User::model()->findByPk((int)$id);
        if($model===null)
        {
            $this->pageNotFound();
        }

        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionLogin()
    {   
        if (!Yii::app()->user->isGuest)
        {
            throw new CException('Вы уже авторизованы!');
        }

        $model = new User('Login');

        $form = new BaseForm('users.LoginForm', $model);

        if (isset($_POST['User']['email']) && isset($_POST['User']["password"]))
        {
            $model->attributes = $_POST['User'];

            if ($model->validate())
            {
                $identity = new UserIdentity($model->email, $model->password);
                if ($identity->authenticate())
                {   
                    $this->redirect($this->url('/'));
                }
                else 
                {
                    $auth_error = $identity->errorCode;
                }    
            }
        }

        $this->render('Login', array(
            'form'       => $form,
            'auth_error' => isset($auth_error) ? $auth_error : null
        ));
    }


    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


    public function actionRegistration()
    {
        if (!Yii::app()->user->isGuest)
        {
            throw new CException('Вы уже зарегистрированы!');
        }

        $model = new User('Registration');

        $form = new BaseForm('users.RegistrationForm', $model);

        $this->performAjaxValidation($model);

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->validate() && $model->register($_POST['User']))
            {
                $_SESSION["RegistrationDone"] = true;
                $this->redirect($this->url('/users/user/RegistrationDone'));
            }
        }

        $this->render('Registration', array('form' => $form));
    }


    public function actionRegistrationDone()
    {
        if (isset($_SESSION['RegistrationDone']))
        {
            $this->render('RegistrationDone', array(
                'msg' => Settings::model()->get('REGISTRATION_DONE_MESSAGE')
            ));
        }
        else
        {
            $this->pageNotFound();
        }
    }


    public function actionActivate($code, $email)
    {
        $attrs = array('activate_code' => $code, 'email' => $email);

        $user = new User('Activate');
        $user->attributes = $attrs;

        if ($user->validate() && $user->activate($attrs))
        {
            $_SESSION['Activate'] = true;
            $this->redirect('/users/user/login/from/activate');
        }

        $this->render('Activate');
    }


    public function actionActivateRequest()
    {
        if (!Yii::app()->user->isGuest)
        {
            throw new CException('Вы уже зарегистрированы!');
        }

        $model = new User('ActivateRequest');

        $form = new BaseForm('users.ActivateRequestForm', $model);

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->validate())
            {
                $user = $model->findByAttributes(array('email' => $_POST['User']['email']));

                if (!$user)
                {
                    $error = User::ERROR_UNKNOWN;
                }
                else
                {
                    switch ($user->status)
                    {
                        case User::STATUS_NEW:
                            $user->generateActivateCodeAndDate();
                            $user->save();
                            $user->sendActivationMail();
                            $_SESSION['ActivateRequestDone'] = true;
                            $this->redirect('/users/user/ActivateRequestDone');
                            break;

                        case User::STATUS_ACTIVE:
                            $error = UserIdentity::ERROR_ALREADY_ACTIVE;
                            break;

                        case User::STATUS_BLOCKED:
                            $error = UserIdentity::ERROR_BLOCKED;
                            break;
                    }
                }
            }
        }

        $this->render('ActivateRequest', array(
            'form'  => $form,
            'error' => isset($error) ? $error : null
        ));
    }


    public function actionActivateRequestDone()
    {
        if (isset($_SESSION['ActivateRequestDone']))
        {
            $this->render('ActivateRequestDone', array(
                'msg' => Settings::model()->get('ACTIVATE_REQUEST_DONE_MESSAGE')
            ));
        }
        else
        {
            $this->pageNotFound();
        }
    }


    public function actionChangePassword()
    {
        $model = new User('ChangePassword');

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->validate())
            {
                $user = $model->findByAttributes(array('password' => md5($_POST['User']['password'])));
                if ($user)
                {
                    $user->password = md5($_POST['User']['new_password']);
                    $user->save();

                    $this->redirect('/users/user/profile/msg/changePassword');
                }
                else
                {
                    $fail = true;
                }
            }
        }

        $this->render(
            'ChangePassword',
            array(
                'model' => $model,
                'fail'  => isset($fail) ? $fail : false,
                'done'  => isset($done) ? $done : false
            )
        );
    }


    public function actionPasswordRecoverRequest()
    {
        if (!Yii::app()->user->isGuest)
        {
            throw new CHttpException(SELF::ERROR_PASSWORD_RECOVER_AUTH);
        }

        $model = new User('PasswordRecoverRequest');
        $form  = new BaseForm('users.PasswordRecoverRequestForm', $model);

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            if ($model->validate())
            {
                $user = $model->findByAttributes(array('email' => $model->email));
                if ($user)
                {
                    if ($user->status == User::STATUS_ACTIVE)
                    {
                        $user->passwordRecoverRequest();
                        $_SESSION['PasswordRecoverRequestDone'] = true;
                        $this->redirect('/users/user/passwordRecoverRequestDone');

                    }
                    else if ($user->status == User::STATUS_NEW)
                    {
                        $error = UserIdentity::ERROR_NOT_ACTIVE;
                    }
                    else
                    {
                        $error = UserIdentity::ERROR_BLOCKED;
                    }
                }
                else
                {
                    $error = UserIdentity::ERROR_UNKNOWN;
                }
            }
        }

        $this->render("PasswordRecoverRequest", array(
            'form'  => $form,
            'error' => isset($error) ? $error : null
        ));
    }


    public function actionPasswordRecoverRequestDone()
    {
        if (!isset($_SESSION['PasswordRecoverRequestDone']))
            $this->forbidden();

        $this->render('PasswordRecoverRequestDone');
    }


    public function actionPasswordRecover()
    {
        if (!Yii::app()->user->isGuest)
        {
            throw new CHttpException(SELF::ERROR_PASSWORD_RECOVER_AUTH);
        }

        $bad_request = !isset($_GET['id'])      ||
                       !is_numeric($_GET['id']) ||
                       !isset($_GET['code'])    ||
                       mb_strlen($_GET['code']) != 32;

        if ($bad_request)
        {
            $this->forbidden();
        }

        $model = new User('PasswordRecover');
        $form  = new BaseForm('users.PasswordRecoverForm', $model);
        $user  = $model->findByPk($_GET['id']);

        if (!$user || $user->password_recover_code != $_GET['code'])
        {
            $this->forbidden();
        }
        else
        {
            if (strtotime($user->password_recover_date) + 24 * 3600 > time())
            {
                if (isset($_POST['User']))
                {
                    $model->attributes = $_POST['User'];
                    if ($model->validate())
                    {
                        $user->password_recover_code = null;
                        $user->password_recover_date = null;
                        $user->password = md5($_POST['User']['password']);
                        $user->save();

                        $_SESSION['PasswordRecover'] = true;

                        $this->redirect('/users/user/login/from/password_recover');
                    }
                }
            }
            else
            {
                $error = 'С момента запроса на восстановление пароля прошло больше суток!';
            }
        }

        $this->render('PasswordRecover', array(
            'model' => $model,
            'form'  => $form,
            'error' => isset($error) ? $error : null
        ));
    }
}
