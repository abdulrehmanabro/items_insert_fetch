<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

  // Get form data (add validation if needed)
  $productName = $_POST["productName"];
  $productPrice = $_POST["productPrice"];
  $productDescription = $_POST["productDescription"];

  // File upload handling
  if ($_FILES["productPicture"]["error"] === UPLOAD_ERR_OK) {
    $targetDir = "C:/xampp/htdocs/obpanel/pictures/";
    $targetFile = $targetDir . basename($_FILES["productPicture"]["name"]);

    // Move the uploaded file to the target directory
    // Check if the file was successfully uploaded to the server
if (move_uploaded_file($_FILES["productPicture"]["tmp_name"], $targetFile)) {
  // If the file was moved successfully, set the $productPicture variable to the target file path
  $productPicture = $targetFile;
} else {
  // If there was an error moving the file, display an error message and exit the script
  echo "Error uploading file.";
  exit;
}


  // Prepare and execute the SQL query to insert data using prepared statement
  $stmt = $conn->prepare("INSERT INTO `items` (productName, productPrice, productDescription, productPicture) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $productName, $productPrice, $productDescription, $productPicture);
  
  if ($stmt->execute()) {
    echo "Product added successfully!";
  } else {
    echo "Error: " . $conn->error;
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
  header("location:index.php");
  }}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
</head>
<body>
<div class="container">
  <h1>Add Product</h1>
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="productName">Product Name</label>
      <input type="text" id="productName" name="productName" required>
    </div>
    <div class="form-group">
      <label for="productPrice">Product Price</label>
      <input type="number" id="productPrice" name="productPrice" required>
    </div>
    <div class="form-group">
      <label for="productDescription">Product Description</label>
      <textarea id="productDescription" name="productDescription" required></textarea>
    </div>
    <div class="form-group">
      <label for="productPicture">Product Picture</label>
      <input type="file" id="productPicture" name="productPicture" accept="image/*" required>
    </div>
    <button type="submit">Submit</button>
  </form>
</div>

</body>
</html>

