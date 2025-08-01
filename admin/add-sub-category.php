<?php

session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("location:index.php");
    exit;
}
?>
<?php include('db/db-conn.php');
$sql = "SELECT * FROM category ORDER BY cate_id DESC";
$check = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Add Category</title>
    <?php include('includes/links.php'); ?>
</head>

<body class="crm_body_bg">

    <?php include('includes/sidebar.php'); ?>


    <section class="main_content dashboard_part data">

        <?php include('includes/header.php'); ?>
        <div class="row" style="background-color: #64C5B1;padding:1rem">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Add Category</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Nxte</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Category</a></li>
                            <li class="breadcrumb-item active">Add Sub Category</li>
                        </ol>
                    </div>
                    <a href="#" class="white_btn3">Export</a>
                </div>
            </div>
        </div>
        <div class="main_content_iner ">

            <div class="container-fluid p-0">

                <div class="row justify-content-center">

                    <div class="main_content_iner ">
                        <div class="container-fluid p-0 sm_padding_15px">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="white_card card_height_100 mb_30">
                                        <div class="white_card_header">
                                            <div class="box_header m-0">
                                                <div class="main-title">
                                                    <h3 class="m-0">Fill all the Category details</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="white_card_body">
                                            <div class="card-body">
                                                <form action="function.php" method="POST" enctype="multipart/form-data">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="inputEmail4">Parent Category</label>
                                                            <select name="parent_cate_id" class="form-control">
                                                                <option>--select--</option>
                                                                <?php foreach ($check as $val) { ?>
                                                                    <option value="<?php echo $val['cate_id'] ?>"><?php echo ucwords($val['cate_name']) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3 ">
                                                            <label class="form-label" for="inputEmail4">Sub Category Name</label>
                                                            <input type="text" class="form-control" name="sub_cate_name" id="inputEmail4" placeholder="Sub Category Name">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="inputEmail4">Sub Category Tagline (optional)</label>
                                                            <input type="text" class="form-control" name="sub_cate_tagline" id="categoryname" placeholder="Sub Category Tagline">
                                                        </div>
                                                        <div class="col-md-6 mb-3 ">
                                                            <label class="form-label" for="inputEmail4">Sub Category Description (optional)</label>
                                                            <input type="text" class="form-control" name="sub_cate_description" id="inputEmail4" placeholder="Sub Category Description">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="inputEmail4">Sub Category Image</label>
                                                            <input type="file" class="form-control" name="sub_cate_image">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="inputEmail4">Sub Category Banner Image</label>
                                                            <input type="file" class="form-control" name="sub_cate_banner_image">
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="add-sub-category" class="btn btn-primary">Add Sub Category</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12"></div> -->
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </section>

    <?php include('includes/scripts.php'); ?>
</body>

</html>