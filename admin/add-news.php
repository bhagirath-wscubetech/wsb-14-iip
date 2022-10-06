<?php
include "../app/config.php";
include "../app/helper.php";

$mode = "Add";
$id = $_GET['id'] ?? "";

if ($id != "") {
    $mode = "Update";
    $sel = "SELECT * FROM news WHERE id = $id";
    $exe = mysqli_query($conn, $sel);
    $data = mysqli_fetch_assoc($exe);
    // p($data);
}

if (isset($_POST['save'])) {
    $title = $_POST['news_title'];
    $desc = $_POST['news_desc'];
    if ($title != ""  && $desc != "") {
        // sever side validation
        if ($id != "") {
            // update query
            $qry = "UPDATE news SET title = '$title', description = '$desc' WHERE id = $id";
        } else {
            $qry = "INSERT INTO news SET title = '$title', description = '$desc'";
            // insert query
        }
        try {
            $success = mysqli_query($conn, $qry);
        } catch (Exception $err) {
            echo $err->getMessage();
            $success = false;
        }
        if ($success == true) {
            header("LOCATION:view-news.php"); //redirect
        } else {
            // error throw
        }
    } else {
        // error throw
    }
}
include "common/header.php";
?>
<!-- Content Wrapper -->


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $mode ?> News</h6>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="row">
                    <div class="col-12">
                        <label for="" class="form-lable">Title</label>
                        <input type="text" value="<?php echo $data['title'] ?>" required name="news_title" class="form-control">
                    </div>
                    <div class="col-12 mt-2">
                        <label for="" class="form-lable">Description</label>
                        <textarea name="news_desc" required class="form-control" cols="30" rows="10"><?php echo $data['description'] ?></textarea>
                    </div>
                    <?php echo $mode ?>
                    <div class="col-12 mt-2">
                        <button class="btn btn-primary" type="submit" name="save" value="clicked">
                            <?php echo $mode ?>
                        </button>
                        <button class="btn btn-warning" type="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- End of Main Content -->
<?php include "common/footer.php"; ?>
<!-- <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'news_desc' );
</script> -->