<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php
include 'connection.php';
?>
<head>
  <script src="/assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.122.0">
  <title>Sanasa Easy</title>
  <link rel="icon" type="image/png" href="sansalogo.png">

  <!-- Core CSS -->
  <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="css/border.css">

  <!-- Icons and Extras -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
  <!-- Bootstrap CSS & Icons (make sure included in layout) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Styles -->
  <style>
    .card-body {
      min-height: 80px;
    }

    .accordion-button {
      font-weight: 500;
    }

    <style>.table thead th {
      vertical-align: middle;
      text-align: center;
      background-color: #1f1f1f !important;
      color: #fff;
      border-color: #2a2a2a;
    }

    .table tbody td,
    .table tbody th {
      vertical-align: middle;
      text-align: center;
      border-color: #333;
      color: #e0e0e0;
    }

    .table tbody tr {
      transition: all 0.2s ease-in-out;
      cursor: pointer;
    }

    .table tbody tr:hover {
      background-color: #2c2c2c;
      transform: scale(1.01);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .badge {
      font-size: 0.85rem;
      padding: 0.4em 0.7em;
      border-radius: 0.6rem;
    }

    .table-container {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
      background-color: #121212;
      padding: 20px;
    }

    .no-data-message {
      color: #999;
      font-size: 1.1rem;
      padding: 20px;
      text-align: center;
    }
    .hover-card {
  transition: all 0.3s ease;
  background-color: #1c1c1c;
}
.hover-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(255, 193, 7, 0.2);
}
.icon-circle {
  width: 60px;
  height: 60px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
}

  </style>




</head>

