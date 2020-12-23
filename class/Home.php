<?php


class Home extends Core{
	public $errors = [];

	function __construct(){
		parent::__construct();
		$this->index();
	}

	function __destruct(){
		parent::__destruct();
	}

	function index(){
		$this->signup();
		$this->login();
		$this->logout();
		$this->forgetPassword();
	}



	private function signup(){
		

			if($this->formSubmit('signup')) {

			$username = $this->formValue('username',true);
			$email = $this->formValue('email',true);
			$password = $this->formValue('password',true);
			$cpassword = $this->formValue('cpassword',true);

			if(empty($username)) {
				$this->errors[] = "<div class='alert alert-danger alert-dismissible'>اسم المستخدم فارغ</div>";
			}

			if(mb_strlen($username) > 15 || mb_strlen($username) < 2) {
				$this->errors[] = "<div class='alert alert-danger alert-dismissible'>اسم المستخدم يحب ان لايقل عن حرفين ولا يزيد عن 15 حرف</div>";
			}

			// encrypt password 
 
			if(mb_strlen($password) < 8)  {
				$this->errors[] = 'الرقم السري يجب ان لا يقل عن 8 احرف';
			
			}
		
			if($password != $cpassword)  {
				$this->errors[] = 'الرقم السري غير متطابق';
			}	

			// $password = password_hash($password,PASSWORD_BCRYPT,array('const' =>12));

			$password = md5($password);

			$query = "SELECT * FROM `users` WHERE  `email`='$email'";
			$stmt = $this->query($query);
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$db_username = $result['username'];
			
			$active  = $result['active'];


		

			if($stmt->rowCount() > 0 || $username == $db_username) {
				$this->errors[] = 'هذا الايميل او اسم المستخدم  مستخدم بالفعل';

			}


			if(empty($this->errors)){


			   $validation_code = $this->token_generator();

			   
			   $query = "INSERT INTO users (email, username, password, validation_code,active) VALUES('$email','$username','$password','$validation_code',0)";
			   $stmt = $this->query($query);
		
			   $stmt->execute();
					
			   $_SESSION['email'] = $email;

				$subject = "rawjly@rawjly.com";
				$msg     = "<div style='background-color: #fff;height:auto;width:100%;max-width:500px;margin: 0 auto; border: 1px solid #50597b'>
				<h3 style='text-align:center; color: #50597b '>لقد قمت بتسحيل دخول حساب جديد على موقع روجلى</h3>
				<p style='text-align:center; color: #50597b'>				     <a href='ads.local/activate?email=$email&code=$validation_code'>تفعيل حسابك على موقع روجلى </a>الرجاء الضغط على اللينك لتفعيل حسابك على  الموقع
			  </p>
				
			  </div>";
				$headers = "from : rawjly@rawjly.com";
				 $this->send_email($email,$subject,$msg,$headers);

				   $this->set_messages("<div class='alert alert-success text-center'>تم ارسال رسالة تفعيل حسابك لبريدك الالكتروني </div>");

			 } else {
				foreach($this->errors as $error) {
                           
					echo $this->validation_errors($error);

					}
				
			 }
		}
	}

private function login(){
	// $this->data['error'] = array();

	$this->errors = [];
	if($this->formSubmit('login')){
		$email = $this->formValue('email');
		$password = $this->formValue('password');
		$hash_password = md5($password);
		$query = ("SELECT * FROM `users` WHERE `email`='$email' AND `active`= 1 AND password ='$hash_password'");
		$user = $this->query($query);
		$user->execute();


		
		if($user->rowCount() > 0){
			
			$userData = $user->fetch(PDO::FETCH_ASSOC);

			$db_password = $userData['password'];

			$password = md5($password);

			if($password == $db_password) {
				$_SESSION['email'] = $userData['email'];
			
			 $this->redirect('/dashboard/?ad-edit=0',true);
			} else {
				$this->errors[] = 'هناك خظاء في تسجيل الدخول ';

			}
			

		} else {

			$this->errors[] = 'هناك خظاء في تسجيل الدخول ';
			
				foreach($this->errors as $error) {
					echo $this->validation_errors($error);
				}
			
			
		}
			
	}
}

	private function logout(){
		if($this->formValue('logout') == '1'){
			session_destroy();
			$this->redirect('/',true);
		}
	}


	 private function forgetPassword() {

		if($_SERVER['REQUEST_METHOD'] == "POST") {
			
	
			if(isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
			   // check if email exists 
	
			   $email = $_POST['email'];
			 
			  
	
			   if($this->email_exist($email)) {
				  // send email with the varification code 
	
				  $validation_code =  md5(uniqid(mt_rand(),true));
	
				  setcookie('temp_access_code', $validation_code, time() + 900 , '/');
	
				  // updating the validatin code inside the users table where email = email
	
				  $sql = "UPDATE users set validation_code = '$validation_code' where email = '$email'";
				  $result = $this->query($sql);
				  $result->execute();
				  if(!$result) {
					  echo "no updates";
				  }
	
				  $subject = "rawjly@rawjly.com";
				  $msg     = "<div style='background-color: #fff;height:auto;width:100%;max-width:500px;margin: 0 auto; border: 1px solid #50597b'>
				  <h3 style='text-align:center; color: #50597b '> لقد قمت بطلب تغيير الرقم السري الخاص بحسابك على موقع روجلى</h3>
				  <p style='text-align:center; color: #50597b'>				     <a href='ads.local/code?email=$email&code=$validation_code'>تغيير الرقم السري  لحسابك    </a>الرجاء الضغط على اللينك لتغيير الرقم السري  لحسابك على  الموقع
				</p>
				  
				</div>";
	
				  $headers = "from : rawjly@rawjly.com";
	
				 $this->send_email($email,$subject,$msg,$headers);
	
				  // set message 
	
				  $this->set_messages("<p class='alert alert-success text-center'> ارسلنا رساله بالكود لبريدك الالكتروني </p>");
	
				//    redirect('index.php');
	
	
			   } else {
				$this->set_messages("<p class='alert alert-danger text-center'> عذرا البريد الالكتروني  <strong>$email</strong> غير مسجل سابقا</p>");
			   } 
	
		  
			} else {
				//$this->redirect('index');
			}
		}
	
		// if the user click on cancel button 
	
		if(isset($_POST['cancel_submit'])) {
			$this->redirect('login');
		}
	}

}
?>