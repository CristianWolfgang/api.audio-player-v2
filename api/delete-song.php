<?php
require "db.php";
class DeleteSong extends DB{
    public function deleteSong($id){
            $sql = "CALL DELETE_MUSIC(:id)";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":id",$id);
            $query->closeCursor();
            
            return $query->execute(); 
         
        
    }

    public function deleteArtist($artist){
        
        $sql = "CALL DELETE_ARTIST(:artist)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":artist",$artist);
        $query->closeCursor();
        $query->execute();
        return $query;
    }
    public function checkIfExistsSounds($artist){
        
        
        $sql = "CALL CHECK_EXISTS_SOUNDS(:artist)";
        $query = $this->conn->prepare($sql);
        $query->bindParam(":artist",$artist);
        $query->closeCursor();
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        return is_bool($row)?false:true;
        
    }
}
?>
