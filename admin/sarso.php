<?php
// Include database connection file
include('db/db-conn.php');

// Fetch the model data for editing
if (isset($_GET['id'])) {
    $model_id = $_GET['id'];

    $sql = "SELECT * FROM model WHERE model_id = '$model_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign model data to variables
        $pro_cate = $row['pro_cate'];
        $pro_sub_cate = $row['pro_sub_cate'];
        $pro_name = $row['pro_name'];
        $tagline = $row['tagline'];
        $model_desc = $row['model_desc'];
        $battery_type = $row['battery_type'];
        $battery_kwh = $row['battery_kwh'];
        $motor_type = $row['motor_type'];
        $charger_type = $row['charger_type'];
        $charging_time = $row['charging_time'];
        $wheel_size = $row['wheel_size'];
        $thief_lock = $row['thief_lock'];
        $side_stand_sensor = $row['side_stand_sensor'];
        $drl_light = $row['drl_light'];
        $reverse_mode = $row['reverse_mode'];
        $parking_mode = $row['parking_mode'];
        $anti_theft_wheel_lock = $row['anti_theft_wheel_lock'];
        $anty_theft_alarm = $row['anty_theft_alarm'];
        $smart_break_down_assistance = $row['smart_break_down_assistance'];
        $ladies_foot_rest = $row['ladies_foot_rest'];
        $drive_mode = $row['drive_mode'];
        $speed = $row['speed'];
        $driving_licence_and_registration_required = $row['driving_licence_and_registration_required'];
        $warranty = $row['warranty'];
        $chassis_warranty = $row['chassis_warranty'];
        $first_video_link = $row['first_video_link'];
        $second_video_link = $row['second_video_link'];
        $model_images = [
            $row['model_image1'],
            $row['model_image2'],
            $row['model_image3'],
            $row['model_image4'],
            $row['model_image5'],
            $row['model_image6']
        ];
        $first_video_thumbnail = $row['first_video_thumbnail'];
        $second_video_thumbnail = $row['second_video_thumbnail'];
    } else {
        echo "<script>alert('Model not found'); window.location.href='view-model.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No model ID provided'); window.location.href='view-model.php';</script>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Model</title>

</head>

<body>

    <!-- HTML form for editing the model -->
    <h2>Edit Model</h2>
    <form action="function.php?id=<?php echo $model_id; ?>" method="post" enctype="multipart/form-data">
        <!-- Product Details -->
        <label>Product Category:</label>
        <input type="text" name="pro_cate" value="<?php echo $pro_cate; ?>"><br>

        <label>Product Sub Category:</label>
        <input type="text" name="pro_sub_cate" value="<?php echo $pro_sub_cate; ?>"><br>

        <label>Product Name:</label>
        <input type="text" name="pro_name" value="<?php echo $pro_name; ?>"><br>

        <label>Tagline:</label>
        <input type="text" name="tagline" value="<?php echo $tagline; ?>"><br>

        <label>Model Description:</label>
        <textarea name="model_desc"><?php echo $model_desc; ?></textarea><br>

        <!-- Battery Details -->
        <label>Battery Type:</label>
        <input type="text" name="battery_type" value="<?php echo $battery_type; ?>"><br>

        <label>Battery KWh:</label>
        <input type="text" name="battery_kwh" value="<?php echo $battery_kwh; ?>"><br>

        <!-- Motor Details -->
        <label>Motor Type:</label>
        <input type="text" name="motor_type" value="<?php echo $motor_type; ?>"><br>

        <!-- Charger Details -->
        <label>Charger Type:</label>
        <input type="text" name="charger_type" value="<?php echo $charger_type; ?>"><br>

        <label>Charging Time:</label>
        <input type="text" name="charging_time" value="<?php echo $charging_time; ?>"><br>

        <!-- Additional Features -->
        <label>Wheel Size:</label>
        <input type="text" name="wheel_size" value="<?php echo $wheel_size; ?>"><br>

        <label>Thief Lock:</label>
        <input type="text" name="thief_lock" value="<?php echo $thief_lock; ?>"><br>

        <label>Side Stand Sensor:</label>
        <input type="text" name="side_stand_sensor" value="<?php echo $side_stand_sensor; ?>"><br>

        <label>DRL Light:</label>
        <input type="text" name="drl_light" value="<?php echo $drl_light; ?>"><br>

        <label>Reverse Mode:</label>
        <input type="text" name="reverse_mode" value="<?php echo $reverse_mode; ?>"><br>

        <label>Parking Mode:</label>
        <input type="text" name="parking_mode" value="<?php echo $parking_mode; ?>"><br>

        <label>Anti-theft Wheel Lock:</label>
        <input type="text" name="anti_theft_wheel_lock" value="<?php echo $anti_theft_wheel_lock; ?>"><br>

        <label>Anti-theft Alarm:</label>
        <input type="text" name="anty_theft_alarm" value="<?php echo $anty_theft_alarm; ?>"><br>

        <label>Smart Breakdown Assistance:</label>
        <input type="text" name="smart_break_down_assistance" value="<?php echo $smart_break_down_assistance; ?>"><br>

        <label>Ladies Foot Rest:</label>
        <input type="text" name="ladies_foot_rest" value="<?php echo $ladies_foot_rest; ?>"><br>

        <label>Drive Mode:</label>
        <input type="text" name="drive_mode" value="<?php echo $drive_mode; ?>"><br>

        <label>Speed:</label>
        <input type="text" name="speed" value="<?php echo $speed; ?>"><br>

        <label>Driving Licence & Registration Required:</label>
        <input type="text" name="driving_licence_and_registration_required" value="<?php echo $driving_licence_and_registration_required; ?>"><br>

        <label>Warranty:</label>
        <input type="text" name="warranty" value="<?php echo $warranty; ?>"><br>

        <label>Chassis Warranty:</label>
        <input type="text" name="chassis_warranty" value="<?php echo $chassis_warranty; ?>"><br>

        <!-- Video Links -->
        <label>First Video Link:</label>
        <input type="text" name="first_video_link" value="<?php echo $first_video_link; ?>"><br>

        <label>Second Video Link:</label>
        <input type="text" name="second_video_link" value="<?php echo $second_video_link; ?>"><br>

        <!-- Model Images -->
        <label>Model Image 1:</label>
        <input type="file" name="model_image1">
        <img src="<?php echo $model_images[1]; ?>" alt="Model Image 1" width="100"><br>

        <label>Model Image 2:</label>
        <input type="file" name="model_image2">
        <img src="<?php echo $model_images[2]; ?>" alt="Model Image 2" width="100"><br>

        <label>Model Image 3:</label>
        <input type="file" name="model_image3">
        <img src="<?php echo $model_images[3]; ?>" alt="Model Image 3" width="100"><br>

        <label>Model Image 4:</label>
        <input type="file" name="model_image4">
        <img src="<?php echo $model_images[4]; ?>" alt="Model Image 4" width="100"><br>

        <label>Model Image 5:</label>
        <input type="file" name="model_image5">
        <img src="<?php echo $model_images[5]; ?>" alt="Model Image 5" width="100"><br>

        <label>Model Image 6:</label>
        <input type="file" name="model_image6">
        <img src="<?php echo $model_images[6]; ?>" alt="Model Image 6" width="100"><br>

        <!-- Video Thumbnails -->
        <label>First Video Thumbnail:</label>
        <input type="file" name="first_video_thumbnail">
        <img src="<?php echo $first_video_thumbnail; ?>" alt="First Video Thumbnail" width="100"><br>

        <label>Second Video Thumbnail:</label>
        <input type="file" name="second_video_thumbnail">
        <img src="<?php echo $second_video_thumbnail; ?>" alt="Second Video Thumbnail" width="100"><br>

        <button type="submit" name="update-model">Update Model</button>
    </form>

</body>

</html>