/* globals Chart:false */

(() => {
  "use strict";

  // Graphs
  const ctx = document.getElementById("myChart");
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      datasets: [
        {
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "#007bff",
          borderWidth: 4,
          pointBackgroundColor: "#007bff",
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          boxPadding: 3,
        },
      },
    },
  });
})();
function loadDashboard() {
  const mainDev = document.getElementById("main-dev");

  mainDev.innerHTML = "";

  var req = new XMLHttpRequest();
  req.open("POST", "dashboard.php", true);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      mainDev.innerHTML = req.responseText;
    }
  };
  req.send();
}
function loadOrders() {
  const mainDev = document.getElementById("main-dev");
  mainDev.innerHTML = "";

  var req = new XMLHttpRequest();
  req.open("POST", "orders.php", true);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      mainDev.innerHTML = req.responseText;
    }
  };
  req.send();
}

function showModal() {
  var mymodal = new bootstrap.Modal(document.getElementById("addNewModal"));
  mymodal.show();
}

function editCustomer(cid) {
  const mainDev = document.getElementById("customerDetailsCanvasBody");
  mainDev.innerHTML = "";

  var req = new XMLHttpRequest();
  req.open("GET", "eidteCanvas.php?cid=" + cid, true);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      mainDev.innerHTML = req.responseText;
    }
  };
  req.send();
}

function updateCustomer(cid) {
  // const date = document.getElementById("date");
  const fname = document.getElementById("fnameU");
  const lname = document.getElementById("lnameU");
  const nic = document.getElementById("nicU");
  const age = document.getElementById("ageU");
  const phone = document.getElementById("contactU");
  const address = document.getElementById("addresU");
  const dob = document.getElementById("dobU");
  // const location = document.getElementById("locText");

  // police details
  const plane = document.getElementById("planeU");
  const payment = document.getElementById("paymentU");
  const ammount = document.getElementById("ammountU");
  const timep = document.getElementById("timepU");
  const note = document.getElementById("noteU");

  const proNum = document.getElementById("pro_numU");
  const polNUm = document.getElementById("pol_numU");




  const mainDev = document.getElementById("customerDetailsCanvasBody");
  mainDev.innerHTML = "";
  mainDev.innerHTML =
    '<div class="row h-100"><div class="col-12 d-flex flex-column justify-content-center align-items-center  "><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div><div><small class="text-secondary">Updating New Details</small></div></div></div>';

  var req1 = new XMLHttpRequest();
  var form = new FormData();
  form.append("cid", cid);
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("nic", nic.value);
  form.append("age", age.value);
  form.append("dob", dob.value);

  form.append("contact", phone.value);
  form.append("address", address.value);
  form.append("plane", plane.value);
  form.append("payment", payment.value);
  form.append("ammount", ammount.value);
  form.append("timep", timep.value);
  form.append("note", note.value);

  form.append("pronum", proNum.value);
  form.append("polnum", polNUm.value);

  req1.onreadystatechange = function () {
    if (req1.readyState == 4 && req1.status == 200) {
      if (req1.responseText == "success") {
        mainDev.innerHTML =
          '<div class="row h-100"><div class="col-12 d-flex flex-column justify-content-center align-items-center  "><div class="" role=""><i class="fas fa-check fs-5 text-success"></i></div><div><small class="text-success">Update Success</small></div></div></div>';
        setTimeout(function () {
          showCanvasModal(cid);
        }, 1000);
        // setTimeout(showCanvasModal(cid), 30000);

        // setTimeout(() => {
        //     showCanvasModal(cid);
        // }, 10000); // You can adjust the delay (in milliseconds) as needed
        // showCanvasModal(cid);

        // Swal.fire({
        //   icon: "success",
        //   title: "Update Successful",
        //   showConfirmButton: false,
        //   timer: 1500,
        // });
      } else {
        alert(req1.responseText);
      }
    }
  };
  req1.open("POST", "updatedCanvasProcess.php", true);
  req1.send(form);
}

function showCModal(cid, com) {
  var mymodal2 = new bootstrap.Modal(document.getElementById("proposalModal"));
  if (com == 1) {
    mymodal2.show();
  } else {
    mymodal2.hide();
  }

  var cidStore = document.getElementById("cidStore");
  cidStore.innerHTML = cid;
}

function submitProposal(cid) {
  const proNum = document.getElementById("proNum");
  const polNum = document.getElementById("polNum");
  var cidStore = document.getElementById("cidStore");
  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("proNum", proNum.value);
  form.append("polNum", polNum.value);
  form.append("cid", cidStore.innerHTML);

  req.open("POST", "closeProp.php", true);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        Swal.fire({
          icon: "success",
          title: "Police Closed Successful",
          showConfirmButton: false,
          timer: 1500,
        });
        proNum.value = "";
        polNum.value = "";
      } else {
        Swal.fire({
          icon: "warning",
          title: req.responseText,
          showConfirmButton: false,
          timer: 1500,
        });
      }
    }
  };
  req.send(form);
}

