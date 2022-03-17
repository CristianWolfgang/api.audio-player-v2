<?php 

class DB{
	public $conn;
	function __construct(){
		try {
			$config=require 'config.php';
  			$this->conn = new PDO("mysql:host=" . $config['servername'] . ";dbname=" . $config['dbname'] . "; charset=".$config["charset"] , $config['username'], $config['password']);
			// set the PDO error mode to exception
	  		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  		//echo "Connected successfully";
		
		}catch(PDOException $e) {
	  		echo "Connection failed: " . $e->getMessage();
		}
	
	}

	public function uploadImg(Array $img){
		
		$imgSize=$img["size"]/1e+6;
		$imgFormat=$img["type"];
		$allowedImgFormat=array("image/jpg", "image/jpeg", "image/png");

		if($imgSize>10){
			return "Error uploading image: file too bigger";
		}
		if(!(in_array($imgFormat, $allowedImgFormat))){
			return "Error uploading image: not supported format";
		}
		$uploadsDirImg="./images/".$img["name"];
		$uploadFile=move_uploaded_file($img["tmp_name"], $uploadsDirImg);
		if($uploadFile){
			return array(
				"img"=>"http://localhost/api.audio-player-v2/images/".$img["name"],
				"img_path"=>$_SERVER["DOCUMENT_ROOT"]."/api.audio-player-v2/images/".$img["name"]
			);
		}
	}

	public function uploadSound(Array $sound){
		$soundSize=$sound["size"]/1e+6;
		$soundFormat=$sound["type"];
		$allowedSoundFormat=array("audio/mpeg", "audio/webm", "audio/ogg", "audio/wav");
		if($soundSize>10){
			return "Error uploading sound: file too bigger";
		}
		if(!(in_array($soundFormat, $allowedSoundFormat))){
			return "Error uploading sound: not supported format";
		}
		$uploadsDirSound="./songs/".$sound["name"];
		$uploadFile=move_uploaded_file($sound["tmp_name"], $uploadsDirSound);
		if($uploadFile){
			return array(
				"audio"=>"http://localhost/api.audio-player-v2/songs/".$sound["name"],
				"audio_path"=>$_SERVER["DOCUMENT_ROOT"]."/api.audio-player-v2/songs/".$sound["name"]
			);
		}
		
	}

	
    public function getImage($artist){
		$sql = "CALL GET_IMAGE( :artist )";
		$query=$this->conn->prepare($sql);
		$query->bindParam(":artist",$artist);
        $query->closeCursor();
	
		$query->execute();

		return $query;

	}
	public function getAudio($id){
		$sql = "CALL GET_AUDIO( :id )";
		$query=$this->conn->prepare($sql);
		$query->bindParam(":id",$id);	
		$query->closeCursor();
        
		$query->execute();
		return $query;

	}


	public function printJSON($arr){
		echo json_encode($arr);
	}
	public function error($message,$error=null){

		$this->printJSON(array(
			"statusText"=>$message,
			"errorData"=>$error
		));
	}


}

 ?>