<?php
include "app/config.php";
include "app/helper.php";

$id = $_GET['id'] ?? "";
if ($id != "") {
    $sel = "SELECT * FROM news WHERE id = $id";
    $exe = mysqli_query($conn, $sel);
    $fetch = mysqli_fetch_assoc($exe);
}else{
    header("LOCATION:404.php");
}

include "common/header.php";
?>
<!-- right part of the middle portion starts here -->
<div class="middle-right">
    <div class="page-status">
        <h1><?php echo $fetch['title'] ?></h1>
        <h2><i onclick='window.location.href = "index.php"'> Home /</i> News</h2>
    </div>
    <div class="about-content">
        <?php echo $fetch['description'] ?>
    </div>
</div>
<!-- right part of the middle portion starts here -->
<div class="clear"></div>
</div>
<!-- middle portion with  links, new , banner and course ends here -->

<?php
include "common/footer.php";
?>