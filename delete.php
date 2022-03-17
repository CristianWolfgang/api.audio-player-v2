<?php
require "./api/delete-song.php";
$deleteSong = new DeleteSong;
$method = $_SERVER["REQUEST_METHOD"];
if($method==="DELETE"){
    try{    
        
        $body = json_decode(file_get_contents("php://input"));
        if(is_numeric($body->id)){
            $id = $body->id;
            $artist= $body->artist;
        
            $res = $deleteSong->getAudio($id);
            $songPath=$res->fetch(PDO::FETCH_ASSOC);
            
            unlink($songPath["audio_path"]);


            $delete = $deleteSong->deleteSong($id);
        
            if($delete){
            
                if(!($deleteSong->checkIfExistsSounds($artist))){
                    
                    $res = $deleteSong->getImage($artist);
                    
                    $imagePath=$res->fetch(PDO::FETCH_ASSOC);

                    if($imagePath["image_path"]){

                        unlink($imagePath["image_path"]);
                    
                    }
            
                    if(!($deleteSong->deleteArtist($artist))){
                        throw new Exception("Failed artist deleting");
                    }

                }
            
                $deleteSong->printJSON(array(
                    "statusText"=>"Song deleted successfuly"
                ));
    
            }else{
                throw new Exception("Error: query has failed");
            }

        }else{
            throw new Exception("Error: value is not a number");
        }


 
    }catch(Exception $e){
        $deleteSong->error($e->getMessage(),array(
            "errorCode"=>$e->getCode(),
            "errorFile"=>$e->getFile(),
            "errorLine"=>$e->getLine()
        ));
    }   
}else{
    throw new Exception("Error 405: not allowed method");
}

?>