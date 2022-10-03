<?php
include "../app/config.php";
include "../app/helper.php";
error_reporting(E_ALL);
// page will be used for updateoca
$selNews = "SELECT * FROM about_us";
$exeNews = mysqli_query($conn, $selNews);
$fetchNews = mysqli_fetch_assoc($exeNews);
$desc = $fetchNews['about_content'];

$msg = "";
if (isset($_POST['save'])) {
    $desc  = $_POST['about_content'];
    if ($desc != "") {
        $qry = "UPDATE about_us SET about_content = '$desc'";
        mysqli_query($conn, $qry);
    } else {
        echo "Error!!";
    }
}

include "common/header.php";
?>
<!-- Content Wrapper -->


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update About Us</h6>
        </div>
        <div class="card-body">
            <h4 class="text-center text-danger">
                <?php echo $msg ?>
            </h4>
            <form method="post">
                <div class="row">
                    <div class="col-12 mt-2">
                        <label for="" class="form-lable">Description</label>
                        <textarea name="about_content" required class="form-control" cols="30" rows="10"><?php echo $desc ?? '' ?></textarea>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-primary" type="submit" name="save" value="clicked">
                            Update About Us
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
<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('about_content');
</script>