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
    <title>Add Model</title>
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
                        <h3 class="f_s_30 f_w_700 text_white">Add Model</h3>
                        <ol class="breadcrumb page_bradcam mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Nxte</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Model</a></li>
                            <li class="breadcrumb-item active">Add Model</li>
                        </ol>
                    </div>
                    <a href="./view-model.php" class="white_btn3">View Model</a>
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

                                        <div class="white_card_body">
                                            <div class="card-body">
                                                <form action="function.php" method="POST" enctype="multipart/form-data">

                                                    <h3 class="text-center">Basic Details</h3>
                                                    <hr>
                                                    <div class="row mb-3">
                                                        <!-- Parent Category -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="pro_cate">Parent Category</label>
                                                            <select name="pro_cate" class="form-control" onchange="get_subcategories(this.value)">
                                                                <option value="">-- Select --</option>
                                                                <?php foreach ($check as $val) { ?>
                                                                    <option value="<?php echo $val['cate_id']; ?>">
                                                                        <?php echo ucwords($val['cate_name']); ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <!-- Sub Category -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="pro_sub_cate">Sub Category</label>
                                                            <select name="pro_sub_cate" id="subcat_id" class="form-control">
                                                                <option value="">-- Select --</option>
                                                            </select>
                                                        </div>

                                                        <!-- Model Name -->
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="pro_name">Model Name</label>
                                                            <input type="text" class="form-control" name="pro_name" id="pro_name" placeholder="Model Name">
                                                        </div>

                                                        <!-- Tag-line -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="tagline">Tag-line</label>
                                                            <input type="text" class="form-control" name="tagline" id="tagline" placeholder="Tag-line">
                                                        </div>

                                                        <!-- Model Images -->
                                                        <?php for ($i = 1; $i <= 6; $i++) { ?>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="model_image<?php echo $i; ?>">Model Image
                                                                    <?php echo $i; ?>
                                                                </label>
                                                                <input type="file" class="form-control" name="model_image<?php echo $i; ?>" id="model_image<?php echo $i; ?>">
                                                            </div>
                                                        <?php } ?>
                                                        <!-- Model Description -->
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label" for="model_desc">Model Description</label>
                                                            <textarea class="form-control" name="model_desc" id="model_desc" rows="3"></textarea>
                                                        </div>
                                                        <hr>
                                                        <h3 class="text-center">Technical Specifications</h3>
                                                        <hr>

                                                        <!-- Additional Fields with Dropdowns -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="battery_type">Battery Type</label>
                                                            <input type="text" class="form-control" name="battery_type" id="battery_type" value="Lithium-Ion ">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="chassis_warranty">Battery KWH</label>
                                                            <input type="text" class="form-control" name="battery_kwh" id="battery_kwh" value="">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="motor_type">Motor Type</label>
                                                            <input type="text" class="form-control" name="motor_type" id="motor_type" value="BLDC">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="charger_type">Charger Type</label>
                                                            <input type="text" class="form-control" name="charger_type" id="charger_type" value="Portable Charger">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="charging_time">Charging Time(in hours)</label>
                                                            <input type="text" class="form-control" name="charging_time" id="charging_time" value="3">
                                                        </div>


                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="wheel_size">Wheel Size (in Inch)</label>
                                                            <input type="text" class="form-control" name="wheel_size" id="wheel_size" value="10">
                                                        </div>


                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="thief_lock">Thief Lock</label>
                                                            <select class="form-control" name="thief_lock" id="thief_lock">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="side_stand_sensor">Side Stand Sensor</label>
                                                            <select class="form-control" name="side_stand_sensor" id="side_stand_sensor">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="drl_light">DRL Light</label>
                                                            <select class="form-control" name="drl_light" id="drl_light">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="reverse_mode">Reverse Mode</label>
                                                            <select class="form-control" name="reverse_mode" id="reverse_mode">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="parking_mode">Parking Mode</label>
                                                            <select class="form-control" name="parking_mode" id="parking_mode">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="anty_theft_alarm">Anti Theft Wheel Lock</label>
                                                            <select class="form-control" name="anty_theft_alarm" id="anti_theft_wheel_lock">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="anty_theft_alarm">Anti Theft Alarm</label>
                                                            <select class="form-control" name="anty_theft_alarm" id="anty_theft_alarm">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="smart_break_down_assistance">Smart Break Down Assistance</label>
                                                            <select class="form-control" name="smart_break_down_assistance" id="smart_break_down_assistance">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="ladies_foot_rest">Ladies Foot Rest</label>
                                                            <select class="form-control" name="ladies_foot_rest" id="ladies_foot_rest">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="drive_mode">Drive Mode</label>
                                                            <input type="number" class="form-control" name="drive_mode" id="drive_mode" value="3">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="speed">Speed (in KMPH)</label>
                                                            <input type="text" class="form-control" name="speed" id="speed" value="25">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="ladies_foot_rest">Driving Licence & Registration required</label>
                                                            <select class="form-control" name="driving_licence_and_registration_required" id="driving_licence_and_registration_required">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="warranty">Warranty(in Years)*</label>
                                                            <input type="number" class="form-control" name="warranty" id="warranty" value="3">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="chassis_warranty">Chassis Warranty (in years)</label>
                                                            <input type="text" class="form-control" name="chassis_warranty" id="chassis_warranty" value="5">
                                                        </div>
                                                        <hr>
                                                        <h3 class="text-center">Videos Section</h3>
                                                        <hr>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="warranty">First Video Thumbnail</label>
                                                            <input type="file" class="form-control" name="first_video_thumbnail">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="chassis_warranty">First Video Link*(only youtube Link)</label>
                                                            <input type="text" class="form-control" name="first_video_link">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="warranty">Second Video Thumbnail</label>
                                                            <input type="file" class="form-control" name="second_video_thumbnail">
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="chassis_warranty">Second Video Link*(only Youtube Link)</label>
                                                            <input type="text" class="form-control" name="second_video_link">
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="add-model" class="btn btn-primary">Add Model</button>
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
    <script type="text/javascript">
        function get_subcategories(cate_id) {
            var cate_id = cate_id;
            $.ajax({
                url: 'function.php',
                method: 'post',
                data: {
                    cate_id: cate_id
                },
                error: function() {
                    alert("something went wrong");

                },
                success: function(data) {
                    $("#subcat_id").html(data);

                }
            });
        }
    </script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('model_desc');
    </script>
</body>

</html>