<body>
  <?php
  session_start();

  if (isset($_SESSION['user'])) {
    include 'logos.php';
  ?>

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">SANASA LIFE</a>
      <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
          <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch">
            <i class="bi bi-search"></i>
          </button>
        </li>
        <li class="nav-item text-nowrap">
          <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <i class="bi bi-list"></i>
          </button>
        </li>
      </ul>
      <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">
        <?php include 'sideMenu.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 text-light">
      <i class="bi bi-cake2 me-2 text-warning"></i> Upcoming Birthdays
    </h1>
  </div>

  <div class="row g-4">
    <?php
    date_default_timezone_set('Asia/Colombo');

    $today = date('m-d');
    $nextMonth = date('m-d', strtotime('+30 days'));

    $bdate = Database::search("
      SELECT 
        c.fname, 
        c.lname,
        c.dob,
        c.contact
      FROM customers AS c
      INNER JOIN police_t AS p 
        ON c.id = p.customers_id
      WHERE DATE_FORMAT(c.dob, '%m-%d') 
        BETWEEN '$today' AND '$nextMonth'
        AND p.status_s_id = 1 
        AND p.users_u_id = {$_SESSION['user']['u_id']}
      ORDER BY DATE_FORMAT(c.dob, '%m-%d') ASC
    ");

    if ($bdate->num_rows > 0) {
      while ($row = $bdate->fetch_assoc()) {
        $name = $row['fname'];
        $lname = $row['lname'];
        $fullName = $name . ' ' . $lname;
        $phone = preg_replace('/\D/', '', $row['contact']); // remove non-digits
$phone = preg_replace('/^0/', '', $phone); // remove leading 0
// sanitize phone
        $bday = date('F j', strtotime($row['dob']));

        $nextBirthday = strtotime(date('Y') . '-' . date('m-d', strtotime($row['dob'])));
        if ($nextBirthday < time()) {
          $nextBirthday = strtotime('+1 year', $nextBirthday);
        }
        $daysLeft = ceil(($nextBirthday - time()) / 86400);

        if ($daysLeft <= 3) {
          $badgeClass = 'bg-danger';
          $badgeText = "In $daysLeft day" . ($daysLeft > 1 ? 's' : '') . " 🎂";
        } elseif ($daysLeft <= 10) {
          $badgeClass = 'bg-warning text-dark';
          $badgeText = "Soon - $daysLeft days";
        } else if ($daysLeft == 365 || $daysLeft == 366) {
          $badgeClass = 'bg-success';
          $badgeText = "Today! 🎉";
        } else {
          $badgeClass = 'bg-primary';
          $badgeText = "In $daysLeft days";
        }

        // Personalized wish
        $wishMessage = "Happy Birthday, $fullName! 🎉 Wishing you a day filled with love, laughter, and happiness. From all of us at Sanasa Life Madampe Branch 💛";
    ?>
        <div class="col-md-4 col-sm-6">
          <div class="card border-0 rounded-4 shadow-sm bg-dark-subtle hover-card"
               onclick="openWishModal('<?php echo htmlspecialchars($fullName); ?>',
                                      '<?php echo $bday; ?>',
                                      '<?php echo htmlspecialchars($wishMessage); ?>',
                                      '<?php echo $phone; ?>')">
            <div class="card-body text-center">
              <div class="icon-circle mb-3">
                <i class="bi bi-person-circle fs-2 text-warning"></i>
              </div>
              <h5 class="fw-bold text-light mb-1"><?php echo htmlspecialchars($fullName); ?></h5>
              <p class="text-secondary mb-2">
                <i class="bi bi-calendar-event me-1"></i> <?php echo $bday; ?>
              </p>
              <span class="badge <?php echo $badgeClass; ?> fw-semibold">
                <?php echo $badgeText; ?>
              </span>
            </div>
          </div>
        </div>
    <?php
      }
    } else {
      echo '<div class="no-data-message">🎉 No upcoming birthdays in the next 30 days.</div>';
    }
    ?>
  </div>
</main>
<!-- Birthday Wish Modal -->
<div class="modal fade" id="wishModal" tabindex="-1" aria-labelledby="wishModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light border-0 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="wishModalLabel">
          <i class="bi bi-chat-heart text-warning me-2"></i> Send Birthday Wish
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <h5 id="modalName" class="text-warning mb-2"></h5>
        <p id="modalDate" class="text-secondary mb-3"></p>
        <textarea id="wishText" class="form-control bg-dark text-light border-secondary rounded-3" rows="4"></textarea>
      </div>
      <div class="modal-footer border-0">
        <button class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
        <button id="sendWishBtn" class="btn btn-warning fw-semibold">
          <i class="bi bi-send me-1"></i> Send Message
        </button>
      </div>
    </div>
  </div>
</div>




      </div>
    </div>

    <div class="mt-5">
      <?php include 'footer.php'; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="dashboard.js"></script>
    <script>
// Open modal and set data dynamically
function openWishModal(name, date, message, phone) {
  document.getElementById("modalName").textContent = name;
  document.getElementById("modalDate").textContent = date;
  document.getElementById("wishText").value = message;
  document.getElementById("sendWishBtn").setAttribute("data-phone", phone);

  const modal = new bootstrap.Modal(document.getElementById("wishModal"));
  modal.show();
}

// Send WhatsApp message
document.getElementById("sendWishBtn").addEventListener("click", function () {
  const message = document.getElementById("wishText").value.trim();
  const phone = this.getAttribute("data-phone");

  if (!phone) {
    Swal.fire({
      icon: "error",
      title: "No Contact Info",
      text: "No phone number found for this customer.",
      confirmButtonColor: "#ffc107"
    });
    return;
  }

  if (message === "") {
    Swal.fire({
      icon: "warning",
      title: "Empty Message",
      text: "Please type your birthday wish before sending.",
      confirmButtonColor: "#ffc107"
    });
    return;
  }

  const encodedMessage = encodeURIComponent(message);
  const whatsappURL = `https://wa.me/${phone}?text=${encodedMessage}`;
  window.open(whatsappURL, "_blank");

  Swal.fire({
    icon: "success",
    title: "Redirecting to WhatsApp!",
    text: "You can now send your birthday wish.",
    confirmButtonColor: "#ffc107",
    timer: 2000,
    showConfirmButton: false
  });

  const modal = bootstrap.Modal.getInstance(document.getElementById("wishModal"));
  modal.hide();
});
</script>

<script>
  // When a card is clicked, fill the modal
  const wishModal = document.getElementById('wishModal');
  wishModal.addEventListener('show.bs.modal', event => {
    const card = event.relatedTarget;
    const name = card.getAttribute('data-name');
    const date = card.getAttribute('data-date');
    const message = card.getAttribute('data-message');

    document.getElementById('modalName').textContent = name;
    document.getElementById('modalDate').textContent = "Birthday: " + date;
    document.getElementById('wishText').value = message;
  });

  // Handle "Send Message" button
  document.getElementById('sendWishBtn').addEventListener('click', () => {
    const name = document.getElementById('modalName').textContent;
    const message = document.getElementById('wishText').value;

    // Example: Show success alert (later you can replace with actual API)
    Swal.fire({
      icon: 'success',
      title: 'Message Sent!',
      text: `Your birthday wish to ${name} has been sent successfully.`,
      confirmButtonColor: '#ffc107'
    });

    // Hide modal
    const modal = bootstrap.Modal.getInstance(wishModal);
    modal.hide();

    // Optional: Send message via backend AJAX
    /*
    $.post('send_message.php', { name, message }, function(res) {
      console.log(res);
    });
    */
  });
</script>



  <?php } else { ?>
    <script>
      window.location.href = "login.php";
    </script>
  <?php } ?>

</body>

</html>