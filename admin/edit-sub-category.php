<?php

session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("location:index.php");
    exit;
}
?>
<?php
include('db/db-conn.php');

// Check if 'edit_sub_cate' parameter is set
if (isset($_GET['edit_sub_cate'])) {
    $sub_cate_id = $_GET['edit_sub_cate'];

    // Fetch the sub-category details
    $sql = "SELECT * FROM sub_category WHERE sub_cate_id = '$sub_cate_id'";
    $result = mysqli_query($conn, $sql);
    $sub_category = mysqli_fetch_assoc($result);

    // Fetch parent categories for the dropdown
    $parent_sql = "SELECT * FROM category";
    $parent_result = mysqli_query($conn, $parent_sql);
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Sub Category</title>
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
                        <h3 class="f_s_30 f_w_700 text_white">Edit Sub Category</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Nxte</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Sub Category</a></li>
                            <li class="breadcrumb-item active">Edit Sub Category</li>
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
                                                    <h3 class="m-0">Edit Sub Category Details</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="white_card_body">
                                            <div class="card-body">
                                                <form action="function.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="sub_cate_id" value="<?php echo $sub_category['sub_cate_id']; ?>">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="parent_cate_id">Parent Category</label>
                                                            <select name="parent_cate_id" class="form-control" id="parent_cate_id">
                                                                <?php while ($parent = mysqli_fetch_assoc($parent_result)) { ?>
                                                                    <option value="<?php echo $parent['cate_id']; ?>" <?php echo ($parent['cate_id'] == $sub_category['parent_cate_id']) ? 'selected' : ''; ?>>
                                                                        <?php echo ucwords($parent['cate_name']); ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="sub_cate_name">Sub Category Name</label>
                                                            <input type="text" class="form-control" name="sub_cate_name" id="sub_cate_name" value="<?php echo htmlspecialchars($sub_category['sub_cate_name']); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="sub_cate_tagline">Sub Category Tagline (optional)</label>
                                                            <input type="text" class="form-control" name="sub_cate_tagline" id="sub_cate_tagline" value="<?php echo htmlspecialchars($sub_category['sub_cate_tagline']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="sub_cate_description">Sub Category Description (optional)</label>
                                                            <input type="text" class="form-control" name="sub_cate_description" id="sub_cate_description" value="<?php echo htmlspecialchars($sub_category['sub_cate_description']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="sub_cate_image">Sub Category Image</label>
                                                            <input type="file" class="form-control" name="sub_cate_image">
                                                            <?php if ($sub_category['sub_cate_image']) { ?>
                                                                <img src="<?php echo $sub_category['sub_cate_image']; ?>" alt="Current Image" style="width: 100px; height: auto;">
                                                                <input type="hidden" name="current_image" value="<?php echo $sub_category['sub_cate_image']; ?>">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="sub_cate_banner_image">Sub Category Banner Image</label>
                                                            <input type="file" class="form-control" name="sub_cate_banner_image">
                                                            <?php if ($sub_category['sub_cate_banner_image']) { ?>
                                                                <img src="<?php echo $sub_category['sub_cate_banner_image']; ?>" alt="Current Banner Image" style="width: 100px; height: auto;">
                                                                <input type="hidden" name="current_banner_image" value="<?php echo $sub_category['sub_cate_banner_image']; ?>">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="update_sub_category" class="btn btn-primary">Update Sub Category</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </section>

    <?php include('includes/scripts.php'); ?>
</body>

</html>