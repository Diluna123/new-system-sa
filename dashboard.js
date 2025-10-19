/* globals Chart:false */

// (() => {
//   "use strict";

//   // Graphs
//   const ctx = document.getElementById("myChart");
//   // eslint-disable-next-line no-unused-vars
//   const myChart = new Chart(ctx, {
//     type: "line",
//     data: {
//       labels: [
//         "Janu",
//         "Feb",
//         "Mar",
//         "Apr",
//         "May",
//         "Aug",
//         "Sept",
//         "Oct",
//         "Nov",
//         "Dec",
//       ],
//       datasets: [
//         {
//           data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
//           lineTension: 0,
//           backgroundColor: "transparent",
//           borderColor: "#007bff",
//           borderWidth: 4,
//           pointBackgroundColor: "#007bff",
//         },
//       ],
//     },
//     options: {
//       plugins: {
//         legend: {
//           display: false,
//         },
//         tooltip: {
//           boxPadding: 3,
//         },
//       },
//     },
//   });
// })();
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
        window.location.reload();
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
        setTimeout(function () {
          window.location.reload();
        }, 1000);
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

        setTimeout(function () {
          window.location.reload();
        }, 1000);
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
  var rpw = document.getElementById("rpw");

  //   const checkbox = document.getElementById("checkbox");
  //   const alertbox = document.getElementById("alert-d");

  const form = new FormData();
  form.append("email", email);
  form.append("password", password);
  form.append("rpw", rpw.checked);

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

function deletePol(cid) {
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
        setTimeout(function () {
          window.location.reload();
        }, 1000);
      } else {
        alert(req1.responseText);
      }
    }
  };
  req1.open("GET", "deletePoliceProcess.php?cid=" + cid, true);
  req1.send();
}

// function signin(){
//   alert("ok");
// }
if ("serviceWorker" in navigator) {
  navigator.serviceWorker
    .register("service-worker.js")
    .then(() => console.log("Service Worker Registered"));
}

// cutomerleads php functions

function getCustomerLeads() {
  const cname = document.getElementById("cName");
  const contact = document.getElementById("contact_cl");
  const sname = document.getElementById("shopName");
  const loc_cl = document.getElementById("loc_cl");

  var req = new XMLHttpRequest();

  var form = new FormData();
  form.append("cname", cname.value);
  form.append("contact", contact.value);
  form.append("sname", sname.value);
  form.append("loc_cl", loc_cl.value);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        Swal.fire({
          icon: "success",
          title: "Success",
          showConfirmButton: false,
          timer: 1500,
        });
        setTimeout(function () {
          window.location.reload();
        }, 1000);
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "addCustomerLeadsProcess.php", true);
  req.send(form);
}

function searchLeadas() {
  const dateIn = document.getElementById("dateInput");
  alert(dateIn.value);
}

function performSearch() {
  const contact = document.getElementById("contactInput");
  const date = document.getElementById("dateInput");
  const table = document.getElementById("searchResults");

  table.innerHTML = "";
  table.innerHTML =
    '<tr id="loadingRow" class="text-center"><td colspan="5"><div class="d-flex justify-content-center align-items-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><span class="ms-2 text-muted">Loading data...</span></div></td></tr>';

  var req = new XMLHttpRequest();

  var form = new FormData();
  form.append("contact", contact.value);
  form.append("date", date.value);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      table.innerHTML = req.responseText;
    }
  };
  req.open("POST", "searchCustomerLeadsProcess.php", true);
  req.send(form);
}

function leadsOffcanvas(clid) {
  var myOffcanvas = document.getElementById("leadsOff");
  var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
  bsOffcanvas.show();

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      performSearch();
      document.getElementById("leadsOffBody").innerHTML = req.responseText;
    }
  };
  req.open("GET", "leadsOffcanvasProcess.php?clid=" + clid, true);
  req.send();
}

function leadsUpdate(clid, sOrD) {
  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("clid", clid);
  form.append("sOrD", sOrD);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        performSearch();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "leadsUpdateProcess.php", true);
  req.send(form);
}

function openAddTargetModal() {
  $("#addTargetModal").modal("show");
}

