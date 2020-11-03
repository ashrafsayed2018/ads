<?php
class Dashboard extends Core{
	public $data = array();

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

	// public function loadSpecification(){
	// 	$spec = array(
	// 		'Electronics' => array('Condition','Type'),
	// 		'Fashion' => array('Name','Type','Color','Condition'),
	// 		'Furniture' => array('Condition','Type'),
	// 		'Mobiles' => array('Condition','Model','Brand','Memory','Camera'),
	// 		'Real Estate' => array('Purpose','Condition','Size','Type'),
	// 		'Vehicles' => array('Color','Condition','Type','Model')
	// 	);

	// 	return $spec;
	// }

	// public function loadFeature(){
	// 	$feature = array(
	// 		'Electronics' => array('charger','waterproof'),
	// 		'Fashion' => array('male','female'),
	// 		'Furniture' => array('wooden','steel','folding'),
	// 		'Mobiles' => array('Touchscreen','3G /4G LTE','Memory card','Built-in camera','Auto focus','Built-in flash','Video recorder','Bluetooth','Wi-Fi','Dual SIM','USB','Media sharing'),
	// 		'Real Estate' => array('Air Conditioning','Swimming Pool','Dryer','Washer','Gym','WiFi'),
	// 		'Vehicles' => array('Air Bags','Power Window','Power Stering')
	// 	);

	// 	return $feature;
	// }

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
			$price = $_POST['price'];
			$description = $_POST['description'];
			$mobile = $_POST['mobile'];
			$address = $_POST['address'];
			$location = $_POST['location'];
			$specification = json_encode($_POST['spec']);
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

			$image = json_encode($images);
			$query = "INSERT INTO `ads` SET `title`='$title', `cat_id`='$cat_id', `user_id`='$user_id', `price`='$price', `description`='$description', `mobile`='$mobile', `address`='$address', `location`='$location', `specification`='$specification', `feature`='$features', `images`='$image', `dt`='$dt'";
			$stmt = $this->conn->prepare($query);
			if($stmt->execute())
				$this->data['error'][] = 'تم اضافة الاعلان بنجاح وبانتظار المراجعه';
			else
				die("SQL ERROR : ".$this->sqlError());
		}
		else if(isset($_GET['ad-edit']) && $this->formValue('ad-edit') !='0'){
			//EDIT AD
			$this->getLatestData($id);

			if($this->formSubmit('post')){
				$title = $_POST['title'];
				$cat_id = $_POST['category'];
				$price = $_POST['price'];
				$description = $_POST['description'];
				$mobile = $_POST['mobile'];
				$address = $_POST['address'];
				$location = $_POST['location'];
				$specification = json_encode($_POST['spec']);
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
				$query = "UPDATE `ads` SET `title`='$title', `cat_id`='$cat_id', `user_id`='$user_id', `price`='$price', `description`='$description', `mobile`='$mobile', `address`='$address', `location`='$location', `specification`='$specification', `feature`='$features', `images`='$image', `dt`='$dt' WHERE `id`='$post_id'";
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
		if($this->formValue('edit-profile') && $this->formSubmit('post')){
			$id = $user['id'];
			$email = $_POST['email'];
			$name = $_POST['name'];
			$opassword = $_POST['opassword'];
			$npassword = $_POST['npassword'];
			$cpassword = $_POST['cpassword'];
			if(!empty($npassword) && $opassword==$user['password'] && $npassword==$cpassword){
				$this->query("UPDATE `users` SET `password`='$npassword' WHERE `email`='$email'");
			}
			if($email != $user['email'] || $name != $user['name']){
				$query = "UPDATE `users` SET `email`='$email',`name`='$name' WHERE `id`='$id'";
				$stmt = $this->conn->prepare($query);
				if($stmt->execute())
				$_SESSION['email'] = $email;
			}

			if(!empty($_FILES)){
				$imageFileType = strtolower(pathinfo($_FILES["picture"]["name"],PATHINFO_EXTENSION));
				$file_name = $id.'_dp'.strtotime("now").'.'.$imageFileType;
				$temp_path = '/images/'.$file_name;
				$target_file = $_SERVER['DOCUMENT_ROOT'].$temp_path;
				$check = getimagesize($_FILES["picture"]["tmp_name"]);
			    if($check !== false) {
			    	if(move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)){
						$query = "UPDATE `users` SET `dp`='$temp_path' WHERE `id`='$id'";
						$stmt = $this->conn->prepare($query);
						if($stmt->execute())
				        $this->redirect('/dashboard/?edit-profile=1',true);
				    }
			    }
			}
				$this->redirect('/dashboard/?edit-profile=1',true);
		}
	}

}
?>