<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>QR Scanner Dashboard</title>
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
  <h2 class="text-center mb-4">📋 QR Scanner Dashboard</h2>

  <!-- Scan Input -->
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form id="scanForm">
        <input type="text" id="qr_input" class="form-control form-control-lg text-center" 
               placeholder="Scan QR Code here..." autofocus>
      </form>
    </div>
  </div>

  <!-- Result Display -->
  <div class="row justify-content-center mt-4">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">Equipment Info</div>
        <div class="card-body" id="result">
          <p class="text-muted">Scan a QR code to see details here...</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById("scanForm").addEventListener("submit", function(e){
    e.preventDefault();

    let scannedValue = document.getElementById("qr_input").value;

    // If scanner gives full URL (like view.php?id=1)
    if(scannedValue.includes("view.php?id=")){
        fetch(scannedValue)
          .then(response => response.text())
          .then(data => {
              document.getElementById("result").innerHTML = data;
          });
    } 
    // If scanner gives only an ID (like "1")
    else {
        fetch("view.php?id=" + scannedValue)
          .then(response => response.text())
          .then(data => {
              document.getElementById("result").innerHTML = data;
          });
    }

    // Clear the input for next scan
    document.getElementById("qr_input").value = "";
});
</script>

</body>
</html>
