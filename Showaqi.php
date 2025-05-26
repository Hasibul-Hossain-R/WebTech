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
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>AQI Results</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background: #f4fbff;
                margin: 0;
                padding: 40px;
                display: flex;
                justify-content: center;
                align-items: flex-start;
            }

            .container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                width: 90%;
                max-width: 700px;
            }

            h2 {
                text-align: center;
                color: #2c3e50;
                margin-bottom: 25px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th, td {
                padding: 12px 15px;
                border: 1px solid #ccc;
                text-align: center;
            }

            th {
                background-color: #3498db;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            tr:hover {
                background-color: #ecf7ff;
            }

            .aqi {
                font-weight: bold;
                padding: 5px 10px;
                border-radius: 5px;
                display: inline-block;
            }

            .good    { background: #8bc34a; color: #fff; }
            .moderate { background: #ffc107; color: #000; }
            .unhealthy { background: #f44336; color: #fff; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>AQI Results</h2>
            <table>
                <tr>
                    <th>City</th>
                    <th>Country</th>
                    <th>AQI</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $aqi = (int)$row['aqi'];
                    $class = 'good';
                    if ($aqi > 100 && $aqi <= 200) {
                        $class = 'moderate';
                    } elseif ($aqi > 200) {
                        $class = 'unhealthy';
                    }
                    echo "<tr>
                            <td>" . htmlspecialchars($row['city']) . "</td>
                            <td>" . htmlspecialchars($row['country']) . "</td>
                            <td><span class='aqi $class'>{$row['aqi']}</span></td>
                          </tr>";
                }
                ?>
            </table>
        </div>
    </body>
    </html>

    <?php
    $stmt->close();
    $conn->close();
} else {
    echo "<h2 style='text-align: center; color: red;'>❌ No cities selected.</h2>";
}
?>