function addTarget() {
  var targetAmount = document.getElementById("targetAmount").value;
  var monthSelect = document.getElementById("monthSelect").value;
  var spoSelect = document.getElementById("spoSelect").value;

  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("targetAmount", targetAmount);
  form.append("monthSelect", monthSelect);
  form.append("spoSelect", spoSelect);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        $("#addTargetModal").modal("hide");
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "addTargetProcess.php", true);
  req.send(form);
}

function addNewSpo() {
  const sfname = document.getElementById("fName_sp").value.trim();
  const slname = document.getElementById("lName_sp").value.trim();
  const semail = document.getElementById("email_sp").value.trim();
  const code = document.getElementById("code_sp").value.trim();
  const pwd = document.getElementById("pwd_sp").value.trim();
  const cpwd = document.getElementById("cpwd_sp").value.trim();

  if (!sfname || !slname || !semail || !code || !pwd || !cpwd) {
    alert("All fields are required!");
    return;
  }

  if (pwd !== cpwd) {
    alert("Passwords do not match!");
    return;
  }

  const form = new FormData();
  form.append("fname", sfname);
  form.append("lname", slname);
  form.append("email", semail);
  form.append("code", code);
  form.append("pwd", pwd);
  form.append("cpwd", cpwd);

  const req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status === 200) {
      if (req.responseText.trim() === "success") {
        alert("User added successfully!");
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "addNewSpoProcess.php", true);
  req.send(form);
}

function getToggleValue(element, uid) {
  let status = element.checked ? "1" : "2";

  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("status", status);
  form.append("uid", uid);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "toggleProcess.php", true);
  req.send(form);
}

function verifyEmail(id) {
  if (id == 1) {
    window.location.reload();
  } else {
    const verifyInput = document.getElementById("verifyCode");
    const vBtn = document.getElementById("vBtn");
    const loading = document.getElementById("vSpinner");
    const loText = document.getElementById("loText");

    vBtn.className = "d-none";
    loading.className = "d-block text-center";

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
      if (req.readyState == 4 && req.status == 200) {
        loText.innerHTML = req.responseText;
        loading.className = "d-none";
        verifyInput.className = "d-block mt-1";
      }
    };
    req.open("GET", "emailVerificationProcess.php", true);
    req.send();
  }
}
function changePass() {
  const vcode = document.getElementById("vCode").value;
  const npass = document.getElementById("newPass").value;

  if (!vcode || !npass) {
    alert("All fields are required!");
    return;
  }
  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("vcode", vcode);
  form.append("npass", npass);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        alert("Password changed successfully!");
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "changePassProcess.php", true);
  req.send(form);
}

function searchPolicyReport() {
  var planTy = document.getElementById("PlanType").value;
  var base = document.getElementById("reportSearchPre");

  var fdate = document.getElementById("fromDate").value;
  var tdate = document.getElementById("toDate").value;

  var form = new FormData();
  form.append("planTy", planTy);
  form.append("fdate", fdate);
  form.append("tdate", tdate);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      base.innerHTML = req.responseText;
    }
  };
  req.open("POST", "policyReportProcess.php", true);
  req.send(form);
}

function updateUserInfo() {
  const fname = document.getElementById("SfirstName").value;
  const lname = document.getElementById("SlastName").value;
  const code = document.getElementById("Scode").value;
  const contact = document.getElementById("contactNum").value;

  var req = new XMLHttpRequest();
  var form = new FormData();
  form.append("fname", fname);
  form.append("lname", lname);
  form.append("code", code);
  form.append("contact", contact);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        alert("User Info Updated Successfully");
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "updateUserInfoProcess.php", true);
  req.send(form);
}

//report printing

function printReport() {
  var planTy = document.getElementById("PlanType").value;
  var fdate = document.getElementById("fromDate").value;
  var tdate = document.getElementById("toDate").value;

  var form = document.createElement("form");
  form.method = "POST";
  form.action = "pdfGenarate.php";
  form.target = "_blank";

  const data = { planTy, fdate, tdate };
  for (let key in data) {
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = key;
    input.value = data[key];
    form.appendChild(input);
  }

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}

const schedule = require("node-schedule");

// Schedule a job at 23:59 on the last day of each month
const job = schedule.scheduleJob("59 23 28-31 * *", function () {
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);

  if (tomorrow.getDate() === 1) {
    // It's the last day of the month
    runMonthlySummary();
  }
});

