<?php
class View extends Core{
	public $data = array();
	private $param = '';

	function __construct($param = null){
		parent::__construct();
		if(!empty($param)){
			$this->param = $param;
		}
		$this->index();
	}

	function __destruct(){
		parent::__destruct();
	}

	function index(){
		if(!empty($this->param))
			$this->viewAd(explode('/',$this->param));
		else
			$this->redirect('/error404',true);
			
	}

	public function getCat($id){
		$query = "SELECT `name` FROM `category` WHERE `id`='$id'";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		return $results['name'];
	}

	public function incView($id){
		if(!isset($_SESSION['view'.$id])){
			$query = "SELECT `id` FROM `ads` WHERE `status`='1' AND `id`='$id'";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			if($stmt->rowCount() > 0){
				$_SESSION['view'.$id] = 'v'.$id;
				$query = "UPDATE `ads` SET `views`=`views`+1 WHERE `id`='$id'";
				$stmt = $this->conn->prepare($query);
				$stmt->execute();
			}
		}
	}

	private function viewAd($params = array()){
			$id = $params[0];
			$query = "SELECT * FROM `ads` WHERE `id`='$id'";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			if($stmt->rowCount() >0)
				$this->data['ad'] = $stmt->fetch(PDO::FETCH_ASSOC);
			else
				$this->redirect('/',true);
	}

}
?>