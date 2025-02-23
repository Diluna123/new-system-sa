/* globals Chart:false */

(() => {
  'use strict'

  // Graphs
  const ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  })
})()
function loadDashboard(){
  const mainDev = document.getElementById("main-dev");
  
  mainDev.innerHTML = "";

  
  var req = new XMLHttpRequest();
  req.open("POST", "dashboard.php", true);
  req.onreadystatechange = function() {
    if (req.readyState == 4 && req.status == 200) {
      mainDev.innerHTML = req.responseText;
    }
  }
  req.send();


}
function loadOrders(){
  const mainDev = document.getElementById("main-dev");
  mainDev.innerHTML = "";

  var req = new XMLHttpRequest();
  req.open("POST", "orders.php", true);
  req.onreadystatechange = function() {
    if (req.readyState == 4 && req.status == 200) {
      mainDev.innerHTML = req.responseText;
    }
  }
  req.send();
}
function showModal(){
  var mymodal = new bootstrap.Modal(document.getElementById("addNewModal")) ;
  mymodal.show();
}




