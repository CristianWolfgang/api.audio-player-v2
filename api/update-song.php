<?php
require "db.php";
class UpdateSong extends DB{
    public function updateSong(array $arr=array(
        "id"=>null,
        "name"=>null,
        "artist"=>null,
        "year"=>null,
        "audio"=>null,
        "audio_path"=>null,
        "image"=>null,
        "image_path"=>null
    )){
        $sql = "CALL UPDATE_MUSIC(:id,:name,:artist,:year,:audio,:image,:audio_path,:image_path)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":id"         , $arr["id"]);
        $query->bindParam(":name"       , $arr["name"]);
        $query->bindParam(":artist"     , $arr["artist"]);
        $query->bindParam(":year"       , $arr["year"]);
        $query->bindParam(":audio"      , $arr["audio"]);
        $query->bindParam(":image"      , $arr["image"]);
        $query->bindParam(":audio_path" , $arr["audio_path"]);
        $query->bindParam(":image_path" , $arr["image_path"]);
        $query->closeCursor();
        return $query->execute();
    }

}
?>