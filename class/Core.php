<?php
class Core{
	public $conn;
	public $sitename;
	function __construct(){
		require_once('init.php');
		try {
			$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
			

			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  } catch(PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		  }
		$this->conn = $conn;
		$this->sitename = $sitename;
	}

	function __destruct(){
		$this->conn = null;
	}

	public function query($query){
		return $this->conn->query($query);
	}
	public function sqlError(){
		return $this->conn->error;
	}
 // method to load the cities in the select box 
	public function loadCities(){
		$json = json_decode(file_get_contents('assets/cities.json'));
		foreach ($json as $key => $value) {
			echo '<optgroup label="'.$key.'" value="'.$key.'">';
				foreach ($value as $city) {
					if(isset($this->data['ad']['location']) && $this->data['ad']['location']== $city)
						echo '<option value="'.$city.'" selected>'.$city.'</option>';
					else
						echo '<option value="'.$city.'">'.$city.'</option>';
				}
			echo '</optgroup>';
		}
	}
	// method th load the latest ads 
	public function latestAd(){
		$query = "SELECT * FROM `ads` WHERE `status`='1' ORDER BY `id` DESC LIMIT 20";

		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return ($stmt->rowCount() > 0)? $stmt : '';
	}
   // METHOD TO GET ALL CATEGORIES
	public function getCategories(){
		$query = "SELECT * FROM `category`";
		$cat = $this->conn->prepare($query);
		$cat->execute();
		return $cat;
	}
   // METHOD TO COUNT ALL ADS IN A SPECIFIC CATEGORY
	public function getAdCount($id){

		$stmt = $this->conn->prepare("SELECT `id` FROM `ads` WHERE `cat_id`='$id' AND `status`='1'");
		$stmt->execute();
		return $stmt->rowCount();

	}
  // MEHTOD TO  RETURN THE CATEGORY NAME DEPENDING ON IT'S ID
	public function cat_id2name($id){
		$query = "SELECT `name` FROM `category` WHERE `id`='$id'";

		$cat = $this->conn->prepare($query);
		$cat->execute();
		if($cat->rowCount() > 0){
			$cat = $cat->fetch(PDO::FETCH_ASSOC);
			return $cat['name'];
		}
	}
  // METHOD OT REURN THE USER NAME DEPENDING ON THE USER ID
	public function user_id2name($id){

		$query= "SELECT `name` FROM `users` WHERE `id`='$id'";
		
		$cat = $this->conn->prepare($query);
		$cat->execute();
		if($cat->rowCount() > 0){
			$cat = $cat->fetch(PDO::FETCH_ASSOC);
			return $cat['name'];
		}
	}
      // MEHTOD TO RERUN THE USER PROFILE IMAGE 
	public function user2dp($id){

		$query = "SELECT `dp` FROM `users` WHERE `id`='$id'";
		$user = $this->conn->prepare($query);
		$user->execute();
		if($user->rowCount() > 0){
			$user = $user->fetch(PDO::FETCH_ASSOC);
			return $user['dp'];
		}
	}
  // METHOD TO GIVE THE USER AUTHANITCATION DEPENDING ON THER SESSION EMAIL
	public function auth(){
		if(!isset($_SESSION['email']))
			$this->redirect('/',true);
	}

	public static function formSubmit($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
                break;
            case 'get':
                return (!empty($_GET)) ? true : false;
                break;
            default:
            	return (isset($_POST[$type])) ? true : false;
                break;
        }
    }

    public function formValue($item) {
        if(isset($_POST[$item])) {
            return  $_POST[$item];
        } else if(isset($_GET[$item])) {
            return  $_GET[$item];
        }
		return '';
		
    }

    public static function redirect($url,$php=false){
    	if($php){
    		header("location: $url");
    		exit();
    	}
    	else{
		?>
		<script type="text/javascript">
			window.location = "<?php echo $url;?>";
		</script>
		<?php
		}
	}
}
?>