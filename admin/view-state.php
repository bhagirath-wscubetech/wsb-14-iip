<?php
include "../app/config.php";
include "../app/helper.php";
error_reporting(E_ALL);
$msg = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $newstatus = $_GET['newstatus'];
    if (isset($newstatus)) {
        $qry = "UPDATE states SET status = $newstatus WHERE state_id = $id";
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
        $qry = "DELETE FROM states WHERE state_id = $id";
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

include "common/header.php";
?>
<!-- Content Wrapper -->


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">View News</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th>Country Id</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                $sel = "SELECT * FROM states LEFT JOIN countries ON states.country_id = countries.id  ORDER BY state_id DESC"; // step 1
                // ASC - DESC
                $exe = mysqli_query($conn, $sel); // step 2
                // $fetch = mysqli_fetch_assoc($exe);
                // p($fetch);
                // die;
                // SELECT <cols> FROM <table_name>
                // <cols> - * (All Columns)
                ?>
                <tbody>
                    <?php
                    $sr = 1;
                    while ($fetch = mysqli_fetch_assoc($exe)) { // step 3
                    ?>
                        <tr>
                            <td>
                                <?php echo $sr ?>
                            </td>
                            <td>
                                <?php echo $fetch['state_name'] ?>
                            </td>
                            <td>
                                <?php echo $fetch['name'] ?>
                            </td>
                            <td>
                                <?php
                                if ($fetch['state_status'] == 1) {
                                ?>
                                    <a href="view-state.php?id=<?php echo $fetch['state_id'] ?>&newstatus=0">
                                        <button class="btn btn-success">Active</button>
                                    </a>
                                    <!-- Active -->
                                <?php
                                } else {
                                ?>
                                    <a href="view-state.php?id=<?php echo $fetch['state_id'] ?>&newstatus=1">
                                        <button class="btn btn-warning">Inactive</button>
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
                                <a href="add-state.php?id=<?php echo $fetch['state_id'] ?>">
                                    <i class="text-primary fa fa-pen"></i>
                                </a>
                                &nbsp;
                                &nbsp;
                                <a href="view-state.php?id=<?php echo $fetch['state_id'] ?>">
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