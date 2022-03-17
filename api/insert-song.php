<?php

require 'db.php';
class InsertSong extends DB{
    //$name,$artist,$year,$audio,$image,$audio_path,$image_path
	public function insertSong(array $song =array(
        "name"=>null,
        "artist"=>null,
        "year"=>null,
        "audio"=>null,
        "image"=>null,
        "audio_path"=>null,
        "image_path"=>null
    )){
        $sql = "CALL INSERT_MUSIC(:name,:artist,:year,:audio,:image,:audio_path,:image_path)";
		$query = $this->conn->prepare($sql);
        $query->bindParam(":name"       , $song["name"]);
        $query->bindParam(":artist"     , $song["artist"]);
        $query->bindParam(":year"       , $song["year"]);
        $query->bindParam(":audio"      , $song["audio"]);
        $query->bindParam(":image"      , $song["image"]);
        $query->bindParam(":audio_path" , $song["audio_path"]);
        $query->bindParam(":image_path" , $song["image_path"]);
        $query->execute();
		return $query;
	}

}
?>