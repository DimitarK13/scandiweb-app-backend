<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");
  header("Access-Control-Allow-Methods: *");
  header("Access-Control-Allow-Origin: *");

  include 'DbConnect.php';
  $objDb = new DbConnect;
  $conn = $objDb->connect();

  $method = $_SERVER['REQUEST_METHOD'];
  
  switch($method) {
    case 'POST': 
      $product = json_decode(file_get_contents('php://input')); 
      $sql = 'INSERT INTO products(p_sku, p_name, p_price, p_value) VALUES (:p_sku, :p_name, :p_price, :p_value)';
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':p_sku', $product->sku);
      $stmt->bindParam(':p_name', $product->name);
      $stmt->bindParam(':p_price', $product->price);
      $stmt->bindParam(':p_value', $product->attr);
      if ($stmt->execute()) {
        $response = ['status' => 1, 'message' => 'Added successfully'];
      } else {
        $response = ['status' => 0, 'message' => 'Failed '];
      }
      echo json_encode($response);
      break;

    case 'GET': 
      $sql = 'SELECT * FROM products';
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($products);
      break;

    case 'DELETE': 
      $sql = 'DELETE FROM products WHERE p_sku = :sku';
      $path = explode('/', $_SERVER['REQUEST_URI']);
      print_r($path);

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':sku', $path[3]);

      if ($stmt->execute()) {
        $response = ['status' => 1, 'message' => 'Deleted successfully'];
      } else {
        $response = ['status' => 0, 'message' => 'Failed to delete'];
      }
      echo json_encode($response);
      break;
  }
?>
