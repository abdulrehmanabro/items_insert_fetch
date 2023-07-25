<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Products</title>
  <style>
    /* Add some basic styling */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .product {
      border: 1px solid #ddd;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    .product h2 {
      margin: 0;
      font-size: 24px;
      color: #333;
    }
    .product p {
      margin: 10px 0;
      font-size: 16px;
      color: #555;
    }
    .product img {
      max-width: 100%;
      max-height: 200px;
      display: block;
      margin: 0 auto;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>View Products</h1>
    <?php
      // Database credentials
      $servername = "localhost:3307";
      $username = "root";
      $password = "";
      $dbname = "add_items";

      // Create a database connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Retrieve data from the database
      $sql = "SELECT * FROM items";
      $result = $conn->query($sql);

      // Check if there are any records in the database
      if ($result->num_rows > 0) {
        // Loop through the records and display them
        while ($row = $result->fetch_assoc()) {
          echo '<div class="product">';
          echo '<h2>' . $row["productName"] . '</h2>';
          echo '<p>Price: $' . $row["productPrice"] . '</p>';
          echo '<p>Description: ' . $row["productDescription"] . '</p>';
          echo '<img src="' . $row["productPicture"] . '" alt="' . $row["productName"] . '">';
          echo '</div>';
        }
      } else {
        echo '<p>No products found.</p>';
      }

      // Close the database connection
      $conn->close();
    ?>
  </div>
</body>
</html>
