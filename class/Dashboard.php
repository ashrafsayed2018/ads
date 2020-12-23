<?php
class Dashboard extends Core{
	public $data = array();

	public $errors = [];

	function __construct(){
		parent::__construct();
		$this->auth();
		$this->index();
	}

	function __destruct(){
		parent::__destruct();
	}

	function index(){
		$this->getUser();
		$this->editProfile();
		$this->addAds();
		$this->deleteAd();
		$this->approveAd();
		$this->listAds();
	}

	public function getCount($type='1'){
		$user = $this->data['user'];
		$id = $user['id'];
		if($type=='1') {
			$query = ("SELECT * FROM `ads` WHERE `status`='1' ORDER BY `id` DESC");
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt->rowCount();
		}
		
		else {
			$query = ("SELECT * FROM `ads` WHERE `status`='0' ORDER BY `id` DESC");
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt->rowCount();
		}
	}

	private function deleteAd(){
		if($this->formValue('delete-ad')){
			$ad_id = $this->formValue('delete-ad');
			$user = $this->data['user'];
			$id = $user['id'];
			$query = "DELETE FROM `ads` WHERE `id`='$ad_id' AND `user_id`='$id'";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$this->redirect('/dashboard',true);
		}
	}

	private function approveAd(){
		if($this->formValue('ad-approve')){
			$ad_id = $this->formValue('ad-approve');
			$user = $this->data['user'];
			if($user['admin']== 1) {
				$query = "UPDATE `ads` SET `status`='1' WHERE `id`='$ad_id'";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();

				$this->redirect('/dashboard?dashboard=1&list=pending',true);
			}
		
		}
	}

	private function listAds(){
		$user = $this->data['user'];
		$id = $user['id'];
		if(empty($_GET) || isset($_GET['dashboard'])){
			if(isset($_GET['list']) && $_GET['list']=='approved') {
				$query = "SELECT * FROM `ads` WHERE `status`='1' ORDER BY `id` DESC";
				$list = $this->conn->prepare($query);
				$list->execute();
			}
				
			else if(isset($_GET['list']) && $_GET['list']=='pending') {
				$query = "SELECT * FROM `ads` WHERE `status`='0' ORDER BY `id` DESC";
				$list = $this->conn->prepare($query);
				$list->execute();
		}
			else {
				$query = "SELECT * FROM `ads` WHERE `user_id`='$id' ORDER BY `id` DESC";
				$list = $this->conn->prepare($query);
				$list->execute();
			}
				
			$this->data['list'] = ($list->rowCount() > 0) ? $list : '';
		}
	}

