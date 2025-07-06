<?php

session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Edit Blog</title>
    <?php include('includes/links.php'); ?>
</head>

<body class="crm_body_bg">

    <?php include('includes/sidebar.php'); ?>

    <section class="main_content dashboard_part data">
        <?php include('includes/header.php'); ?>

        <div class="row" style="background-color: #64C5B1; padding: 1rem;">
            <div class="col-12">
                <div class="page_title_box d-flex align-items-center justify-content-between">
                    <div class="page_title_left">
                        <h3 class="f_s_30 f_w_700 text_white">Edit Blog</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Nxte</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Category</a></li>
                            <li class="breadcrumb-item active">Edit Blog</li>
                        </ol>
                    </div>
                    <a href="#" class="white_btn3">Export</a>
                </div>
            </div>
        </div>

        <div class="main_content_iner">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="main_content_iner">
                        <div class="container-fluid p-0 sm_padding_15px">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="white_card card_height_100 mb_30">
                                        <div class="white_card_header">
                                            <div class="box_header m-0">
                                                <div class="main-title">
                                                    <h3 class="m-0">Edit Blog Details</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="white_card_body">
                                            <div class="card-body">
                                                <?php
                                                include('db/db-conn.php');

                                                if (isset($_GET['edit'])) {
                                                    $blog_id = $_GET['edit'];
                                                    $query = "SELECT * FROM blog WHERE blog_id = '$blog_id'";
                                                    $result = mysqli_query($conn, $query);
                                                    $blog = mysqli_fetch_assoc($result);
                                                }
                                                ?>

                                                <form action="function.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="blog_id" value="<?php echo $blog['blog_id']; ?>">

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="blog_title">Blog Title</label>
                                                            <input type="text" class="form-control" name="blog_title" id="blog_title" value="<?php echo $blog['blog_title']; ?>" placeholder="Blog Title">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="blog_short_description">Blog Short Description</label>
                                                            <input type="text" class="form-control" name="blog_short_description" id="blog_short_description" value="<?php echo $blog['blog_short_description']; ?>" placeholder="Blog Short Description">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="blog_content">Blog Content</label>
                                                            <input type="text" class="form-control" name="blog_content" id="blog_content" value="<?php echo $blog['blog_content']; ?>" placeholder="Blog Content">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="blog_image">Blog Image</label>
                                                            <input type="file" class="form-control" name="blog_image" id="blog_image">
                                                            <?php if ($blog['blog_image']) { ?>
                                                                <img src="<?php echo $blog['blog_image']; ?>" alt="Current Blog Image" class="mt-2" style="width: 100px; height: auto;">
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="author_name">Author Name</label>
                                                            <input type="text" class="form-control" name="author_name" id="author_name" value="<?php echo $blog['author_name']; ?>" placeholder="Author Name">
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="update_blog" class="btn btn-primary">Update Blog</button>
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