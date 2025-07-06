<?php

session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("location:index.php");
    exit;
}
?>
<?php include('function.php'); ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>View page</title>
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
                        <h3 class="f_s_30 f_w_700 text_white">View Sub Category</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">NXTMobility</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Category</a></li>
                            <li class="breadcrumb-item active">View Sub Category</li>
                        </ol>
                    </div>
                    <a href="#" class="white_btn3">Export</a>
                </div>
            </div>
        </div>
        <div class="main_content_iner ">

            <div class="container-fluid p-0">

                <div class="row justify-content-center">

                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">

                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="QA_section">
                                    <div class="white_box_tittle list_header">
                                        <h4>View Sub Category</h4>
                                        <div class="box_right d-flex lms_block">
                                            <div class="serach_field_2">
                                                <div class="search_inner">
                                                    <form active="#">
                                                        <div class="search_field">
                                                            <input type="text" placeholder="Search here...">
                                                        </div>
                                                        <button type="submit"> <i class="ti-search"></i> </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="add_button ms-2">
                                                <a href="./add-sub-category.php" data-bs-toggle="modal"
                                                    class="btn_1">Add Sub category</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="QA_table mb_30">
                                        <div class="table-responsive">
                                            <table class="table lms_table_active ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.no</th>
                                                        <th scope="col">Parent Category Name</th>
                                                        <th scope="col">Sub Categroy ID</th>
                                                        <th scope="col">Sub Categroy Name</th>
                                                        <th scope="col">Sub Category Tagline</th>
                                                        <th scope="col">Sub Category Description</th>
                                                        <th scope="col">Sub Category Image</th>
                                                        <th scope="col">Sub Category Banner Image</th>
                                                        <th scope="col">Slug Url</th>
                                                        <th scope="col">Added On</th>
                                                        <th scope="col">Action</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php echo get_sub_category(); ?>
                                                </tbody>
                                            </table>
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