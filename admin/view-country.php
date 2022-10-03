<?php
include "../app/config.php";
include "../app/helper.php";
$page = $_GET['page'] ?? 0;
$limit = 25;
$offset = $page * $limit;

$search = $_GET['search'];
// 0 x 20 - 0
// 1 x 20 - 20
// 2 x 20 - 40
// 3 x 20 - 60
$msg = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $newstatus = $_GET['newstatus'];
    if (isset($newstatus)) {
        $qry = "UPDATE countries SET status = $newstatus WHERE id = $id";
        try {
            $flag = mysqli_query($conn, $qry);
        } catch (Exception $err) {
            $flag = false;
        }
        if ($flag == true) {
            $msg = "Status changed successfully";
        } else {
            $msg = "Unable to change the status";
        }
    } else {
        $qry = "DELETE FROM countries WHERE id = $id";
        try {
            $flag = mysqli_query($conn, $qry);
        } catch (Exception $err) {
            $flag = false;
        }
        if ($flag == true) {
            $msg = "Data deleted successfully";
        } else {
            $msg = "Unable to delete the data";
        }
    }
}

if (isset($_POST['del_all'])) {
    $ids = $_POST['ids'] ?? [];
    if (count($ids) > 0) {
        // First method
        foreach ($ids as $id) {
            $del = "DELETE FROM countries WHERE id = $id";
            mysqli_query($conn, $del);
        }
        // --------------
        // Second method
        // $idsString = implode(",", $ids); // convert array to string
        // $del = "DELETE FROM countries WHERE id IN ($idsString)";
        // mysqli_query($conn, $del);
        // ----------------
    }
}

include "common/header.php";
?>
<!-- Content Wrapper -->


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Search Name</h6>
        </div>
        <div class="card-body">
            <form action="view-country.php" method="get">
                <input type="text" class="form-control mb-2" name="search" value="<?php echo $search ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="view-country.php">
                    <button type="button" class="btn btn-warning">Clear</button>
                </a>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">View News</h6>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <button type="submit" class="btn btn-danger" name="del_all">Delete Selected</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="" id="main-check" />
                            </th>
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    if (isset($search)) {
                        $sel = "SELECT * FROM countries WHERE name LIKE '%$search%'";
                    } else {
                        $sel = "SELECT * FROM countries ORDER BY id DESC LIMIT $offset,$limit"; // step 1
                    }
                    // ASC - DES
                    echo $sel;
                    $exe = mysqli_query($conn, $sel); // step 2
                    // $fetch = mysqli_fetch_assoc($exe);
                    // p($fetch);
                    // SELECT <cols> FROM <table_name>
                    // <cols> - * (All Columns)
                    ?>
                    <tbody>
                        <?php
                        $sr = $offset + 1;
                        while ($fetch = mysqli_fetch_assoc($exe)) { // step 3
                        ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="<?php echo $fetch['id'] ?>" class="check-box" />
                                </td>
                                <td>
                                    <?php echo $sr ?>
                                </td>
                                <td>
                                    <?php echo $fetch['name'] ?>
                                </td>
                                <td>
                                    <?php
                                    if ($fetch['status'] == 1) {
                                    ?>
                                        <a href="view-country.php?id=<?php echo $fetch['id'] ?>&newstatus=0&page=<?php echo $page ?>">
                                            <button type="button" class="btn btn-success">Active</button>
                                        </a>
                                        <!-- Active -->
                                    <?php
                                    } else {
                                    ?>
                                        <a href="view-country.php?id=<?php echo $fetch['id'] ?>&newstatus=1&page=<?php echo $page ?>
                                    ">
                                            <button type="button" class="btn btn-warning">Inactive</button>
                                        </a>
                                        <!-- Inactive -->
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $fetch['created_at'] ?>
                                </td>
                                <td>
                                    <a href="add-country.php?id=<?php echo $fetch['id'] ?>">
                                        <i class="text-primary fa fa-pen"></i>
                                    </a>
                                    &nbsp;
                                    &nbsp;
                                    <a href="view-country.php?id=<?php echo $fetch['id'] ?>&page=<?php echo $page ?>">
                                        <!-- get request -->
                                        <i class="text-danger fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $sr++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            <?php
            if (!isset($search)) :
                $selAll = "SELECT count(*) as total from countries";
                $exeAll = mysqli_query($conn, $selAll);
                $fetchAll = mysqli_fetch_assoc($exeAll);
                // p($fetchAll);
                $total = $fetchAll['total'];
                // p($total);
                $totalPages = ceil($total / $limit);
                p($totalPages);
            ?>
                <div class="row">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="view-country.php?page=0" aria-label="Previous">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="view-country.php?page=<?php echo $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php
                            for ($p = 0; $p < $totalPages; $p++) :
                            ?>
                                <li class="page-item <?php echo $page == $p ? 'active' : '' ?>" aria-current="page">
                                    <a class="page-link" href="view-country.php?page=<?php echo $p ?>">
                                        <?php echo $p + 1; ?>
                                    </a>
                                </li>
                            <?php
                            endfor;
                            ?>
                            <!-- <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li> -->
                            <li class="page-item">
                                <a class="page-link" href="view-country.php?page=<?php echo $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="view-country.php?page=<?php echo $totalPages - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>

</div>

<!-- End of Main Content -->
<?php include "common/footer.php"; ?>
<?php
if ($msg != "") :
?>
    <script>
        showSnackbar("<?php echo $msg ?>", <?php echo $flag ?>)
    </script>
<?php
    $msg = "";
endif;
?>
<script>
    $("#main-check").change(
        function() {
            var flag = $(this).prop("checked");
            $(".check-box").prop("checked", flag);
        }
    )
</script>