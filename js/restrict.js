var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if(xhttp.readyState = 4 && xhttp.status == 200)
    xhttp.responseText;
};
xhttp.open("GET", "php/db_connection.php?action=is_logged_in", false);
xhttp.send();

//alert(xhttp.responseText);
if(xhttp.responseText == "")
  window.location.href = "https://yrpitsolutions.com/embossed/index.html";

if(xhttp.responseText == "false")
  window.location.href = "https://yrpitsolutions.com/embossed/login.php";
