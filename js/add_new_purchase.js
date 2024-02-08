var rows = 0;

//isSupplier = false;

class MedicineStock {
  constructor(name, batch_id, per, quantity, mrp, rate,discount,tax) {
    this.name = name;
    this.batch_id = batch_id;
    this.per = per;
    this.quantity = quantity;
    this.mrp = mrp;
    this.rate = rate;
    this.discount = discount;
    this.tax = tax;
  }
}

class NewMedicine {
  constructor(name, packing, generic_name, supplier_name) {
    this.name = name;
    this.packing = packing;
    this.generic_name = generic_name;
    this.supplier_name = supplier_name;
  }
}

function addRow() {
  if(typeof addRow.counter == 'undefined')
    addRow.counter = 1;
  var previous = document.getElementById("purchase_medicine_list_div").innerHTML;
  var node = document.createElement("div");
  var id = document.createAttribute("id");
  id.value = "medicine_row_" + addRow.counter;
  node.setAttributeNode(id);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      node.innerHTML = xhttp.responseText;
      document.getElementById("purchase_medicine_list_div").appendChild(node);
  };
  xhttp.open("GET", "php/add_new_purchase.php?action=add_row&row_id=" + id.value + "&row_number=" + addRow.counter, true);
  xhttp.send();
  //alert(addRow.counter);
  addRow.counter++;
  rows++;
}

function removeRow(row_id) {
  if(rows == 1)
    alert("Can't delete only one row is there!");
  else {
    document.getElementById(row_id).remove();
    rows--;
  }
}

function isSupplier(name) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
  xhttp.open("GET", "php/add_new_purchase.php?action=is_supplier&name=" + name, false);
  xhttp.send();
  return xhttp.responseText;
}

function checkInvoice(invoice_number, error) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
  xhttp.open("GET", "php/add_new_purchase.php?action=is_invoice&invoice_number=" + invoice_number, false);
  xhttp.send();
  if(xhttp.responseText == "true") {
    document.getElementById(error).style.display = "block";
    document.getElementById(error).innerHTML = "already added!";
    return true;
  }
  else
    document.getElementById(error).style.display = "none";
  return false;
}

function isNewMedicine(name, packing) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
  xhttp.open("GET", "php/add_new_purchase.php?action=is_new_medicine&name=" + name + "&packing=" + packing, false);
  xhttp.send();
  return xhttp.responseText;
}

function getAmount(row_number) {
//alert(row_number);
  var qty = document.getElementById("quantity_" + row_number).value;
  var rate = document.getElementById("rate_" + row_number).value;
  
  document.getElementById("amount_" + row_number).value = qty * rate;
 
  var amount = (qty * rate);
  if((document.getElementById("tax_" + row_number).value)>0){
    amount+=((amount*document.getElementById("tax_" + row_number).value))/100
  }
  document.getElementById("total_row_" + row_number).value=amount
  var parent = document.getElementById('purchase_medicine_list_div');
  var row_count = parent.childElementCount;
  var medicine_info = parent.children;
  
  var net_total = 0;
  var total_tax = 0;

  var total_amount = 0;
  
  for(var i = 1; i < row_count; i++) {
   // amount = Number.parseFloat(medicine_info[i].children[0].children[7].children[0].children[0].value);
  //  discount = (qty * rate * discount)/100;
  qty = Number.parseInt(medicine_info[i].children[0].children[3].children[0].value);
  rate = Number.parseFloat(medicine_info[i].children[0].children[6].children[0].value);
  //discount = Number.parseFloat(medicine_info[i].children[0].children[8].children[0].value);
 var tax = document.getElementById("tax_" + row_number).value;
   t_tax = (qty * rate * tax)
   var final= t_tax/100;
   net_total += ((qty * rate));
   // net_total += ((qty * rate) + final);
    total_tax += final;
    tax_deduction = total_tax/2;
    stax = tax_deduction;
    ctax = tax_deduction;
  }
 
  total_amount = net_total+total_tax ;
  document.getElementById('total_amount').value = net_total;
  document.getElementById('grand_total').value = total_amount;
  document.getElementById('total_tax').value = total_tax;
  document.getElementById("stax").value = stax;
  document.getElementById("ctax").value = ctax;
}

