function deleteCustomer(id) {
  var confirmation = confirm("Are you sure?");
  if (confirmation) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if ((xhttp.readyState = 4 && xhttp.status == 200))
        document.getElementById("customers_div").innerHTML = xhttp.responseText;
    };
    xhttp.open("GET", "php/manage_customer.php?action=delete&id=" + id, true);
    xhttp.send();
  }
}

function editCustomer(id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if ((xhttp.readyState = 4 && xhttp.status == 200))
      document.getElementById("customers_div").innerHTML = xhttp.responseText;
  };

  xhttp.open("GET", "php/manage_customer.php?action=edit&id=" + id, true);
  xhttp.send();
}

function updateCustomer(id) {
  var customer_name = document.getElementById("customer_name");
  var contact_number = document.getElementById("customer_contact_number");
  var customer_address = document.getElementById("customer_address");
  var customer_state = document.getElementById("customer_state");
  var customer_country = document.getElementById("customer_country");
  console.log(document.getElementById("customer_name").value);
  // var doctor_name = document.getElementById("customer_doctors_name");
  // var doctor_address = document.getElementById("customer_doctors_address");
  if (!validateName(customer_name.value, "name_error")) customer_name.focus();
  else if (!validateContactNumber(contact_number.value, "contact_number_error"))
    contact_number.focus();
  else if (!validateAddress(customer_address.value, "address_error"))
    customer_address.focus();
  // else if(!validateName(doctor_name.value, 'doctor_name_error'))
  //   doctor_name.focus();
  // else if(!validateAddress(doctor_address.value, 'doctor_address_error'))
  //   doctor_address.focus();
  else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if ((xhttp.readyState = 4 && xhttp.status == 200))
        document.getElementById("customers_div").innerHTML = xhttp.responseText;
    };

    xhttp.open(
      "GET",
      "php/manage_customer.php?action=update&id=" +
        id +
        "&name=" +
        customer_name.value +
        "&contact_number=" +
        contact_number.value +
        "&address=" +
        customer_address.value +
        "&state=" +
        customer_state.value +
        "&country=" +
        customer_country.value,
      true
    );
    xhttp.send();
  }
}

function cancel() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if ((xhttp.readyState = 4 && xhttp.status == 200))
      document.getElementById("customers_div").innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/manage_customer.php?action=cancel", true);
  xhttp.send();
}

function searchCustomer(text, tag) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if ((xhttp.readyState = 4 && xhttp.status == 200))
      document.getElementById("customers_div").innerHTML = xhttp.responseText;
  };
  xhttp.open(
    "GET",
    "php/manage_customer.php?action=search&text=" + text + "&tag=" + tag,
    true
  );
  xhttp.send();
}
