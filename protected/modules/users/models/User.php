<?php

class User extends ActiveRecordModel
{
    const PAGE_SIZE = 10;

    const STATUS_ACTIVE  = 'active';
    const STATUS_NEW     = 'new';
    const STATUS_BLOCKED = 'blocked';

    const GENDER_MAN   = "man";
    const GENDER_WOMAN = "woman";

    const SETTING_CHANGE_PASSWORD_REQUEST_MAIL_SUBJECT = 'change_password_request_mail_subject';
    const SETTING_CHANGE_PASSWORD_REQUEST_MAIL_BODY    = 'change_password_request_mail_body';
    const SETTING_ACTIVATE_REQUEST_DONE_MESSAGE        = 'activate_request_done_message';
    const SETTING_REGISTRATION_MAIL_SUBJECT            = 'registration_mail_subject';
    const SETTING_REGISTRATION_DONE_MESSAGE            = 'registration_done_message';
    const SETTING_REGISTRATION_MAIL_BODY               = 'registration_mail_body';

    public $password_c;

    public $captcha;

    public $remember_me = false;

    public $activate_error;

    public $new_password;

    public $activate_code;


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'users';
    }


    public static $status_list = array(
        self::STATUS_ACTIVE  => "Активный",
        self::STATUS_NEW     => "Новый",
        self::STATUS_BLOCKED => "Заблокирован"
    );


    public static $gender_list = array(
        self::GENDER_MAN   => "Мужской",
        self::GENDER_WOMAN => "Женский"
    );


    public function getName()
    {
        return implode(' ', array(
            $this->last_name ,
            $this->first_name ,
            $this->patronymic
        ));
    }


    public function getUserDir()
    {
        $dir  = "upload/users/" . $this->id . "/";
        $path = $_SERVER["DOCUMENT_ROOT"] . $dir;

        if (!file_exists($path))
        {
            mkdir($path);
            chmod($path, 0777);
        }

        return $dir;
    }


    public function rules()
    {
        return array(
//            array(
//                'captcha',
//                'application.extensions.recaptcha.EReCaptchaValidator',
//                'privateKey' => '6LcsjsMSAAAAAHGMdF84g3szTZZe0VVwMof5bD7Y',
//                'on' => array('Registration', 'ActivateRequest', 'ChangePasswordRequest')
//            ),
            array(
                'email, password',
                'required'
            ),
            array(
                'first_name, last_name, patronymic, phone',
                'required',
                'on' => array('Registration')
            ),
            array('first_name, last_name, patronymic','length', 'max' => 40),
            array('first_name, last_name, patronymic','ruLatAlpha'),
            array(
                'new_password',
                'required',
                'on' => 'ChangePassword'
            ),
            array(
                'birthdate, gender',
                'required',
                'on' => array('Registration')
            ),
            array(
                'password_c, password',
                'required',
                'on' => array(
                    'Registration',
                    'ChangePassword',
                    'ChangePassword',
                    'Update',
                    'Create'
                )
            ),

            array(
                'password',
                'required',
                'on' => 'Login'
            ),

            array(
                'password_c, new_password',
                'length',
                'min' => 6
            ),
            array(
                'password',
                'length',
                'min' => 6,
                'on' => array(
                    'Registration',
                    'ChangePassword',
                    'ChangePassword',
                    'Update',
                    'Create'
                )
            ),
            array('email', 'email'),
            array(
                'email',
                'unique',
                'attributeName' => 'email',
                'className' => 'User',
                'on' => 'Registration'
            ),
            array(
                'password_c',
                'compare',
                'compareAttribute' => 'password',
                'on' => array(
                    'Registration',
                    'ChangePassword',
                    'Update',
                    'Create'
                )
            ),
            array(
                'password_c',
                'compare',
                'compareAttribute' => 'new_password',
                'on' => 'ChangePassword'
            ),
            array('phone', 'phone'),
            array(
                'birthdate',
                'date',
                'format'  => 'dd.mm.yyyy',
                'message' => 'Верный формат даты (дд.мм.гггг) используйте календарь.'
            ),
            array('first_name, last_name, patronymic', 'length', 'min' => 2),
            array('email', 'length', 'max' => 200),
            array('gender', 'in', 'range' => array_keys(self::$gender_list)),
            array('status', 'in', 'range' => array_keys(self::$status_list)),
            array('birthdate,activate_code', 'safe'),
            array('email', 'filter', 'filter' => 'trim'),
            array('id, email, birthdate, gender, status, date_create','safe', 'on'=>'search'),
        );
    }


    public function relations()
    {
        return array(
            'assignment' => array(self::HAS_ONE, 'AuthAssignment', 'userid'),
            'role'       => array(self::HAS_ONE, 'AuthItem', 'itemname', 'through' => 'assignment')
		);
    }


    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id, true);
        $criteria->compare('email',$this->email, true);
        $criteria->compare('first_name',$this->first_name, true);
        $criteria->compare('last_name',$this->last_name, true);
        $criteria->compare('patronymic',$this->patronymic, true);
        $criteria->compare('birthdate',$this->birthdate, true);
        $criteria->compare('gender',$this->gender, true);
        $criteria->compare('status',$this->status, true);
        $criteria->compare('date_create',$this->date_create, true);
        $criteria->with = 'role';

		return new ActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'sort' => array('attributes' => array(
                'role' => array(
                    'asc'  => 'role.name',
                    'desc' => 'role.name DESC'
                ),
                '*'
            ))
		));
    }


    public function attributeLabels()
    {
        $attrs = array_merge(
            parent::attributeLabels(),
            array(
                "password_c"   => "Пароль еще раз",
                "remember_me"  => "Запомни меня",
                "captcha"      => "Введите код",
                "new_password" => "Новый пароль",
                "new_password" => "Новый пароль",
                "role"         => "Роль"
            )
        );

        return $attrs;
    }


    public function generateActivateCode()
    {
        $this->activate_code = md5($this->id . $this->name . $this->email . time(true) . rand(5, 10));
    }


    public function changePasswordRequest()
    {
        $settings = Settings::model()->getAll();

        $this->password_recover_code = md5($this->password . $this->email . $this->id . time());

        $body = $settings["PASSWORD_RECOVER_REQUEST_MAIL_BODY"]["value"];
        $body = str_replace(
            array("{name}", "{SITE_NAME}", "{LINK}"),
            array(
                $this->name,
                $settings["SITE_NAME"]["value"],
                "http://" . $_SERVER["HTTP_HOST"] . "/users/user/ChangePassword/id/" . $this->id . "/code/" . $this->password_recover_code
            ),
            $body
        );

        Mailer::sendMail($this->email, $settings["PASSWORD_RECOVER_REQUEST_MAIL_SUBJECT"]["value"], $body);

        $this->save();
    }
    

	public function getRole()
	{
		$assigment = AuthAssignment::model()->findByAttributes(array(
			'userid' => $this->id
		));

		if (!$assigment)
		{
			$assigment = new AuthAssignment();
			$assigment->itemname = AuthItem::ROLE_DEFAULT;
			$assigment->userid   = $this->id;
			$assigment->save();
		}

		return $assigment->role;
	}


    public function isRootRole()
    {
        return $this->role->name == AuthItem::ROLE_ROOT;
    }


    public function sendActivationMail()
    {
        $mailler_letter = MailerLetter::model();

        $subject = Setting::model()->getValue(self::SETTING_REGISTRATION_MAIL_SUBJECT);
        $subject = $mailler_letter->compileText($subject);

        $body = Setting::model()->getValue(self::SETTING_REGISTRATION_MAIL_BODY);
        $body = $mailler_letter->compileText($body, array('user' => $this));

        MailerModule::sendMail($this->email, $subject, $body);
    }


    public function activateAccountUrl()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'];
        $url.= Yii::app()->controller->url('/activateAccount/' . $this->activate_code . '/' . md5($this->email));
        return $url;
    }
}



















