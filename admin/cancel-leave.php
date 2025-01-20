<?php 

$id = $_GET["id"];

require_once "../connection.php";

$sql = "UPDATE emp_leave SET status = 'Rejected' WHERE id = '$id' ";
$result = mysqli_query($conn , $sql);
if($result){
    header("Location: manage-leave.php?reject-successfuly");
}

?>