function runMonthlySummary() {
  console.log("Running monthly summary function...");
  // Your logic here (e.g., DB ops, file write, API call, etc.)
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      console.log(req.responseText);
    }
  };
  req.open("GET", "monthlySummaryProcess.php", true);
  req.send();
}

function addMCustomer() {
  const fname = document.getElementById("Mfname").value;
  const lname = document.getElementById("Mlname").value;
  const contact = document.getElementById("Mcnum").value;
  const ammount = document.getElementById("Mammount").value;
  const plan = document.getElementById("Mplan").value;
  const loc = document.getElementById("Mloc").value;

  const payId = document.getElementById("Mpayment").value;

  var form = new FormData();
  form.append("fname", fname);
  form.append("lname", lname);
  form.append("contact", contact);
  form.append("ammount", ammount);
  form.append("plan", plan);
  form.append("loc", loc);
  form.append("payId", payId);
  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      if (req.responseText == "success") {
        alert("Customer Added Successfully");
        window.location.reload();
      } else {
        alert(req.responseText);
      }
    }
  };
  req.open("POST", "addMCustomerProcess.php", true);
  req.send(form);
}

function searchMD() {
  var indate = document.getElementById("searchInputMD").value;
  var table = document.getElementById("searchResultsMD");

  table.innerHTML = "";
  table.innerHTML =
    '<tr id="loadingRow" class="text-center"><td colspan="7"><div class="d-flex justify-content-center align-items-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><span class="ms-2 text-muted">Loading data...</span></div></td></tr>';

  var req = new XMLHttpRequest();

  var form = new FormData();
  form.append("indate", indate);
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      table.innerHTML = req.responseText;
    }
  };
  req.open("POST", "searchMDProcess.php", true);
  req.send(form);
}

function getMDPolicysDetails(cid) {
  var myOffcanvas = document.getElementById("detailsViewCanvasMobile");
  var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
  bsOffcanvas.show();

  var canvasBody = document.getElementById("detailsViewCanvasMobileBody");

  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      canvasBody.innerHTML = req.responseText;
    }
  };
  req.open("GET", "getMDPolicysDetailsProcess.php?cid=" + cid, true);
  req.send();
}

function policyAssign(cid) {
  const tostBody = document.getElementById("toastBody");
  const toastLiveExample = document.getElementById("liveToast");
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

  const myOffcanvas = document.getElementById("detailsViewCanvasMobile");
  const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(myOffcanvas);

  const req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status === 200) {
      if (req.responseText === "success") {
        tostBody.innerHTML = "Policy Assigned Successfully!";
        bsOffcanvas.hide(); // Close the offcanvas
        toastBootstrap.show(); // Show the toast

        // Reload after 2 seconds to give user time to see the toast
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("GET", "policyAssignProcess.php?cid=" + cid, true);
  req.send();
}

// genarate verification code

function genarateCode() {
  var codeIn = document.getElementById("GVcode");
  var req = new XMLHttpRequest();
  req.onreadystatechange = function () {
    if (req.readyState == 4 && req.status == 200) {
      codeIn.value = req.responseText;
    }
  };
  req.open("GET", "genarateCodeProcess.php", true);
  req.send();
}

function verifyAf(afuid, status) {
  if (status == 6) {
    Swal.fire({
      title: "Are you sure?",
      text: "Are your want to Band this business?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        var form = new FormData();
        form.append("afuid", afuid);
        form.append("status", status);
        var req = new XMLHttpRequest();
        req.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "success") {
              Swal.fire({
                icon: "success",
                title: "Banded",
                text: "Business Banded!",
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
        req.open("POST", "afVerifyProcess.php", true);
        req.send(form);
      }
    });
  } else {
    var form = new FormData();
    form.append("afuid", afuid);
    form.append("status", status);

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "success") {
          Swal.fire({
            icon: "success",
            title: "success",
            text: "Business Verified!",
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
    req.open("POST", "afVerifyProcess.php", true);
    req.send(form);
  }
}

function afUserDetailsCanvas(afid){
  var myOffcanvas = document.getElementById("offCanvasAf");
  var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
  bsOffcanvas.show();
}

function sendWpMessage() {
  alert("ok");


}