<?php 
    require_once "include/header.php";
?>

<?php 
// Database connection
require_once "../connection.php";

// SQL query to get accepted leaves
$accepted_sql = "SELECT * FROM emp_leave WHERE status = 'accepted' ";
$accepted_result = mysqli_query($conn , $accepted_sql);

// SQL query to get rejected leaves
$rejected_sql = "SELECT * FROM emp_leave WHERE status = 'rejected' ";
$rejected_result = mysqli_query($conn , $rejected_sql);

$i = 1;
?>

<style>
    table, th, td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: center;
    }
    table {
        width: 100%;
        border-spacing: 10px;
    }
    th {
        background-color: #343a40;
        color: white;
    }
    .container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .no-results {
        text-align: center;
        color: #777;
        font-size: 18px;
    }
    .pagination {
        justify-content: center;
    }
    .btn-white {
        background-color: white;
        color: #007bff;
        border: 1px solid #007bff;
        font-size: 14px;
        padding: 8px 12px;
    }
    #search-bar {
        margin-bottom: 20px;
        padding: 10px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }
    .pagination {
    margin-top: 20px; 
}

</style>

<div class="container py-4 mt-5">
    <div class="text-center pb-1">
        <h4>Accepted Leave Requests</h4>
        <input type="text" id="search-bar" placeholder="Search by email, reason, and specific date in mm-dd-yyyy format..." />
    </div>

    <div id="leave-table">
        <!-- Table content will be dynamically loaded here -->
    </div>

</div>

<script>
    $(document).ready(function() {
        function loadTable(page = 1, query = "") {
            $.ajax({
                url: "fetch_leaves.php",
                method: "GET",
                data: { page: page, search: query },
                success: function(data) {
                    $("#leave-table").html(data);
                }
            });
        }

        // Initial table load
        loadTable();

        // Search as you type
        $("#search-bar").on("input", function() {
            const query = $(this).val();
            loadTable(1, query);
        });

        // Pagination click event
        $(document).on("click", ".page-link", function(e) {
            e.preventDefault();
            const page = $(this).data("page");
            const query = $("#search-bar").val();
            loadTable(page, query);
        });
    });
</script>

<?php 
    require_once "include/footer.php";
?>
