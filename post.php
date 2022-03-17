<?php
require "api/insert-song.php";
$songs = new InsertSong;
$method = $_SERVER["REQUEST_METHOD"];
if($method==="POST"){
    try{
        $name   = !(empty($_POST['sound-name']))          ? ucfirst($_POST['sound-name'])    : null;
        $artist = !(empty($_POST['sound-artist']))        ? ucwords($_POST['sound-artist'])  : null;
        $year   = !(empty($_POST['sound-year']))          ? $_POST['sound-year']             : null;
        $img    = ($_FILES["artist-image"]["error"]===0) ? $_FILES["artist-image"]           : null;
        $sound  = ($_FILES["sound"]["error"]===0)        ? $_FILES["sound"]                  : null;

        if(!$artist){
            throw new Exception("insert an artist, sucker");
        }

        $uploadImg=null;
        if($img){
            $uploadImg = $songs->uploadImg($img);
            if($uploadImg ==="Error uploading image: file too bigger" OR $uploadImg ==="Error uploading image: not supported format"){
				throw new Exception($uploadImg);
			}
        }
        if($sound){
            $uploadSound=$songs->uploadSound($sound);
			if($uploadSound ==="Error uploading sound: file too bigger" OR $uploadSound ==="Error uploading sound: not supported format"){
				throw new Exception($uploadSound);
            }    
		}else{
            throw new Exception("insert a song");
        }

        $myAudio = (is_array($uploadSound))?$uploadSound["audio"]:null;
        $myAudioPath=(is_array($uploadSound))?$uploadSound["audio_path"]:null;

        $myImg=(is_array($uploadImg))?$uploadImg["img"]:null;
        $myImgPath=(is_array($uploadImg))?$uploadImg["img_path"]:null;
        
        $res = $songs->insertSong(array(
            "name"=>$name,
            "artist"=>$artist,
            "year"=>$year,
            "audio"=>$myAudio,
            "audio_path"=>$myAudioPath,
            "image"=>$myImg,
            "image_path"=>$myImgPath
        ));
        if($res){
            $songs->printJSON(array(
                "statusText"=>"Song inserted successfuly",
                "responseCode"=>http_response_code(201)
            ));
        }else{
            $songs->error(
                "Error: query has failed"
            );
        }

        
    }catch(Exception $e){
        $songs->error("Something went wrong",
        array(
            "ErrorCode"=>$e->getCode(),
            "ErrorFile"=>$e->getFile(),
            "ErrorMessage"=>$e->getMessage(),
            "ErrorLine"=>$e->getLine()
        ));
    } 


}else{
    $songs->error(
        "Error 405: not allowed method"
    );
}
?>