<?php 
require 'db.php';
class GetSongs extends DB{
	public function getSongs(){
		$songs = $this->conn->query("CALL GET_SONGS");
		return $songs;
	}

}

 ?>