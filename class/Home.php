<?php
class Home extends Core{
	public $data = array();

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

	private function login(){
		$this->data['error'] = array();
		if($this->formSubmit('login')){
			$email = $this->formValue('email');
			$password = $this->formValue('password');
			$query = ("SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'");
			$user = $this->conn->prepare($query);
			$user->execute();
			
			if($user->rowCount() > 0){
				$userData = $user->fetch(PDO::FETCH_ASSOC);
				$_SESSION['email'] = $userData['email'];
				
				 $this->redirect('/dashboard',true);

			}
			else {
				$this->data['error'][] = 'هناك خظاء في تسجيل الدخول ';
			}
				
		}
	}

	private function signup(){
		$this->data['error'] = array();
		if($this->formSubmit('signup')){
			$name = $this->formValue('name',true);
			$email = $this->formValue('email',true);
			$password = $this->formValue('password',true);
			$cpassword = $this->formValue('cpassword',true);
			if($password != $cpassword)  {
				$this->data['error'][] = 'الرقم السري غير متطابق';
				return ($this->data['error']);
			}	
			$query = "SELECT * FROM `users` WHERE `name` = '$name' AND `email`='$email' ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				$this->data['error'][] = 'هذا الايميل او اسم المستخدم  مستخدم بالفعل';
				return ($this->data['error']);
			

			}
			if(empty($this->data['error'])){
				$query = "INSERT INTO `users` SET `email`='$email',`password`='$password',`name`='$name'";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				
					$_SESSION['email'] = $email;
					$this->redirect('/dashboard',true);	
				
			}
		}
	}

	private function logout(){
		if($this->formValue('logout') == '1'){
			session_destroy();
			$this->redirect('/',true);
		}
	}

	private function forgetPassword(){
		if($this->formSubmit('forget')){
			$email = $this->formValue('email',true);
			$user = $this->query("SELECT * FROM `users` WHERE `email`='$email'");
			if($user->num_rows > 0){
				$user=$user->fetch_assoc();
				$to = $email;
				$subject = "Forgot Password";
				$message = "Current Password : ".$user['password']." \nLogin and change the password.";
				$retval = mail($to,$subject,$message);
				if($retval)
					$this->data['error'][]='Password sent to email.';
			}
		}
	}

}
?>