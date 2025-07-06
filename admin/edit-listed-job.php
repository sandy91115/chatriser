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
    <title>Edit Job</title>
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
                        <h3 class="f_s_30 f_w_700 text_white">Edit Job</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Nxte</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Job</a></li>
                            <li class="breadcrumb-item active">Edit Job</li>
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
                                    <div class="main-title">
                                        <h3 class="m-0">Edit Job Details</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="card-body">
                                    <?php
                                    // Include database connection file
                                    include('db/db-conn.php');

                                    // Get job ID from URL
                                    if (isset($_GET['edit'])) {
                                        $job_id = $_GET['edit'];

                                        // Fetch job details from database
                                        $sql = "SELECT * FROM job WHERE job_id='$job_id'";
                                        $result = mysqli_query($conn, $sql);
                                        $job = mysqli_fetch_assoc($result);
                                    ?>
                                        <form action="function.php" method="POST">
                                            <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Job Title</label>
                                                    <input type="text" class="form-control" name="job_title" value="<?php echo $job['job_title']; ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Job Description</label>
                                                    <input type="text" class="form-control" name="job_description" value="<?php echo $job['job_description']; ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputEmail4">Requirements</label>
                                                    <input type="text" class="form-control" name="requirements" placeholder="Requirements">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="inputEmail4">Experience</label>
                                                    <input type="text" class="form-control" name="experience" placeholder="Experience">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Candidate Qualifications</label>
                                                    <input type="text" class="form-control" name="qualifications" value="<?php echo $job['qualifications']; ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Candidate Responsibilities</label>
                                                    <input type="text" class="form-control" name="responsibilities" value="<?php echo $job['responsibilities']; ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Benefits and Perks</label>
                                                    <input type="text" class="form-control" name="benefits" value="<?php echo $job['benefits']; ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Job Type</label>
                                                    <select class="form-select" name="job_type" required>
                                                        <option value="Full Time" <?php echo $job['job_type'] == 'Full Time' ? 'selected' : ''; ?>>Full Time</option>
                                                        <option value="Part Time" <?php echo $job['job_type'] == 'Part Time' ? 'selected' : ''; ?>>Part Time</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Job Location</label>
                                                    <input class="form-control" name="job_location" value="<?php echo $job['job_location']; ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Salary Range Min Annually</label>
                                                    <input class="form-control" name="salary_minimum" value="<?php echo $job['salary_minimum']; ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Salary Range Max Annually</label>
                                                    <input class="form-control" name="salary_maximum" value="<?php echo $job['salary_maximum']; ?>" required>
                                                </div>
                                            </div>
                                            <button type="submit" name="update-job" class="btn btn-primary">Update Job</button>
                                        </form>
                                    <?php
                                    }
                                    ?>
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