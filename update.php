<?php
require "./api/update-song.php";
$updateSong = new UpdateSong;
$method = $_SERVER["REQUEST_METHOD"];
if($method==="POST"){
    $id     = !(empty($_POST["id"]))                  ? $_POST["id"]                     : null;
    $name   = !(empty($_POST['sound-name']))          ? ucfirst($_POST['sound-name'])    : null;
    $artist = !(empty($_POST['sound-artist']))        ? ucwords($_POST['sound-artist'])  : null;
    $year   = !(empty($_POST['sound-year']))          ? $_POST['sound-year']             : null;
    $img    = ($_FILES["artist-image"]["error"]===0) ? $_FILES["artist-image"]           : null;
    $sound  = ($_FILES["sound"]["error"]===0)        ? $_FILES["sound"]                  : null;
    $newImage=null;
    $newImagePath=null;
    $newSong = null;
    $newSongPath=null;

    if(!$artist){
        $updateSong->error("There is not an artist, sucker");
        exit();
    }
    if($img){
        $image = $updateSong->getImage($artist);
        $rowImage = $image->fetch(PDO::FETCH_ASSOC);

        if($rowImage["image_path"]){
            unlink($rowImage["image_path"]);
        }
        //Deleting image from the folder
        $myNewImage = $updateSong->uploadImg($img);
        
        $newImage = $myNewImage["img"];
        $newImagePath = $myNewImage["img_path"];
    }

    if($sound){
        
        $song  = $updateSong->getAudio($id);
        $rowSong  = $song->fetch(PDO::FETCH_ASSOC);
        //Deleting song from the folder
        unlink($rowSong["audio_path"]);

        $myNewSong = $updateSong->uploadSound($sound);
        
        $newSong = $myNewSong["audio"];
        $newSongPath=$myNewSong["audio_path"];
    }
    

    $res = $updateSong->updateSong(array(
        "id"=>$id,
        "name"=>$name,
        "artist"=>$artist,
        "year"=>$year,
        "audio"=>$newSong,
        "audio_path"=>$newSongPath,
        "image"=>$newImage,
        "image_path"=>$newImagePath
    ));
    if($res){
        $updateSong->printJSON(array(
            "statusText"=>"Song updated sucessfuly"
        ));
    }else{
        $updateSong->error("Something went wrong");
    }
}else{
    $updateSong->error("Error 405: not allowed method");
}
?>