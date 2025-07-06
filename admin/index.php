<?php
include('db/db-conn.php');
session_start(); // Start the session

if (isset($_POST['adminloginbtn'])) {
    $adminemail = $_POST['adminemail'];
    $adminpassword = $_POST['adminpassword'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Secure SQL query using prepared statements
    $stmt = $conn->prepare("SELECT id, adminemail, adminpassword FROM adminlogin WHERE adminemail = ? AND adminpassword = ?");
    $stmt->bind_param("ss", $adminemail, $adminpassword);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Store both email and id in the session
        $_SESSION['adminloginid'] = $row['id'];
        $_SESSION['adminemail'] = $row['adminemail'];

        header("location:dashboard.php");
        exit(); // Ensure the script stops execution after the redirect
    } else {
        echo "<script>alert('Email or password is incorrect!')</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <?php include('includes/links.php'); ?>
</head>

<body>
    <div id="particles-js" class="snow"></div>

    <main>
        <div class="left-side"></div>

        <div class="right-side">
            <form method="POST">
                <div class="btn-group">
                    <img src="img/cybalslogo.png" alt="" class="img-fluid" style="width: 128px; height: 128px">
                    <h3>Powered by</h3>
                    <p>Cybals Tech Solution</p>
                </div>
                <label for="email">Email</label>
                <input type="text" placeholder="Enter Email" name="adminemail" required />

                <label for="password">Password</label>
                <input type="password" placeholder="Enter Password" name="adminpassword" required>
                <button type="submit" name="adminloginbtn" class="login-btn">Log in</button>
            </form>
        </div>
    </main>

    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 310,
                    density: {
                        enable: true,
                        value_area: 800,
                    },
                },
                color: {
                    value: "#fff",
                },
                shape: {
                    type: "circle",
                    stroke: {
                        width: 0,
                        color: "#000000",
                    },
                    polygon: {
                        nb_sides: 5,
                    },
                },
                opacity: {
                    value: 1,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false,
                    },
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: false,
                    },
                },
                line_linked: {
                    enable: false,
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "bottom",
                    random: false,
                    straight: false,
                    out_mode: "out",
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200,
                    },
                },
            },
            retina_detect: true,
        });
    </script>
</body>

</html>