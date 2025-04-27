function afRegister() {
  // stpe 1 details
  var nic = document.getElementById("afnic").value;
  var psw = document.getElementById("afpassword").value;
  var cpsw = document.getElementById("afconfirmPassword").value;

  // step 2 details

  var bankName = document.getElementById("bankName").value;
  var branch = document.getElementById("branch").value;
  var accountHname = document.getElementById("accountHolder").value;
  var accountNumber = document.getElementById("accountNumber").value;

  var form = new FormData();

  form.append("nic", nic);
  form.append("password", psw);
  form.append("confirmPassword", cpsw);
  form.append("bankName", bankName);
  form.append("branch", branch);
  form.append("accountHolder", accountHname);
  form.append("accountNumber", accountNumber);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "success") {
        Swal.fire({
          icon: "success",
          title: "success",
          text: "Registration Successful!",
        });
        setTimeout(function () {
          window.location.reload();
        }, 2000);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: this.responseText,
        });
      }
    }
  };
  req.open("POST", "afRegistrationProcess.php", true);
  req.send(form);
}

function afLogin() {
  var con = document.getElementById("contactNum").value;
  var psw = document.getElementById("password").value;

  var form = new FormData();
  form.append("contactNum", con);
  form.append("password", psw);

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "success") {
        window.location.href = "afDashboard.php";
      } else {
        // alert(this.responseText);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: this.responseText,
        });
        //
      }
    }
  };
  req.open("POST", "afLoginProcess.php", true);
  req.send(form);
}

function afsignOut() {
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      var res = req.responseText;
      if (res == "success") {
        window.location.reload();
      } else {
        alert(res);
      }
    }
  };
  req.open("GET", "afsignoutProcess.php", true);
  req.send();
}

function userAorIcheck(uid) {
  var mymodal2 = new bootstrap.Modal(document.getElementById("modalActive"));
  

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "inactive") {
        mymodal2.show();
      } else {
        
      }
    }
  };
  req.open("GET", "userAorIcheckProcess.php?uid=" + uid, true);
  req.send();
}
function addNewAfBusiness(){
  var fname = document.getElementById("afFname").value;
  var lname = document.getElementById("afLname").value;
  var contact= document.getElementById("afCnum").value;
  var afPlane = document.getElementById("afPlane").value;
  var amount = document.getElementById("afAmount").value;
  var nic = document.getElementById("afNic").value;

  
  var form = new FormData();
  form.append("fname", fname);
  form.append("lname", lname);
  form.append("contact", contact);
  form.append("afPlane", afPlane);
  form.append("amount", amount);
  form.append("nic", nic);
  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        Swal.fire({
          icon: "success",
          title: "success",
          text: "Customer Added Successfully!",
        });
        setTimeout(function () {
          window.location.reload();
        }, 2000);
        
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: req.responseText,
        })
     
      }
    }
  };
  req.open("POST", "addNewAfBusinessProcess.php", true);
  req.send(form);

}

function afActivate(uid){
    var actCode = document.getElementById("actCode").value;
    var form = new FormData();
    form.append("uid", uid);
    form.append("actCode", actCode);
  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "success") {
        Swal.fire({
          icon: "success",
          title: "success",
          text: "Account Activated!",
        });
        setTimeout(function () {
          window.location.reload();
        }, 2000);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: this.responseText,
        });
      }
    }
  };
  req.open("POST", "afActivateProcess.php", true);
  req.send(form);
}

