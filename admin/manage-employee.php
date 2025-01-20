<?php 
require_once "include/header.php";
require_once "../connection.php"; 
?>

<style>
    table, th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th {
        background-color: #343a40;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .modal-body img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
    }

    .modal-body p {
        margin: 5px 0;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-footer .btn {
        background-color: #28a745;
        color: white;
    }

    .btn-info, .btn-primary, .btn-danger {
        font-size: 14px;
        padding: 8px 12px;
    }

    #search-bar {
        margin-bottom: 20px;
        padding: 10px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .pagination {
    margin-top: 20px; 
}

</style>

<div class="container bg-white shadow rounded-lg">
    <div class="py-4 mt-5">
        <div class="text-center pb-2">
            <h4>Manage Employees</h4>
        </div>
        <input type="text" id="search-bar" placeholder="Search employees by employee id, name, email, gender, and department..." />

        <div id="employee-table">
            <!-- Table and Pagination will be dynamically loaded here -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function loadTable(page = 1, query = "") {
            $.ajax({
                url: "fetch_employees.php",
                method: "GET",
                data: { page: page, search: query },
                success: function(data) {
                    $("#employee-table").html(data);
                }
            });
        }        // Initial table load
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
