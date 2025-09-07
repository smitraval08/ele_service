<?php
include("Datastore.php");
if($_SESSION['role'] != 'customer'){
    header("Location: login.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user_id = $_SESSION['user_id'];
    $complaint_text = $_POST['complaint_text'];
    $address = $_POST['address'];

    $stmt = $con->prepare("INSERT INTO complaints (user_id, complaint_text, address) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $complaint_text, $address);
    if($stmt->execute()){
        header("Location: Thankyou.php");
        exit();
    } else {
        echo "Error: ".$stmt->error;
    }
}
?>
