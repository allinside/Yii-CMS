<?php

class User extends ActiveRecordModel
{
    const STATUS_ACTIVE  = 'active';
    const STATUS_NEW     = 'new';
    const STATUS_BLOCKED = 'blocked';

    const GENDER_MAN   = "man";
    const GENDER_WOMAN = "woman";

    const CLUB_STATUS_CANDIDATE = "candidate";
    const CLUB_STATUS_CLUBMAN   = "clubman";	

    public $password_c;

    public $captcha;

    public $remember_me = false;

    public $activate_error;

    public $new_password;


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

	
    public static $club_status_list = array(
        self::CLUB_STATUS_CANDIDATE => "кандидат в члены клуба",
		self::CLUB_STATUS_CLUBMAN   => "член клуба"
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
            array(
                'captcha',
                'application.extensions.recaptcha.EReCaptchaValidator',
                'privateKey' => '6LcsjsMSAAAAAHGMdF84g3szTZZe0VVwMof5bD7Y',
                'on' => array('Register', 'ActivateRequest', 'PasswordRecoverRequest')
            ),
            array('first_name', 'required', 'on' => array('Create', 'Update')),
            array('first_name, last_name, patronymic, position','length', 'max' => 40),
            array('first_name, last_name, patronymic','ruLatAlpha'),
            array(
                'email',
                'required',
                'on' => array(
                    'Update',
                    'Register',
                    'Login',
                    'Activate',
                    'ActivateRequest',
                    'PasswordRecoverRequest',
                    'Update',
                    'Create'
                )
            ),
			array('city_id', 'numerical', 'integerOnly' => true),            
            array(
                'new_password',
                'required',
                'on' => 'ChangePassword'
            ),
            array(
                'position',
                'match',
                'pattern' => '/^[А-Яа-я ]+$/ui',
            ),
            array(
                'position',
                'length',
                'max' => 40
            ),
            array(
                'birthdate',
                'required',
                'on' => array('Register')
            ),
            array(
                'password_c, password',
                'required',
                'on' => array(
                    'Register',
                    'ChangePassword',
                    'PasswordRecover',
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
                    'Register',
                    'ChangePassword',
                    'PasswordRecover',
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
                'on' => 'Register'
            ),
            array(
                'password_c',
                'compare',
                'compareAttribute' => 'password',
                'on' => array(
                    'Register',
                    'PasswordRecover',
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
            array('email', 'length', 'max' => 200),
            array('company','length', 'max' => 250),
            array('phone, fax','length','max' => 50),
            array('phone, fax','phone'),
	    	array('club_status', 'in', 'range' => array_keys(self::$club_status_list)),	
            array('gender', 'in', 'range' => array_keys(self::$gender_list)),
            array('status', 'in', 'range' => array_keys(self::$status_list)),
            array('birthdate,activate_code', 'safe'),
            array('email', 'filter', 'filter' => 'trim'),
            array('id, email, birthdate, gender, status, date_create','safe', 'on'=>'search'),
            array('phone, company, fax', 'filter', 'filter'=>'strip_tags'),
        );
    }


    public function relations()
    {
        return array(
        	'city'       => array(self::BELONGS_TO, 'City', 'city_id'),
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

        $page_size = 10;
        if (isset(Yii::app()->session[get_class($this) . "PerPage"]))
        {
            $page_size = Yii::app()->session[get_class($this) . "PerPage"];
        }

        $this->addLangCondition($criteria);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $page_size,
            ),
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


    public function register($attrs)
    {
        $attrs["password"] = md5($attrs["password"]);

        $user = new User();
        $user->attributes = $attrs;
        $user->generateActivateCodeAndDate();

        if ($user->save(false))
        {
            $user->sendActivationMail();
            return true;
        }
    }


    public function generateActivateCodeAndDate()
    {
        $this->activate_date = Dater::mysqlDateTime();
        $this->activate_code = md5($this->id . $this->name . $this->email . time(true) . rand(5, 10));
    }


    public function sendActivationMail()
    {
        $settings = Settings::model()->getAll();

        $mail_body = str_replace(
            array("{NAME}", "{SITE_NAME}", "{LINK}"),
            array(
                $this->name,
                $settings["SITE_NAME"]["value"],
                "http://" . $_SERVER["HTTP_HOST"] . "/users/user/activate/code/" . $this->activate_code . "/email/" . $this->email
            ),
            $settings["REGISTER_MAIL_BODY"]["value"]
        );

        Mailer::sendMail($this->email, $settings["REGISTER_MAIL_SUBJECT"]["value"], $mail_body);
    }


    public function activate($attrs)
    {
        $user = $this->findByAttributes($attrs);

        if ($user)
        {
            if (strtotime($user->activate_date) + 24 * 3600 > time())
            {
                $user->activate_date = null;
                $user->activate_code = null;
                $user->status        = self::STATUS_ACTIVE;
                $user->save();

                return true;
            }
            else
            {
                $this->activate_error = self::ACTIVATE_ERROR_DATE;
            }
        }
        else
        {
            $this->activate_error = UserIdentity::ERROR_UNKNOWN;
        }
    }


    public function passwordRecoverRequest()
    {
        $settings = Settings::model()->getAll();

        $this->password_recover_code = md5($this->password . $this->email . $this->id . time());
        $this->password_recover_date = Dater::mysqlDateTime();

        $body = $settings["PASSWORD_RECOVER_REQUEST_MAIL_BODY"]["value"];
        $body = str_replace(
            array("{name}", "{SITE_NAME}", "{LINK}"),
            array(
                $this->name,
                $settings["SITE_NAME"]["value"],
                "http://" . $_SERVER["HTTP_HOST"] . "/users/user/passwordRecover/id/" . $this->id . "/code/" . $this->password_recover_code
            ),
            $body
        );

        Mailer::sendMail($this->email, $settings["PASSWORD_RECOVER_REQUEST_MAIL_SUBJECT"]["value"], $body);

        $this->save();
    }
    
    
    public function export() 
    {
    	$labels = $this->attributeLabels();
    		
    	$date = Yii::app()->dateFormatter->format('d MMMM yyyy', time());	
    		
    	$result = array(
    	    "title" => 'СПИСОК ЧЛЕНОВ КЛУБА "ЭЛЕКТРОПОЛИС" на ' . $date . 'г.',
    	    
    		"labels" => array(
                "№",
                "ФИО",
    			$labels["company"],
                $labels["position"],
    			$labels["city_id"]
    		),
    		"data" => array()
    	);
    	 	
        $users = User::model()->findAllByAttributes(array(
            'status'      => User::STATUS_ACTIVE,
            'club_status' => User::CLUB_STATUS_CLUBMAN
        ));
		
		foreach ($users as $user) 
		{
			$result["data"][] = array(
                $user->id,
    			$user->name,
				$user->company,
                $user->position,
				$user->city->name	
			);
		}
    	
    	return $result;
    }


	public function getRole()
	{
		$assigment = AuthAssignment::model()->findByAttributes(array(
			'userid' => $this->id
		));

		if (!$assigment)
		{
			$assigment = new AuthAssignment();
			$assigment->itemname = AuthItem::DEFAULT_ROLE;
			$assigment->userid   = $this->id;
			$assigment->save();
		}

		return $assigment->role;
	}


    public function isRootRole()
    {
        return $this->role->name == AuthItem::ROOT_ROLE;
    }
}



















