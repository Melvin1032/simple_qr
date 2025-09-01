<?php 
include 'db.php'; 
$result = $conn->query("SELECT * FROM issued_equipment ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Equipment Records</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">🏷 Equipment System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="register.php">📝 Register Equipment</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php">📷 Scan QR Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="records.php">📑 Records</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h2 class="text-center mb-4">📑 Registered Equipment Records</h2>

  <div class="card shadow">
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Equipment Name</th>
            <th>Owner</th>
            <th>QR Code</th>
            <th>Date Registered</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['equipment_name']; ?></td>
            <td><?php echo $row['issued_to']; ?></td>
            <td>
              <img src="<?php echo $row['qr_code']; ?>" width="80" alt="QR">
            </td>
            <td><?php echo $row['issued_date']; ?></td>
            <td>
              <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">View</a>
              <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
