<?php include 'auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Smart Inventory</title>
  <?php include 'head.php'; ?>
</head>
<body>
  <div class="container-scroller">
    <?php include 'navBar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-view-list menu-icon"></i>
              </span>
              Inventory Management
            </h3>
          </div>
          <div class="container">
            <h2 class="mt-4">Add New Inventory Item</h2>
            <form action="add_item.php" method="POST">
              <div class="form-group mt-2">
                <label for="itemName">Item Name</label>
                <input type="text" name="itemName" id="itemName" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="supplierID">Supplier ID</label>
                <input type="number" name="supplierID" id="supplierID" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary mt-3">Add Item</button>
            </form>
          </div>
          <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $itemName = mysqli_real_escape_string($con, $_POST['itemName']);
            $category = mysqli_real_escape_string($con, $_POST['category']);
            $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
            $location = mysqli_real_escape_string($con, $_POST['location']);
            $price = mysqli_real_escape_string($con, $_POST['price']);
            $supplierID = mysqli_real_escape_string($con, $_POST['supplierID']);
            $last_updated = date('Y-m-d H:i:s');

            // Check if SupplierID exists
            $supplierCheckQuery = "SELECT SupplierID FROM supplier WHERE SupplierID = '$supplierID'";
            $supplierCheckResult = mysqli_query($con, $supplierCheckQuery);

            if (mysqli_num_rows($supplierCheckResult) > 0) {
              // SupplierID exists, proceed with insertion
              $query = "INSERT INTO InventoryItem (ItemName, Category, Quantity, Location, Price, SupplierID, UpdatedAt) VALUES ('$itemName', '$category', '$quantity', '$location', '$price', '$supplierID', '$last_updated')";
              
              if (mysqli_query($con, $query)) {
                echo "<script>alert('Item added successfully!'); window.location.href = 'inventory.php';</script>";
              } else {
                echo "<script>alert('Error adding item: " . mysqli_error($con) . "');</script>";
              }
            } else {
              // SupplierID does not exist, show error message
              echo "<script>alert('Error: Supplier ID does not exist.');</script>";
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>
</html>
