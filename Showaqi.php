<?php
if (isset($_POST['submit']) && isset($_POST['cities'])) {
    $conn = new mysqli("localhost", "root", "", "AQI");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $cities = $_POST['cities'];
    $placeholders = implode(",", array_fill(0, count($cities), "?"));

    $stmt = $conn->prepare("SELECT city, country, aqi FROM info WHERE city IN ($placeholders)");
    $types = str_repeat("s", count($cities));
    $stmt->bind_param($types, ...$cities);
    $stmt->execute();

    $result = $stmt->get_result();

    echo "<h2>AQI Results</h2>";
    echo "<table border='1'><tr><th>City</th><th>Country</th><th>AQI</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['city']}</td><td>{$row['country']}</td><td>{$row['aqi']}</td></tr>";
    }
    echo "</table>";

    $stmt->close();
    $conn->close();
} else {
    echo "No cities selected.";
}
?>