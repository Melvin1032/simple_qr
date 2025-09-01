<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM issued_equipment WHERE id=$id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Equipment Details</h2>";
        echo "Equipment: " . $row['equipment_name'] . "<br>";
        echo "Serial No: " . $row['serial_no'] . "<br>";
        echo "Issued To: " . $row['issued_to'] . "<br>";
        echo "Issued Date: " . $row['issued_date'] . "<br>";
    } else {
        echo "No record found!";
    }
}
?>
