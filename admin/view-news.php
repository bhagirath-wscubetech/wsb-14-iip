<?php
include "../app/config.php";
include "../app/helper.php";

$id = $_GET['id'] ?? "";

if ($id != "") {
    $status = $_GET['status'] ?? ""; // null safe operator
    if($status != ""){
        // update
        $qry = "UPDATE news SET status = $status WHERE id = $id";
    }else{
        // delete
        $qry = "DELETE FROM news WHERE id = $id";
    }
    // echo $qry;
    try {
        $success = mysqli_query($conn,$qry);
    } catch (Exception $err) {
        $success = false;
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
                        <th>Title</th>
                        <th width="40%">Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // *  all cols
                    // select title from news;
                    // select title,description from news
                    $sel = "SELECT * FROM news";
                    $exe = mysqli_query($conn, $sel);
                    $sr = 1;
                    while ($fetch = mysqli_fetch_assoc($exe)) {
                    ?>
                        <tr>
                            <td><?php echo $sr ?></td>
                            <td><?php echo $fetch['title'] ?></td>
                            <td><?php echo $fetch['description'] ?></td>
                            <td>
                                <?php
                                if ($fetch['status'] == 1) {
                                ?>
                                    <a href="view-news.php?id=<?php echo $fetch['id'] ?>&status=0">
                                        <button class="btn btn-success">Active</button>
                                        <!-- 1 -->
                                    </a>
                                <?php
                                } else {
                                ?>
                                    <a href="view-news.php?id=<?php echo $fetch['id'] ?>&status=1">
                                        <button class="btn btn-danger">Inactive</button>
                                        <!-- 0 -->
                                    </a>
                                <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $fetch['created_at'] ?></td>
                            <td>
                                <a href="view-news.php?id=<?php echo $fetch['id'] ?>">
                                    <span class="fa fa-trash text-danger"></span>
                                </a>
                                &nbsp;&nbsp;
                                <span class="fa fa-pen text-primary"></span>
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