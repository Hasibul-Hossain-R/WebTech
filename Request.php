<?php
session_start();

$conn = new mysqli("localhost", "root", "", "AQI");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AQI Form</title>
</head>
<body>
    <h1>Select Cities for AQI Report</h1>
    <p id="data"></p>

    <!-- Submit opens new tab -->
    <form action="showaqi.php" method="post" target="_blank" onsubmit="return validate()">
        <?php
            $sql = "SELECT DISTINCT city FROM info LIMIT 20";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $city = htmlspecialchars($row['city']);
                    echo "$city <input type='checkbox' name='cities[]' value='$city'><br>";
                }
            } else {
                echo "No cities found.";
            }

            $conn->close();
        ?>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <script>
    function validate() {
        const checkboxes = document.querySelectorAll("input[type='checkbox']:checked");
        const count = checkboxes.length;
        const message = document.getElementById('data');

        if (count !== 10) {
            message.textContent = "❗ Please select exactly 10 cities.";
            return false;
        }

        message.textContent = "";
        return true;
    }
</script>

</body>
</html>