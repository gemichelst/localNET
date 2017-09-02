function sendContent(u, p, c) {
var str = u+p;	
//var query = "u="+u+"&p="+p+"&c="+c;

    if (str == "") {
		document.getElementById("statusMsg").style.visibility="visible";
        document.getElementById("statusMsg").innerHTML = "NO DATA GIVEN";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("statusMsg").style.visibility="visible";
                document.getElementById("statusMsg").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","actionHandler.php?sid=<?php echo session_id(); ?>&a=send&u="+u+"&p="+p+"&c="+c,true);
        xmlhttp.send();
    }
}

/* 
function none()
{
document.getElementById("d").style.visibility="visible";	
document.getElementById("d").style.visibility="hidden";
}
*/

function checkForContent(str) {
	
	var myVar = setInterval(receiveContent('true'), 10000);
	
	if(str == "stop") {
		clearInterval(myVar);	
	} 
	else {
		var nothing = "nothing";
	}
}

function receiveContent(str) {

    if (str == "") {
		document.getElementById("contentBox").style.visibility="hidden";
        document.getElementById("contentBox").innerHTML = "NO DATA GIVEN";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				
					if(xmlhttp.responseText == "") { 
					document.getElementById("contentBox").style.visibility="hidden";
					document.getElementById("closeBox").style.visibility="hidden";
					checkForContent();
					} else {
					document.getElementById("statusMsg").style.visibility="hidden";
					document.getElementById("contentBox").style.visibility="visible";
					document.getElementById("closeBox").style.visibility="visible";
               		document.getElementById("contentBox").innerHTML = xmlhttp.responseText;
					checkForContent('stop');
					}
            }
        }
        xmlhttp.open("GET","actionHandler.php?sid=<?php echo session_id(); ?>&a=receive",true);
        xmlhttp.send();
		
		//var ContentID = ;
    }
}

function closeContent(str) {

    if (str == "") {
		document.getElementById("contentBox").style.visibility="hidden";
        document.getElementById("contentBox").innerHTML = "NO DATA GIVEN";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("contentBox").style.visibility="hidden";
				document.getElementById("closeBox").style.visibility="hidden";
				document.getElementById("statusMsg").style.visibility="visible";
                document.getElementById("statusMsg").innerHTML = xmlhttp.responseText;
				checkForContent();
            }
        }
        xmlhttp.open("GET","actionHandler.php?sid=<?php echo session_id(); ?>&a=close",true);
        xmlhttp.send();
		checkForContent();
		//var ContentID = ;
    }
}