	private function addAds(){
		$user = $this->data['user'];
		$id = $user['id'];
		if($this->formValue('ad-edit') == '0' && $this->formSubmit('post')){
			//ADD  NEW AD
			$title = $_POST['title'];
			$cat_id = $_POST['category'];
			$description = $_POST['description'];
			$mobile = $_POST['mobile'];
			$location = $_POST['location'];
			

			if(empty($title)) {
				$errors[] = "عنوان الاعلان يجب ان لا يكون فارغ   ";
				
			}

			if(!empty($title) && mb_strlen($title) > 40 ) {
				$errors[] = "عنوان الاعلان يجب ان لا يزيد عن 40 حرف";
			}
			if(!empty($title) && mb_strlen($title) < 10 ) {
				$errors[] = "عنوان الاعلان يجب ان لا يقل عن 10 احرف";
			}

			if(empty($cat_id)) {
				$errors[] = "فئة الاعلان يجب ان لا يكون فارغ ";
				
			}


			if(empty($description)) {
				$errors[] = "وصف الاعلان يجب ان لا يكون فارغ";
				
			}

			if(!empty($description) && mb_strlen($description) > 400 ) {
				$errors[] = "وصف الاعلان يجب ان لا يزيد عن 400 حرف";
			}
			if(!empty($description) && mb_strlen($description) < 50 ) {
				$errors[] = "وصف الاعلان يجب ان لا يقل عن 50 احرف";
			}

			if(empty($mobile)) {
				$errors[] = " رقم الجوال يجب ان لا يكون فارغ";
				
			}

			if(empty($location)) {
				$errors[] = "  منطقة الاعلان يجب ان لا يكون فارغ";
				
			}


			if(empty($cat_id)) {
				$errors[] = "يجب اختيار فئه";
				
			}
			$features = (isset($_POST['features'])) ? json_encode($_POST['features']) : json_encode(array());
			$user_id = $user['id'];
			$images = array();
			$dt = date('Y-m-d');

			if(!empty($_FILES["images"]["name"][0])){
				foreach ($_FILES["images"]["name"] as $index => $val) {
					//echo $index;
					$imageFileType = strtolower(pathinfo($_FILES["images"]["name"][$index],PATHINFO_EXTENSION));
					$file_name = $user['id'].'_ad'.$index.'_'.strtotime("now").'.'.$imageFileType;
					$temp_path = '/images/'.$file_name;
					$target_file = $_SERVER['DOCUMENT_ROOT'].$temp_path;
					$check = getimagesize($_FILES["images"]["tmp_name"][$index]);
				    if($check !== false) {
				    	if(move_uploaded_file($_FILES["images"]["tmp_name"][$index], $target_file)){
					        $images[] = $temp_path;
					    }
				    }
				}
			}

		
			if(count($images) == 0) {
				$errors[] = "يجب تحميل صور للاعلان";
			}

			if(count($images) > 4) {
				$errors[] = "يجب تحميل 4 صور على الاكثر للاعلان";
			}
			if(count($images) != 0 && count($images) <= 4) {
				$_SESSION['images'] = $images;
			} else {
				$_SESSION['images'] = [];
			}
		
			$image = json_encode($images);

			if(empty($errors)) {

				
				$query = "INSERT INTO `ads` SET `title`='$title', `cat_id`='$cat_id', `user_id`='$user_id', `description`='$description', `mobile`='$mobile', `location`='$location',`images`='$image', `dt`='$dt'";
				$stmt = $this->conn->prepare($query);
				if($stmt->execute()) {

					unset($_SESSION['images']);
					
					$_SESSION['message'] = '<p class="alert alert-success">تم اضافة الاعلان بنجاح وبانتظار المراجعه</p>';
					
					header("Location:dashboard");
				} else {

					die("SQL ERROR : ".$this->sqlError());
				}
			} else {

				foreach($errors as $error) {
					echo $this->validation_errors($error);
				}
			}
	
		}
		else if(isset($_GET['ad-edit']) && $this->formValue('ad-edit') !='0'){
			//EDIT AD
			$this->getLatestData($id);

			if($this->formSubmit('post')){
				$title = $_POST['title'];
				$cat_id = $_POST['category'];
				$description = $_POST['description'];
				$mobile = $_POST['mobile'];
				$location = $_POST['location'];
				$features = (isset($_POST['features'])) ?json_encode($_POST['features']) :json_encode(array());
				$user_id = $user['id'];
				$images = array();
				$dt = date('Y-m-d');
				$post_id =$this->formValue('ad-edit');

				if(!empty($_FILES["images"]["name"][0])){
					foreach ($_FILES["images"]["name"] as $index => $val) {
						//echo $index;
						$imageFileType = strtolower(pathinfo($_FILES["images"]["name"][$index],PATHINFO_EXTENSION));
						$file_name = $user['id'].'_ad'.$index.'_'.strtotime("now").'.'.$imageFileType;
						$temp_path = '/images/'.$file_name;
						$target_file = $_SERVER['DOCUMENT_ROOT'].$temp_path;
						$check = getimagesize($_FILES["images"]["tmp_name"][$index]);
					    if($check !== false) {
					    	if(move_uploaded_file($_FILES["images"]["tmp_name"][$index], $target_file)){
						        $images[] = $temp_path;
						    }
					    }
					}
					$image = json_encode($images);
				}
				else{
					$image = $this->data['ad']['images'];
				}
				$query = "UPDATE `ads` SET `title`='$title', `cat_id`='$cat_id', `user_id`='$user_id', `description`='$description', `mobile`='$mobile',  `location`='$location', `specification`='$specification', `feature`='$features', `images`='$image', `dt`='$dt' WHERE `id`='$post_id'";
				$stmt = $this->conn->prepare($query);
				if($stmt->execute())
					$this->data['error'][] = 'تم تعديل الاعلان بنجاح';
				else
					die("SQL ERROR : ".$this->sqlError());

				$this->getLatestData($id);
			}
		}

	}

	private function getLatestData($id){
		$ad_id = $this->formValue('ad-edit');
		$query = "SELECT * FROM `ads` WHERE `id`='$ad_id' AND `user_id`='$id'";
		$ad_data = $this->conn->prepare($query);
		$ad_data->execute();
				if($ad_data->rowCount() > 0)
					$this->data['ad'] = $ad_data->fetch(PDO::FETCH_ASSOC);
				else
					$this->redirect('/dashboard',true);
	}

	private function getUser(){
		$email = $_SESSION['email'];
		$query = "SELECT * FROM `users` WHERE `email`='$email' LIMIT 1";
		
		$userData = $this->conn->prepare($query);
		$userData->execute();
		$results = $userData->fetch(PDO::FETCH_ASSOC);
		if(empty($results)){
			session_destroy();
			$this->redirect('/login',true);
		}
		$this->data['user'] = $results;
	}