function addPurchase() {
   // alert('succ');
  var suppliers_name = document.getElementById('suppliers_name');
  var invoice_number = document.getElementById('invoice_number');
  var payment_type = document.getElementById('payment_type');
  var invoice_date = document.getElementById('invoice_date');
  var voucher_number = document.getElementById('voucher_number');
   var stax = document.getElementById('stax');
  var ctax = document.getElementById('ctax');


  if(!notNull(suppliers_name.value, "supplier_name_error"))
    suppliers_name.focus();
  else if(isSupplier(suppliers_name.value) == "false") {
    document.getElementById("supplier_name_error").style.display = "block";
    document.getElementById("supplier_name_error").innerHTML = "Supplier doesn't exists!";
    suppliers_name.focus();
  }
  else if(!notNull(invoice_number.value, 'invoice_number_error'))
    invoice_number.focus();

  else if(checkInvoice(invoice_number.value, 'invoice_number_error'))
    invoice_number.focus();

  else if(!checkDate(invoice_date.value, 'date_error'))
    invoice_date.focus();
  else {
    var parent = document.getElementById('purchase_medicine_list_div');
    var row_count = parent.childElementCount;
    var medicine_info = parent.children;

    var medicineStockRow = new Array(row_count-1);
    var newMedicine = new Array(row_count-1);
    //alert(newMedicine[0] == null);

    for(var i = 1; i < row_count; i++) {
      var elements_count = medicine_info[i].childElementCount;
      var elements = medicine_info[i].children;

      var medicine_name = elements[0].children[0].children[0];
      var medicine_name_error = elements[0].children[0].children[1];

      var packing = elements[0].children[1].children[0];
      var pack_error = elements[0].children[1].children[1];

      var batch_id = elements[0].children[2].children[0];
      var batch_id_error = elements[0].children[2].children[1];

      
      var quantity = elements[0].children[3].children[0];
      var quantity_error = elements[0].children[3].children[1];

      var per = elements[0].children[4].children[0];
      var per_error = elements[0].children[4].children[1];


      var mrp = elements[0].children[5].children[0];
      var mrp_error = elements[0].children[5].children[1];

      var rate = elements[0].children[6].children[0];
      var rate_error = elements[0].children[6].children[1];


      var amount = elements[0].children[7].children[0].children[0];
      //alert(amount.value);

       var discount = elements[0].children[8].children[0];
      var discount_error = elements[0].children[8].children[1];
      var tax = elements[0].children[9].children[0];
      var tax_error = elements[0].children[9].children[1];
      //alert(discount.value);
      var generic_name = elements[2].children[1].children[0];
      var generic_name_error = elements[2].children[1].children[1];
      generic_name_error.style.display = "none";

      var total_amount = document.getElementById("total_amount");  
      var grand_total = document.getElementById("grand_total");
     
      var flag = false;
      if(!notNull(medicine_name.value, medicine_name_error.getAttribute('id')))
        medicine_name.focus();

      else if(!notNull(packing.value, pack_error.getAttribute('id')))
        packing.focus();

      else if(!notNull(batch_id.value, batch_id_error.getAttribute('id')))
        batch_id.focus();

      else if(!checkPer(per.value, per_error.getAttribute('id')))
        per.focus();

      else if(!checkQuantity(quantity.value, quantity_error.getAttribute('id')))
        quantity.focus();

      else if(quantity.value == 0) {
        quantity_error.style.display = "block";
        quantity_error.innerHTML = "Increase quantity or remove row!"
        quantity.focus();
      }

      else if(!checkValue(mrp.value, mrp_error.getAttribute('id')))
        mrp.focus();

      else if(!checkValue(rate.value, rate_error.getAttribute('id')))
        rate.focus();

      else if(Number.parseInt(mrp.value) < Number.parseFloat(rate.value)) {
        rate_error.style.display = "block";
        rate_error.innerHTML = "Rate must be less than MRP!";
        rate.focus();
      }
      else if(isNewMedicine(medicine_name.value, packing.value) == "true" && generic_name.value == "") {
        generic_name_error.style.display = "block";
        generic_name_error.innerHTML = "Required for new Medicine!";
        generic_name.focus();
      }
      else if(!checkValue(discount.value, discount_error.getAttribute('id')))
        discount.focus();
      else {
      //alert("perfect");
      //alert(discount.value);
        flag = true;
        //alert("row perfect...");
        // go ahead and store row date
        medicineStockRow[i-1] = new MedicineStock(medicine_name.value, batch_id.value, per.value, quantity.value, mrp.value, rate.value,discount.value,tax.value);
        newMedicine[i-1] = new NewMedicine(medicine_name.value, packing.value, generic_name.value, suppliers_name.value);
      }

      if(!flag)
        return false;
    }
   
    // insert data into table
    for(var i = 0; i < row_count - 1; i++) {
     // alert(medicineStockRow[i].batch_id);
      if(isNewMedicine(newMedicine[i].name, newMedicine[i].packing) == "true")
        addNewMedicine(newMedicine[i].name, newMedicine[i].packing, newMedicine[i].generic_name, newMedicine[i].supplier_name);
             addMedicineStock(medicineStockRow[i].name, medicineStockRow[i].batch_id, medicineStockRow[i].per, medicineStockRow[i].quantity, medicineStockRow[i].mrp, medicineStockRow[i].rate,medicineStockRow[i].discount,medicineStockRow[i].tax, invoice_number.value);

    }

    addNewPurchase(stax.value,ctax.value,voucher_number.value, suppliers_name.value, invoice_number.value, payment_type.value, invoice_date.value, grand_total.value,total_amount.value);
  document.getElementById("add_purchase_button").style.display = "none";
    document.getElementById("new_purchase_button").style.display = "block";
    document.getElementById("print_purchase_button").style.display = "block";
  }
}

