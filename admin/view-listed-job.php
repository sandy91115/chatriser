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
                        <h3 class="f_s_30 f_w_700 text_white">View Listed Job</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">NXTMobility</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Job</a></li>
                            <li class="breadcrumb-item active">View Job Listed</li>
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
                                        <h4>View Job Listed</h4>
                                        <div class="box_right d-flex lms_block">
                                            <div class="serach_field_2">
                                                <div class="search_inner">
                                                    <form active="#">
                                                        <div class="search_field">
                                                            <input type="text" placeholder="Search content here...">
                                                        </div>
                                                        <button type="submit"> <i class="ti-search"></i> </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="QA_table mb_30">
                                        <div class="table-responsive">
                                            <table class="table lms_table_active ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.no</th>
                                                        <th scope="col">Job Id</th>
                                                        <th scope="col">Job Title</th>
                                                        <th scope="col">Job Description</th>
                                                        <th scope="col">Experience</th>
                                                        <th scope="col">Requirements</th>
                                                        <th scope="col">Candidate Qualifications</th>
                                                        <th scope="col">Candidate Responsibilities</th>
                                                        <th scope="col">Benefits and Perks</th>
                                                        <th scope="col">Job Type</th>
                                                        <th scope="col">Job Location</th>
                                                        <th scope="col">Salary Minimum</th>
                                                        <th scope="col">Salary Maximum</th>
                                                        <th scope="col">Posted On</th>
                                                        <th scope="col">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php echo get_listed_job(); ?>
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