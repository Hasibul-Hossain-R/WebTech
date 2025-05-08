<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];
    $dob = $_POST["dob"];
    $country = $_POST["country"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "Not specified";
    $color = $_POST["color"];
    $description = $_POST["description"];
    $terms = isset($_POST["terms"]) ? "Agreed" : "Not Agreed";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Registration Summary</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f2f2f2;
    }
    .container {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      width: 500px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    h2 {
      text-align: center;
      color: #333;
    }
    p {
      font-size: 16px;
      margin: 10px 0;
    }
    .buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    button {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .confirm {
      background-color: #4CAF50;
      color: white;
    }
    .back {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Confirm Your Information</h2>
    <p><strong>Full Name:</strong> <?= htmlspecialchars($fullname) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($dob) ?></p>
    <p><strong>Country:</strong> <?= htmlspecialchars($country) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
    <p><strong>Selected Color:</strong> <span style="background-color: <?= htmlspecialchars($color) ?>; padding: 0 10px;"><?= htmlspecialchars($color) ?></span></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($description)) ?></p>
    <p><strong>Terms and Conditions:</strong> <?= $terms ?></p>

    <div class="buttons">
      <form action="confirmation.php" method="post">
        <!-- Hidden inputs to pass data -->
        <input type="hidden" name="fullname" value="<?= htmlspecialchars($fullname) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="dob" value="<?= htmlspecialchars($dob) ?>">
        <input type="hidden" name="country" value="<?= htmlspecialchars($country) ?>">
        <input type="hidden" name="gender" value="<?= htmlspecialchars($gender) ?>">
        <input type="hidden" name="color" value="<?= htmlspecialchars($color) ?>">
        <input type="hidden" name="description" value="<?= htmlspecialchars($description) ?>">
        <input type="hidden" name="terms" value="<?= $terms ?>">
        <button type="submit" class="confirm">Confirm</button>
      </form>

      <button onclick="history.back()" class="back">Back</button>
    </div>
  </div>
</body>
</html>
