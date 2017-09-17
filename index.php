<?php
session_start();
require('includes/mysql_connection.inc.php');
require('includes/functions.inc.php');

?>
<!DOCTYPE html>
<html>
<title>localNET</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/w3-theme-black.css">
<link rel="stylesheet" href="css/Roboto.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/jeet.css">
<link rel="stylesheet" href="https://code.highcharts.com/css/highcharts.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>

<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="./?site=dashboard" class="w3-bar-item w3-button w3-theme-l1"><span class="fa fa-home">&nbsp;</span>localNET</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">&nbsp;</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">&nbsp;</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">&nbsp;</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">&nbsp;</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">&nbsp;</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">&nbsp;</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">&nbsp;</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" style="z-index:3;width:250px;margin-top:43px;" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>Menu</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=dashboard"><span class="fa fa-dashboard">&nbsp;</span>Dashboard</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=notes"><span class="fa fa-sticky-note">&nbsp;</span>Notes</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=webapps"><span class="fa fa-server">&nbsp;</span>webApps</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=media"><span class="fa fa-file-picture-o">&nbsp;</span>Media</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=explorer"><span class="fa fa-folder-o">&nbsp;</span>Explorer</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=services"><span class="fa fa-puzzle-piece">&nbsp;</span>Services</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=scripts"><span class="fa fa-file-code-o">&nbsp;</span>Scripts</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="?site=backup"><span class="fa fa-archive">&nbsp;</span>Backup</a>
  <span class="w3-bar-item">&nbsp;</span>
  <a class="w3-bar-item w3-button w3-hover-white" href="?site=settings"><span class="fa fa-gear">&nbsp;</span>Settings</a>
  <a class="w3-bar-item w3-button w3-hover-white" href="?site=logout"><span class="fa fa-sign-out">&nbsp;</span>Logout</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

	<div class="w3-row w3-padding-64">
    	<div class="w3-twothird w3-container">
		<?php require("includes/content.inc.php"); ?>
		</div>
	</div>

<!--  	<div class="w3-row">
    	<div class="w3-twothird w3-container">
    	<?php //require("includes/content.inc.php"); ?>
        </div>
	</div>
-->

	
<!--  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">
      <p class="w3-border w3-padding-large w3-padding-32 w3-center">AD</p>
      <p class="w3-border w3-padding-large w3-padding-64 w3-center">AD</p>
    </div>
  </div>

  <div class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">
      <p class="w3-border w3-padding-large w3-padding-32 w3-center">AD</p>
      <p class="w3-border w3-padding-large w3-padding-64 w3-center">AD</p>
    </div>
  </div>

  <div class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">
      <p class="w3-border w3-padding-large w3-padding-32 w3-center">AD</p>
      <p class="w3-border w3-padding-large w3-padding-64 w3-center">AD</p>
    </div>
  </div> -->

  <!-- Pagination 
  <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a class="w3-button w3-black" href="#">1</a>
      <a class="w3-button w3-hover-black" href="#">2</a>
      <a class="w3-button w3-hover-black" href="#">3</a>
      <a class="w3-button w3-hover-black" href="#">4</a>
      <a class="w3-button w3-hover-black" href="#">5</a>
      <a class="w3-button w3-hover-black" href="#">»</a>
    </div>
  </div>
  -->

  <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>code by gemichelst - design by w3c</p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
