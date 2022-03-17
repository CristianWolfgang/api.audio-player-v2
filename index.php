<?php

require "api/get-songs.php";
$songs = new GetSongs;

$method = $_SERVER["REQUEST_METHOD"];
if($method==="GET"){
    $mySongs = array();
    $mySongs["items"]=array();

    $res = $songs->getSongs();
    
    if($res->rowCount()){
        
        while($row = $res->fetch(PDO::FETCH_OBJ)){
            $item = array(
                "id"=>$row->id,
                "name"=>$row->name,
                "artist"=>$row->artist,
                "year"=>$row->year,
                "image"=>$row->image,
                "audio"=>$row->audio
            );
            array_push($mySongs["items"],$item);
        }

        $mySongs["statusText"] = "Success";
        $mySongs["responseCode"] = http_response_code(200);
        
        $songs->printJSON($mySongs);
    }else{
        $songs->error("There are not songs");
    }
}else{
    $songs->error(
        "Error 405: not allowed method"
    );
}
?>