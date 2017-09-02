<?php

if(!isset($_GET["site"])) { include('content/dashboard.php'); } else {

		$site=$_GET["site"];
			if($site=="dashboard"){ include('content/dashboard.php'); }
		elseif($site=="notes"){ include('content/notes.php'); }
		elseif($site=="media"){ include('content/media.php'); }
		elseif($site=="explorer"){ include_once('content/filemanager/class/FileManager.php'); 
       $FileManager = new FileManager();
       print $FileManager->create();

        }
		elseif($site=="services"){ include('content/services.php'); }
		elseif($site=="webapps"){ include('content/webapps.php'); }
		elseif($site=="scripts"){ include('content/scripts.php'); }
		elseif($site=="backup"){ include('content/backup.php'); }
		elseif($site=="settings"){ include('content/settings.php'); }
		elseif($site=="logout"){ include('content/logout.php'); }
		else { echo "no site given"; }

}


?>