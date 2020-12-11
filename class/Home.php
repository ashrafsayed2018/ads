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

			$name = $this->formValue('name',true);
			$email = $this->formValue('email',true);
			$password = $this->formValue('password',true);
			$cpassword = $this->formValue('cpassword',true);
			// encrypt password 
 
			if(mb_strlen($password) < 8)  {
				$this->errors[] = 'الرقم السري يجب ان لا يقل عن 8 احرف';
			
			}
		
			if($password != $cpassword)  {
				$this->errors[] = 'الرقم السري غير متطابق';
			}	

			// $password = password_hash($password,PASSWORD_BCRYPT,array('const' =>12));

			$password = md5($password);

			$query = "SELECT * FROM `users` WHERE `name` = '$name' AND `email`='$email'";
			$stmt = $this->query($query);
			$stmt->execute();
			

			if($stmt->rowCount() > 0) {
				$this->errors[] = 'هذا الايميل او اسم المستخدم  مستخدم بالفعل';
			

			}
			if(empty($this->errors)){

			   $validation_code = $this->token_generator();

			   
			   $query = "INSERT INTO users (email,password,name,validation_code,active) VALUES('$email','$password','$name' ,'$validation_code',0) ";
			   $stmt = $this->query($query);
			   $stmt->execute();
				
					
			   $_SESSION['email'] = $email;

				$subject = "ashraf@gmail.com";
				$msg     = "
				الرجاء الضغط على اللينك لتفعيل حسابك على الموقع
				<a href='ads.local/activate?email=$email&code=$validation_code'>تفعيل حسابك على موقع روجلى </a>";
				$headers = "from : ashraf@e3lanat.com";
				 $this->send_email($email,$subject,$msg,$headers);
			

				
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
			
			 $this->redirect('/dashboard',true);
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
	
				  $subject = "ashraf@gmail.com";
				  $msg     = "Here is your passowrd reset code
				  <strong style='color:green'>$validation_code</strong> 
				   Click her to reset  your password 
				   <a href='ads.local/code?email=$email&code=$validation_code'> click to rest your password </a>";
	
				  $headers = "from : ashraf@e3lanat.com";
	
				 $this->send_email($email,$subject,$msg,$headers);
	
				  // set message 
	
				  $this->set_messages("<p class='alert alert-success text-center'> ارسلنا رساله بالكود لبريدك الالكتروني </p>");
	
				//    redirect('index.php');
	
	
			   } else {
				$this->set_messages("<p class='alert alert-danger text-center'> عذرا البريد الالكتروني  <strong>$email</strong> غير مسجل سابقا</p>");
			   } 
	
		  
			} else {
				// header('Location:index.php');
			}
		}
	
		// if the user click on cancel button 
	
		if(isset($_POST['cancel_submit'])) {
			// header('Location:login.php');
		}
	}

}
?>