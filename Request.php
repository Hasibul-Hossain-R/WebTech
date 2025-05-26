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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eaf4fc;
            margin: 0;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        #data {
            color: red;
            margin-bottom: 15px;
        }

        form {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 750px;
        }

        .city-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .city-card {
            background-color: #f1f9ff;
            border: 2px solid transparent;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 500;
        }

        .city-card input[type="checkbox"] {
            display: none;
        }

        .city-card.checked {
            background-color: #3498db;
            color: white;
            border-color: #2980b9;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            width: 100%;
            max-width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Select up to 10 Cities for AQI Report</h1>
    <p id="data"></p>

    <form action="showaqi.php" method="post" target="_blank" onsubmit="return validate()">
        <div class="city-grid">
            <?php
                $sql = "SELECT DISTINCT city FROM info LIMIT 20";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $city = htmlspecialchars($row['city']);
                        echo "
                            <label class='city-card'>
                                $city
                                <input type='checkbox' name='cities[]' value='$city'>
                            </label>
                        ";
                    }
                } else {
                    echo "<p>No cities found.</p>";
                }

                $conn->close();
            ?>
        </div>
        <input type="submit" name="submit" value="Submit">
    </form>

    <script>
        const cards = document.querySelectorAll('.city-card');
        const message = document.getElementById('data');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const checkbox = card.querySelector('input[type="checkbox"]');
                const checkedCount = document.querySelectorAll("input[type='checkbox']:checked").length;

                if (!checkbox.checked && checkedCount >= 10) {
                    message.textContent = "❗ You can select at most 10 cities.";
                    return;
                }

                checkbox.checked = !checkbox.checked;
                card.classList.toggle('checked', checkbox.checked);
                message.textContent = "";
            });
        });

        function validate() {
            const checked = document.querySelectorAll("input[type='checkbox']:checked").length;

            if (checked === 0) {
                message.textContent = "❗ Please select at least one city.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
