function notNull(text, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (text < 0) {
    result.innerHTML = "Invalid!";
    return false;
  } else if (text.trim() == "") {
    result.innerHTML = "Must be filled out!";
    return false;
  }
  result.style.display = "none";
  return true;
}

function validateName(name, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (name.trim() == "") {
    result.innerHTML = "Must be filled out!";
    return false;
  }
  result.innerHTML = "Must contain only letters!";
  for (var i = 0; i < name.length; i++)
    if (
      !(
        (name[i] >= "a" && name[i] <= "z") ||
        (name[i] >= "A" && name[i] <= "Z") ||
        name[i] == " "
      )
    )
      return false;
  result.style.display = "none";
  return true;
}

function validateContactNumber(contact_number, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (contact_number.length != 10) {
    result.innerHTML = "Must contain 10 digits!";
    return false;
  } else result.style.display = "none";
  return true;
}

function validateAddress(address, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (address.trim().length < 10) {
    result.innerHTML = "Please enter more specific address!";
    return false;
  } else result.style.display = "none";
  return true;
}

function checkExpiry(date, error) {
  // alert('ksjks');
  var result = document.getElementById(error);
  result.style.display = "block";
  if (address.trim().length < 10) {
    result.innerHTML = "Please enter more specific address!";
    return false;
  } else result.style.display = "none";
  return true;
}

function checkQuantity(quantity, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (quantity < 0 || !Number.isInteger(parseFloat(quantity)))
    result.innerHTML = "Invalid quantity!";
  else {
    result.style.display = "none";
    return true;
  }
  return false;
}

function checkPer(per, error) {
  // alert('dd');
  var result = document.getElementById(error);
  result.style.display = "block";
  if (per.trim().length < 0) {
    result.innerHTML = "Please enter more specific per!";
    return false;
  } else result.style.display = "none";
  return true;
}

function checkValue(value, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (value < 0 || value == "") result.innerHTML = "Invalid!";
  else {
    result.style.display = "none";
    return true;
  }
  return false;
}

function checkDate(date, error) {
  var result = document.getElementById(error);
  result.style.display = "block";
  if (date == "") result.innerHTML = "Mustn't be empty!!";
  else if (new Date(date) > new Date())
    result.innerHTML = "Mustn't be future date!";
  else {
    result.style.display = "none";
    return true;
  }
  return false;
}

function addCustomer() {
  document.getElementById("customer_acknowledgement").innerHTML = "";
  var customer_name = document.getElementById("customer_name");
  var contact_number = document.getElementById("customer_contact_number");
  var customer_address = document.getElementById("customer_address");
  var customer_state = document.getElementById("customer_state");
  var customer_country = document.getElementById("customer_country");
  var vehicle_number = document.getElementById("vehicle_number");
  var gst_number = document.getElementById("gst_number");
  if (!validateName(customer_name.value, "name_error")) customer_name.focus();
  else if (!validateContactNumber(contact_number.value, "contact_number_error"))
    contact_number.focus();
  else if (!validateAddress(customer_address.value, "address_error"))
    customer_address.focus();
  // else if(!validateName(vehicle_number.value, 'vehicle_number_error'))
  //   vehicle_number.focus();
  // else if(!validateAddress(gst_number.value, 'gst_number_error'))
  //   gst_number.focus();
  else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if ((xhttp.readyState = 4 && xhttp.status == 200))
        document.getElementById("customer_acknowledgement").innerHTML =
          xhttp.responseText;
    };
    console.log(
      (document.getElementById("customer_acknowledgement").innerHTML =
        xhttp.responseText)
    );
    xhttp.open(
      "GET",
      "php/add_new_customer.php?name=" +
        customer_name.value +
        "&contact_number=" +
        contact_number.value +
        "&address=" +
        customer_address.value +
        "&state=" +
        customer_state.value +
        "&country=" +
        customer_country.value +
        "&vehicle_number=" +
        vehicle_number.value +
        "&gst_number=" +
        gst_number.value,
      true
    );

    xhttp.send();
  }
  return false;
}

function addSupplier() {
  document.getElementById("supplier_acknowledgement").innerHTML = "";
  var supplier_name = document.getElementById("supplier_name");
  var supplier_email = document.getElementById("supplier_email");
  var contact_number = document.getElementById("supplier_contact_number");
  var supplier_address = document.getElementById("supplier_address");
  var supplier_state = document.getElementById("supplier_state");
  var supplier_country = document.getElementById("supplier_country");
  var vehicle_number = document.getElementById("vehicle_number");
  var gst_number = document.getElementById("gst_number");

  if (!validateName(supplier_name.value, "name_error")) supplier_name.focus();
  else if (!validateContactNumber(contact_number.value, "contact_number_error"))
    contact_number.focus();
  else if (!validateAddress(supplier_address.value, "address_error"))
    supplier_address.focus();
  else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if ((xhttp.readyState = 4 && xhttp.status == 200))
        document.getElementById("supplier_acknowledgement").innerHTML =
          xhttp.responseText;
    };
    xhttp.open(
      "GET",
      "php/add_new_supplier.php?name=" +
        supplier_name.value +
        "&email=" +
        supplier_email.value +
        "&contact_number=" +
        contact_number.value +
        "&address=" +
        supplier_address.value +
        "&state=" +
        supplier_state.value +
        "&country=" +
        supplier_country.value +
        "&vehicle_number=" +
        vehicle_number.value +
        "&gst_number=" +
        gst_number.value,
      true
    );
    xhttp.send();
  }
}

function addMedicine() {
  document.getElementById("medicine_acknowledgement").innerHTML = "";
  var name = document.getElementById("medicine_name");
  var packing = document.getElementById("packing");

  var generic_name = document.getElementById("generic_name");
  var suppliers_name = document.getElementById("suppliers_name");
  var hsn_no = document.getElementById("hsn_no");
  var avail_qty = document.getElementById("avail_qty");
  var mrp = document.getElementById("mrp");
  var item_discount = document.getElementById("item_discount");

  if (!notNull(name.value, "medicine_name_error")) name.focus();
  else if (!notNull(packing.value, "pack_error")) packing.focus();
  else if (!notNull(item_discount.value, "item_discount_error"))
    item_discount.focus();
  else if (!notNull(generic_name.value, "generic_name_error"))
    generic_name.focus();
  else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if ((xhttp.readyState = 4 && xhttp.status == 200))
        document.getElementById("medicine_acknowledgement").innerHTML =
          xhttp.responseText;
    };
    xhttp.open(
      "GET",
      "php/add_new_medicine.php?name=" +
        name.value +
        "&packing=" +
        packing.value +
        "&generic_name=" +
        generic_name.value +
        "&suppliers_name=" +
        suppliers_name.value +
        "&hsn_no=" +
        hsn_no.value +
        "&avail_qty=" +
        avail_qty.value +
        "&mrp=" +
        mrp.value +
        "&item_discount=" +
        item_discount.value,
      true
    );
    xhttp.send();
  }
}