function submitBtn() {
  const date = document.getElementById("date");
  const fname = document.getElementById("fname");
  const lname = document.getElementById("lname");
  const nic = document.getElementById("nic");
  const age = document.getElementById("age");
  const dob = document.getElementById("dob");
  const phone = document.getElementById("contact");
  const address = document.getElementById("address");
  const location = document.getElementById("locText");

  // police details
  const plane = document.getElementById("plane");
  const payment = document.getElementById("payment");
  const ammount = document.getElementById("ammount");
  const timep = document.getElementById("timep");
  const note = document.getElementById("note");

  var req = new XMLHttpRequest();
  var form = new FormData();
  req.open("POST", "addCustomer.php", true);

  form.append("date", date.value);
  form.append("fname", fname.value);
  form.append("lname", lname.value);
  form.append("nic", nic.value);
  form.append("age", age.value);
  form.append("dob", dob.value);

  form.append("contact", phone.value);
  form.append("address", address.value);
  form.append("locText", location.value);

  form.append("plane", plane.value);
  form.append("payment", payment.value);
  form.append("ammount", ammount.value);
  form.append("timep", timep.value);
  form.append("note", note.value);

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          showConfirmButton: false,
          timer: 1500,
        });

        fname.value = "";
        lname.value = "";
        nic.value = "";
        phone.value = "";
        address.value = "";
        location.value = "";
        plane.value = "";
        payment.value = "";
        ammount.value = "";
        timep.value = "";
        note.value = "";
        age.value = "";

        $("#policiesTable").load(location.href + " #policiesTable");
      } else {
        alert(req.responseText);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Something went wrong!",
        });
      }
    }
  };
  req.send(form);
}
function showCanvasModal(cid) {
  var myOffcanvas = document.getElementById("offcanvasRight");
  var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
  bsOffcanvas.show();

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      const mainDev = document.getElementById("offcanvasRight");
      mainDev.innerHTML = req.responseText;
      // document.getElementById("canvasBody").innerHTML = req.responseText;
    }
  };
  req.open("GET", "updatedCanvas.php?cid=" + cid, true);
  req.send();
}

function uploadNic(cid) {
  const nicp = document.getElementById("nicP");

  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("nicp", nicp.files[0]);
  form.append("cid", cid);

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        
        Swal.fire({
          icon: "success",
          title: "NIC Updated Successfully",
          showConfirmButton: false,
          timer: 1500,
        });

        // Clear the file input field
        nicp.value = "";
        
      } else {
        
        Swal.fire({
          icon: "warning",
          title: req.responseText,
          showConfirmButton: false,
          timer: 1500,
        });
      }
    }
  };
  req.open("POST", "uploadNic.php", true);
  req.send(form);
}

function nicModalOpen(cid) {
  var mymodal2 = new bootstrap.Modal(document.getElementById("nicModal"));
  mymodal2.show();

  var modalBody = document.getElementById("nicModal");

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      
      modalBody.innerHTML = req.responseText;
    }
  };
  req.open("GET", "nicModal.php?cid=" + cid, true);
  req.send();



}

function signin() {
 
  
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
//   const checkbox = document.getElementById("checkbox");
//   const alertbox = document.getElementById("alert-d");

  const form = new FormData();
  form.append("email", email);
  form.append("password", password);
//   form.append("cResults", checkbox.checked);

  const request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      
      if (this.responseText == "success") {
        
        window.location.href = "index.php";
      } else {
        alert(this.responseText);
        
      }
    }
  };
  request.open("POST", "loginProcess.php", true);
  request.send(form);
}
function signOut() {
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
  req.open("GET", "signoutProcess.php", true);
  req.send();
}

function deletePol(cid){
  const mainDev = document.getElementById("customerDetailsCanvasBody");
  mainDev.innerHTML = "";
  mainDev.innerHTML =
    '<div class="row h-100"><div class="col-12 d-flex flex-column justify-content-center align-items-center  "><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div><div><small class="text-secondary">Deleting Details</small></div></div></div>';

  var req1 = new XMLHttpRequest();
  req1.onreadystatechange = function () {
    if (req1.readyState == 4 && req1.status == 200) {
      if (req1.responseText == "success") {
        mainDev.innerHTML =
          '<div class="row h-100"><div class="col-12 d-flex flex-column justify-content-center align-items-center  "><div class="" role=""><i class="fas fa-check fs-5 text-danger"></i></div><div><small class="text-danger">Delete Success</small></div></div></div>';
        // setTimeout(function () {
        //   showCanvasModal(cid);
        // }, 1000);
        
      } else {
        alert(req1.responseText);
      }
    }
  };
  req1.open("GET", "deletePoliceProcess.php?cid="+cid, true);
  req1.send();




}

// function signin(){
//   alert("ok");
// }