function addNewMedicine(name, packing, generic_name, supplier_name) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      alert("New medicine " + xhttp.responseText);
  };
  xhttp.open("GET", "php/add_new_medicine.php?name=" + name + "&packing=" + packing + "&generic_name=" + generic_name + "&suppliers_name=" + supplier_name, false);
  xhttp.send();
}

function addMedicineStock(name, batch_id, per, quantity, mrp, rate,discount,tax, invoice_number) {
  //alert(discount);exit();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      xhttp.responseText;
  };
 // alert(name);
  xhttp.open("GET", "php/add_new_purchase.php?action=add_stock&name=" + name + "&batch_id=" + batch_id + "&per=" + per + "&quantity=" + quantity + "&mrp=" + mrp + "&rate=" + rate + "&invoice_number=" + invoice_number + "&discount=" + discount+ "&tax=" + tax, true);
  xhttp.send();
}

function addNewPurchase(satx,ctax,voucher_number,suppliers_name, invoice_number, payment_type, invoice_date, grand_total,total_amount) {
  
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      document.getElementById('purchase_acknowledgement').innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/add_new_purchase.php?action=add_new_purchase&stax=" + stax + "&ctax=" + ctax + "&voucher_number=" + voucher_number + "&suppliers_name=" + suppliers_name + "&invoice_number=" + invoice_number + "&payment_type=" + payment_type + "&invoice_date=" + invoice_date + "&invoice_date=" + invoice_date + "&grand_total=" + grand_total + "&total_amount=" + total_amount, true);
  xhttp.send();
}


function printSinglePurchase(invoice_number) {

  var print_content;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      print_content = xhttp.responseText;
  };
  xhttp.open("GET", "php/manage_purchase.php?action=print_purchase&invoice_number=" + invoice_number, false);
  xhttp.send();
  var print_window = window.open('','','width=1000,height=600');
  var is_chrome = Boolean(print_window.chrome);
  print_window.document.write(print_content);

  if (is_chrome) {
     setTimeout(function() {
       print_window.document.close();
       print_window.focus();
       print_window.print();
       print_window.close();
     }, 250);
   }
   else {
     print_window.document.close();
     print_window.focus();
     print_window.print();
     print_window.close();
  }
  return true;
}