	private function editProfile(){
		$user = $this->data['user'];
		$dp   = $user['dp']; // user profile iamge
	
	
	
		if($this->formValue('edit-profile') && $this->formSubmit('post')){
			$id = $user['id'];
			
			$email = $_POST['email'];
			$username = $_POST['username'];
			$opassword = $_POST['opassword'];
			$npassword = $_POST['npassword'];
			$cpassword = $_POST['cpassword'];
			$image = $_FILES['picture'];

			$opassword = md5($opassword);

			$new_hashed_pass = md5($npassword);

		
			if(!empty($npassword) && $opassword == $user['password'] && $npassword == $cpassword){

				$query = "UPDATE `users` SET `password`='$new_hashed_pass' WHERE `email`='$email'";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
				
				$this->set_messages("<div class='alert alert-success text-center'> تم  تغيير الرقم السري  بنجاح </div>");
			} elseif(!empty($npassword) && $opassword != $user['password'] || $npassword != $cpassword) {
				$this->set_messages("<div class='alert alert-danger text-center'> هناك خظاء في تغيير الرقم السري      </div>");
			}

			if($new_hashed_pass == $user['password']) {
				$this->set_messages("<div class='alert alert-danger text-center'> الرقم السري الجديد هو نفس الرقم السري القديم الرجاء استعمل رقم سري جديد     </div>");
			}

			if(!empty($username) && $username != $user['username']) {
				$query = "UPDATE `users` SET `username`='$username' WHERE `id`='$id'";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();

				$this->set_messages("<div class='alert alert-success text-center'> تم  تغيير الاسم  بنجاح </div>");

			} elseif(mb_strlen($username) > 15 || mb_strlen($username) < 2) {
				$this->set_messages("<div class='alert alert-danger text-center'> هناك خظاء في تغيير  اسم المستخدم      </div>");
			}
			if(!empty($email) && $email != $user['email']){

				$validation_code = $this->token_generator();
				$query = "UPDATE `users` SET `email`='$email',`username`='$username' ,validation_code ='$validation_code', active = 0; WHERE `id`='$id'";
				$stmt = $this->conn->prepare($query);
				if($stmt->execute()){
					
		
					$_SESSION['email'] = $email;
					
				$subject = "rawjly@rawjly.com";
				$msg     = "<div style='background-color: #fff;height:auto;width:100%;max-width:500px;margin: 0 auto; border: 1px solid #50597b;height:500px'>
				<h3 style='text-align:center; color: #50597b '>لقد قمت بتغيير البريد الالكتروني لحسابك  موقع روجلى</h3>
				<p style='text-align:center; color: #50597b'>				     <a href='ads.local/activate?email=$email&code=$validation_code'>تفعيل حسابك على موقع روجلى </a>الرجاء الضغط على اللينك لتفعيل حسابك على  الموقع
			  </p>
				
			  </div>";
				$headers = "from : rawjly@rawjly.com";
				 $this->send_email($email,$subject,$msg,$headers);

				 $this->set_messages("<div class='alert alert-success text-center'> تم  ارسال رابط تفعيل الى البريد الالكتروني  الرجاء الضغط على الرابط لتفعيل الحساب </div>");
		
				}
			
			}
			
			if(!empty($_FILES)){
				$imageFileType = strtolower(pathinfo($_FILES["picture"]["name"],PATHINFO_EXTENSION));
				$file_name = $id.'_dp'.strtotime("now").'.'.$imageFileType;
				$temp_path = '/profile_image/'.$file_name;
				$target_file = $_SERVER['DOCUMENT_ROOT'].$temp_path;
				 $check = getimagesize($_FILES["picture"]["tmp_name"]);
		
			     
			    if($check) {
					// delete the old image from the images folder before moving the new one 
               

				
			    	if(move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)){
						$query = "UPDATE `users` SET `dp`='$temp_path' WHERE `id`='$id'";
						$stmt = $this->conn->prepare($query);
						
						if($stmt->execute()) {
							if(unlink($target_file.$dp)) {
								echo "you unlinked";
							   } else {
								echo "not  unlinked";
							   }

							   $this->set_messages("<div class='alert alert-success text-center'> تم تحميل الصوره الجديده بنجاح </div>");

						
						}
				        $this->redirect('/dashboard/?edit-profile=1',true);
				    }
			    }
			}
			
		
				$this->redirect('/dashboard/?edit-profile=1',true);
		}
	}

}
?>