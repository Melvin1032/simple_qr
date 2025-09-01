<?php
include 'db.php';
require 'phpqrcode/qrlib.php'; // include the library

function generateUniqueCode($conn) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    $length = 5;

    do {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // check if code exists in DB
        $check = $conn->prepare("SELECT id FROM issued_equipment WHERE unique_code = ?");
        $check->bind_param("s", $code);
        $check->execute();
        $check->store_result();
    } while ($check->num_rows > 0);

    return $code;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_name = $_POST['equipment_name'];
    $serial_no = $_POST['serial_no'];
    $issued_to = $_POST['issued_to'];
    $issued_date = date("Y-m-d");

    // generate unique 5-char code
    $unique_code = generateUniqueCode($conn);

    // Insert record first with unique_code
    $stmt = $conn->prepare("INSERT INTO issued_equipment (equipment_name, serial_no, issued_to, issued_date, qr_code, unique_code) VALUES (?,?,?,?, '', ?)");
    $stmt->bind_param("sssss", $equipment_name, $serial_no, $issued_to, $issued_date, $unique_code);
    $stmt->execute();
    $last_id = $stmt->insert_id;

    // QR will now store the unique 5-character code
    $qrData = $unique_code;
    $qrFile = "qrcodes/equipment_" . $last_id . ".png";

    QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 5);

    // Update DB with qr_code path
    $conn->query("UPDATE issued_equipment SET qr_code='$qrFile' WHERE id=$last_id");

    echo "<div class='alert alert-success text-center'>✅ Equipment Registered! Code: <b>$unique_code</b></div>";
    echo "<div class='text-center'><img src='$qrFile' alt='QR Code'></div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register Equipment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

<div class="container">
  <div class="card shadow p-4">
    <h2 class="mb-4">Register Equipment</h2>
    <form method="post">
        <div class="mb-3">
          <label class="form-label">Equipment Name:</label>
          <input type="text" name="equipment_name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Serial No:</label>
          <input type="text" name="serial_no" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Issued To:</label>
          <input type="text" name="issued_to" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>
</div>

</body>
</html>
