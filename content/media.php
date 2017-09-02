<h1 class="w3-text-teal">Media</h1> 

<div class="w3-text-teal w3-margin-top">
<?php
$ordner = "media";
$allebilder = scandir($ordner,1);                             
foreach ($allebilder as $bild) {
$bildinfo = pathinfo($ordner."/".$bild); 
$size = ceil(filesize($ordner."/".$bild)/1024); 
if ($bild != "." && $bild != ".."  && $bild != "_notes" && $bildinfo['basename'] != "Thumbs.db") { 
$explode=explode(".", $bildinfo['basename']);
$fileTyp=$explode[1];
#echo "FILETYP: $fileTyp";

// PICTURES
			if($fileTyp=="jpeg" OR $fileTyp=="jpg" OR $fileTyp=="gif" OR $fileTyp=="png") {
echo "
  <div class=\"w3-card-2\">
    <a href=\"$bildinfo[dirname]/$bildinfo[basename]\" target=\"_blank\"><img src=\"$bildinfo[dirname]/$bildinfo[basename]\" style=\"width:100%\">
    <div class=\"w3-container\">
      <h4>$bildinfo[basename]</h4>
    </div>
  </div>
<br><br>";
}

// VIDEOS
		elseif($fileTyp=="mp4" OR $fileTyp=="avi" OR $fileTyp=="flv" OR $fileTyp=="mov") {
		echo "
  <div class=\"w3-card-2\">
    <video src=\"$bildinfo[dirname]/$bildinfo[basename]\" type=\"video/mp4\" controls></video>
    <div class=\"w3-container\">
      <h4>$bildinfo[basename]</h4>
    </div>
  </div>
<br><br>"; }

// MUSIC
		elseif($fileTyp=="mp3" OR $fileTyp=="wav" OR $fileTyp=="ogg" OR $fileTyp=="aif") {
		echo "
  <div class=\"w3-card-2\">
    <audio src=\"$bildinfo[dirname]/$bildinfo[basename]\" type=\"audio/wav\" controls></audio>
    <div class=\"w3-container\">
      <h4>$bildinfo[basename]</h4>
    </div>
  </div>
<br><br>";		}



};
};
?>
</div>