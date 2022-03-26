# api.audio-player-v2
## RESTful API for music player
The host name shall be localhost if not you have to change the paths on the program.

Also the SQL files shall be imported on a database called audio_player.

Examples of use
### GET
```
fetch("http://localhost/api.audio-player-v2")
.then(res=>(res.ok) ? res.json() : Promise.reject(res.statusText));
```
### POST
To insert a song, the keys are:
 
name: sound-name

artist: sound-artist

year: sound-year

artist image (only jpg, jpeg, png): artist-image

song (only mp3): sound

```
cons data = new FormData("#insert-music");
fetch("http://localhost/api.audio-player-v2/post.php",{
	body:data,
	method:"POST"
});
```
the artist and song keys are required.

### DELETE
To delete a song 

```
fetch("http://localhost/api.audio-player-v2/delete.php",{
    method:"DELETE",
	  body:JSON.stringify({
	    id:song.id,
		  artist:song.artist
	  }),
	  header:{
	    "Content-type":"application/json"
	  }								
  });
```
###  UPDATE
you shall not allowed to change the artist song
```
const data = new FormData("#insert-music");
fetch("http://localhost/api.audio-player-v2/update.php,{
    method:"UPDATE"
    body:data;				
  });
```
