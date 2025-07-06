<?php
include('./db/db-conn.php');


// Check if the session variable is set
if (isset($_SESSION['adminloginid'])) {
    $adminId = $_SESSION['adminloginid'];

    // Use prepared statements for secure SQL queries
    $stmt = $conn->prepare("SELECT * FROM adminlogin WHERE id = ?");
    $stmt->bind_param("i", $adminId); // "i" denotes the type is integer

    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results
    if ($result->num_rows > 0) {
        $logindetails = $result;
    } else {
        echo "No admin found with the given ID.";
        $logindetails = [];
    }

    $stmt->close();
} else {
    echo "Admin ID is not set in the session.";
    $logindetails = [];
}

$conn->close();
?>
<div class="container-fluid g-0">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div class="serach_field-area d-flex align-items-center">
                    <div class="search_inner">
                        <form action="#">
                            <div class="search_field">
                                <input type="text" placeholder="Search here...">
                            </div>
                            <button type="submit"> <img src="img/icon/icon_search.svg" alt> </button>
                        </form>
                    </div>
                    <span class="f_s_14 f_w_400 ml_25 white_text text_white">Apps</span>
                </div>
                <div class="header_right d-flex justify-content-between align-items-center">

                    <div class="profile_info">
                        <img src="img/logo/nxtelogo.png" alt="#">
                        <div class="profile_info_iner">
                            <div class="profile_author_name">
                                <?php
                                if ($logindetails) {
                                    while ($row = mysqli_fetch_assoc($logindetails)) {
                                ?>
                                        <p><?php echo htmlspecialchars($row['adminname']); ?></p>
                                        <p class="fw-bold"><?php echo htmlspecialchars($row['roll']); ?></p>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="profile_info_details">
                                <a href="./logout.php">Log Out </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>