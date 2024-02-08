function showSuggestions(text, action) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      document.getElementById(action + "_suggestions").innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/suggestions.php?action=" + action + "&text=" + text, true);
  xhttp.send();
}

function clearSuggestions(id) {
  var div = document.getElementById(id + "_suggestions");
  if(div)
    div.innerHTML = "";
}

function suggestionClick(value, id) {
  document.getElementById(id + "s_name").value = value;
  if(id == "customer") {
    console.log(value + " = value & id = " + id);
    fillCustomerDetails(value);
  }
  if(id == "supplier")
  {
    console.log(value + " = value & id = " + id);
    fillSupplierDetails(value);
  }
  clearSuggestions(id);
  notNull(value, id + '_name_error');
}

function fillSupplierDetails(name)
{
  getSupplierDetail("vehicles_number", name);
  getSupplierDetail("gsts_number", name);
}


function getSupplierDetail(id, name) {
 //alert(id);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
  document.getElementById(id).value = xhttp.responseText;

  };
  xhttp.open("GET", "php/add_new_purchase.php?action=" + id + "&name=" + name, true);
  xhttp.send();
}





function fillCustomerDetails(name) {
  console.log(name+"this");
   getCustomerDetail("customers_address", name);
   getCustomerDetail("customers_contact_number", name);
  getCustomerDetail("vehicles_number", name);
  getCustomerDetail("gsts_number", name);

}

function getCustomerDetail(id, name) {
 //alert(id);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
  document.getElementById(id).value = xhttp.responseText;

  };
  xhttp.open("GET", "php/suggestions.php?action=" + id + "&name=" + name, true);
  xhttp.send();
}

document.addEventListener("click", (evt) => {
    const dn1 = document.getElementById("supplier_suggestions");
    const dn2 = document.getElementById("suppliers_name");
    const dn3 = document.getElementById("customer_suggestions");
    const dn4 = document.getElementById("customers_name");
    //alert(dn4.value);
    let te = evt.target;
    do {
        if (te == dn1 || te == dn2 || te == dn3 || te == dn4)
          return;
        te = te.parentNode;
    } while(te);
    clearSuggestions("supplier");
    clearSuggestions("customer");
});
