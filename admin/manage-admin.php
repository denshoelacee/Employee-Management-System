<?php 
require_once "include/header.php";
?>

<?php 
// Database connection
require_once "../connection.php";

$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);

$i = 1;

?>

<style>
table, th, td {
    border: 1px solid black;
    padding: 15px;
}
table {
    border-spacing: 10px;
}
</style>

<div class="container bg-white shadow">
    <div class="py-4 mt-5"> 
        <div class='text-center pb-2'>
            <h4>Manage Admin</h4>
        </div>
        <table style="width:100%" class="table-hover text-center">
            <tr class="bg-dark text-white">
                <th>Order</th>
                <th>Name</th>
                <th>Email</th> 
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Action</th>
            </tr>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    $name = $rows["name"];
                    $email = $rows["email"];
                    $dob = $rows["dob"];
                    $gender = $rows["gender"];
                    $id = $rows["id"];

                    // Handle undefined gender
                    if ($gender == "") {
                        $gender = "Not Defined";
                    }

                    // Handle date of birth and age calculation
                    if ($dob == "") {
                        $formatted_dob = "Not Defined";
                        $age = "Not Defined";
                    } else {
                        $formatted_dob = date('jS F, Y', strtotime($dob)); 
                        $date1 = new DateTime($dob); 
                        $date2 = new DateTime("now");
                        $diff = $date1->diff($date2);
                        $age = $diff->y . " Years"; 
                    }
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $email; ?></td>
                <td><?php echo $gender; ?></td>
                <td><?php echo $formatted_dob; ?></td>
                <td><?php echo $age; ?></td>
                <td>
                    <?php 
                    if ($email !== $_SESSION["email"]) {
                        $edit_icon = "<a href='edit-admin.php?id={$id}' class='btn-sm btn-primary float-right ml-3'> 
                                        <span><i class='fa fa-edit'></i></span> 
                                      </a>";
                        $delete_icon = "<a href='delete-admin.php?id={$id}' id='bin' class='btn-sm btn-primary float-right'> 
                                        <span><i class='fa fa-trash'></i></span> 
                                      </a>";
                        echo $edit_icon . $delete_icon;
                    } else {
                        echo "<a href='profile.php' class='btn btn-primary float-center'>Profile</a>";
                    } 
                    ?> 
                </td>
            </tr>
            <?php 
                    $i++;
                }
            } else {
                echo "<tr><td colspan='7'>No admin found</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php 
require_once "include/footer.php";
?>
