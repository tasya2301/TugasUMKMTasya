<?php
session_start();
include 'koneksi.php';

// Cek admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// --- Update Status Pesanan ---
if (isset($_GET['aksi']) && $_GET['aksi'] === 'update') {
    if (isset($_GET['id']) && isset($_GET['status'])) {
        $id = intval($_GET['id']);
        $status = mysqli_real_escape_string($conn, $_GET['status']);
        mysqli_query($conn, "UPDATE tb_orders SET status='$status' WHERE id=$id");
        header("Location: orders.php?msg=success");
        exit;
    }
}

// --- Ambil Data Pesanan ---
$query = mysqli_query($conn, "SELECT * FROM tb_orders ORDER BY tanggal_order DESC");
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <title>Kelola Pesanan</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    <!-- HEADER NAVBAR -->
      <header
      class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow"
      data-bs-theme="dark"
    >
      <a
        class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white"
        href="#"
        >Company name</a
      >
      <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
          <button
            class="nav-link px-3 text-white"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSearch"
            aria-controls="navbarSearch"
            aria-expanded="false"
            aria-label="Toggle search"
          >
            <svg class="bi" aria-hidden="true">
              <use xlink:href="#search"></use>
            </svg>
          </button>
        </li>
        <li class="nav-item text-nowrap">
          <button
            class="nav-link px-3 text-white"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <svg class="bi" aria-hidden="true">
              <use xlink:href="#list"></use>
            </svg>
          </button>
        </li>
      </ul>
      <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input
          class="form-control w-100 rounded-0 border-0"
          type="text"
          placeholder="Search"
          aria-label="Search"
        />
      </div>
    </header>
    <div class="container-fluid">
      <div class="row">
        <div
          class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary"
        >
          <div
            class="offcanvas-md offcanvas-end bg-body-tertiary"
            tabindex="-1"
            id="sidebarMenu"
            aria-labelledby="sidebarMenuLabel"
          >
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="sidebarMenuLabel">
                Company name
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                data-bs-target="#sidebarMenu"
                aria-label="Close"
              ></button>
            </div>
            <div
              class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto"
            >
              <ul class="nav flex-column">
                <li class="nav-item">
                   <a class="nav-link d-flex align-items-center gap-2" href="dashboard.php">
                    <svg class="bi" aria-hidden="true">
                      <use xlink:href="#house-fill"></use>
                    </svg>
                    Dashboard
                  </a>
                </li>

                  <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="customers.php">
                    <svg class="bi" aria-hidden="true">
                      <use xlink:href="#people"></use>
                    </svg>
                    Customers
                  </a>
                </li>
             
                
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="orders.php">
                    <svg class="bi" aria-hidden="true">
                      <use xlink:href="#file-earmark"></use>
                    </svg>
                    Orders
                  </a>
                </li>
              
              
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="logout.php">
                    <svg class="bi" aria-hidden="true">
                     <use xlink:href="#door-closed"></use>
                    </svg>
                 Log Out
                  </a>
                </li>
              </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi" aria-hidden="true">
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
   
            
            
      
        <!-- MAIN CONTENT -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h2>Daftar Pesanan</h2>
          </div>

          <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success') { ?>
            <div class="alert alert-success">✅ Status pesanan berhasil diperbarui!</div>
          <?php } ?>

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Telepon</th>
                  <th>Alamat</th>
                  <th>Tanggal</th>
                  <th>Total</th>
               
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                  <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['telepon']); ?></td>
                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                    <td><?= $row['tanggal_order']; ?></td>
                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    <td>
                    </td>
                
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>feather.replace()</script>
  </body>
</html>
