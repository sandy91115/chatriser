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
    <title>View Test Ride Requests</title>
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
                        <h3 class="f_s_30 f_w_700 text_white">Test Ride Requests</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Nxte</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Enquiry</a></li>
                            <li class="breadcrumb-item active">Test Ride Requests</li>
                        </ol>
                    </div>
                    <a href="#" class="white_btn3">Export</a>
                </div>
            </div>
        </div>
        <div class="main_content_iner">

            <div class="container-fluid p-0">

                <div class="row justify-content-center">

                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <!-- Main title (if any) can be added here -->
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="QA_section">
                                    <div class="white_box_tittle list_header">
                                        <h4>Test Ride Requests Table</h4>
                                    </div>
                                    <div class="QA_table mb_30">
                                        <div class="table-responsive">
                                            <table class="table lms_table_active ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.no</th>
                                                        <th scope="col">Test Ride ID</th>
                                                        <th scope="col">Customer Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Vehicle Type</th>
                                                        <th scope="col">Vehicle Category</th>
                                                        <th scope="col">Vehicle Model</th>
                                                        <th scope="col">Test Ride Date</th>
                                                        <th scope="col">Pincode</th>
                                                        <th scope="col">State</th>
                                                        <th scope="col">City</th>
                                                        <th scope="col">Enquiry Date</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php get_test_ride(); ?>
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