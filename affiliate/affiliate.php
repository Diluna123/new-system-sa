<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Affiliates - Sanasa Easy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(135deg, #e0f2f7, #bbdefb);
      color: #333;
    }
    .sidebar {
      min-height: 100vh;
      background-color: #007bff;
      color: #fff;
    }
    .sidebar a {
      color: #fff;
      padding: 15px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #0056b3;
    }
    .table-dark {
      background-color: #1f1f1f;
    }
    .table-dark thead th, .table-dark tbody td {
      color: #ddd;
    }
    .table-dark tbody tr:hover {
      background-color: #2d2d2d;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    @media (max-width: 768px) {
      #sidebarMenu {
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100vh;
        background-color: #007bff;
        z-index: 1050;
        transition: left 0.3s ease;
      }
      #sidebarMenu.show {
        left: 0;
      }
      .overlay {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1049;
        display: none;
      }
      .overlay.show {
        display: block;
      }
      .menu-toggle, .sidebar .close-btn {
        font-size: 1.5rem;
        cursor: pointer;
        display: block;
      }
    }
  </style>
</head>
<body>
  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
  <div class="container-fluid">
    <div class="row">
      <!-- Toggle for mobile -->
      <div class="d-md-none p-3">
        <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
      </div>

      <!-- Sidebar -->
      <nav id="sidebarMenu" class="col-md-2 sidebar d-md-block">
        <div class="p-3">
          <div class="d-md-none close-btn text-white text-end" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
          </div>
          <h4 class="text-white text-center mb-4">Affiliate Admin</h4>
          <a href="afDashboard.php">Dashboard</a>
          <a href="affiliates.html" class="fw-bold">Affiliates</a>
          <a href="#">Commissions</a>
          <a href="#">Payouts</a>
          <a href="#">Settings</a>
        </div>
      </nav>

      <!-- Main -->
      <main class="col-md-10 ms-sm-auto px-md-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Affiliates</h2>
          <!-- Add New Business Button -->
          <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addBusinessModal">
            <i class="fas fa-plus me-2"></i>Add New Business
          </button>
        </div>

        <div class="mb-4">
          <input type="text" class="form-control form-control-lg" placeholder="Search affiliates by name or email...">
        </div>

        <div class="table-responsive">
          <table class="table table-dark table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Status</th>
                <th>Total Earnings</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#001</td>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>2025-04-01</td>
                <td><span class="badge bg-success">Active</span></td>
                <td>$850</td>
              </tr>
              <tr>
                <td>#002</td>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>2025-04-10</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
                <td>$300</td>
              </tr>
              <tr>
                <td>#003</td>
                <td>Michael Brown</td>
                <td>michael@example.com</td>
                <td>2025-04-15</td>
                <td><span class="badge bg-danger">Banned</span></td>
                <td>$0</td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  <!-- Add Business Modal -->
  <div class="modal fade" id="addBusinessModal" tabindex="-1" aria-labelledby="addBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title" id="addBusinessModalLabel">Add New Business</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="businessName" class="form-label">Business Name</label>
              <input type="text" class="form-control" id="businessName" required>
            </div>
            <div class="mb-3">
              <label for="ownerEmail" class="form-label">Owner Email</label>
              <input type="email" class="form-control" id="ownerEmail" required>
            </div>
            <div class="mb-3">
              <label for="joinedDate" class="form-label">Joined Date</label>
              <input type="date" class="form-control" id="joinedDate" required>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" required>
                <option value="Active">Active</option>
                <option value="Pending">Pending</option>
                <option value="Banned">Banned</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Business</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebarMenu');
      const overlay = document.getElementById('overlay');
      sidebar.classList.toggle('show');
      overlay.classList.toggle('show');
    }
  </script>
</body>
</html>
