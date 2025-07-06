<?php
include('db/db-conn.php');

// ************************Display subcategories based on the selected parent category.
// ***********************this function is used in add product page to show sub category on the basis of parent category
if (isset($_POST['cate_id'])) {
    $p_id = $_POST['cate_id'];

    $sql = "SELECT * FROM sub_category WHERE parent_cate_id=$p_id ORDER BY sub_cate_id DESC";
    $check = mysqli_query($conn, $sql);
?>
    <option value="">--select--</option>
<?php
    while ($result = mysqli_fetch_assoc($check)) {
        echo "<option value=" . $result['sub_cate_id'] . ">" . $result['sub_cate_name'] . "</option>";
    }
}
// ***********************displayed subcategory function end*****************************\\ 


// ****************This function converts a string into a URL-friendly slug format.********************\\
function SlugUrl($string)
{
    $slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $string);
    $slug = str_replace(' ', '-', $slug);
    $slug = strtolower($slug);
    return $slug;
}
//***************slug url function end**************\\

// ******************************************Blog*****************************************************************\\

// ***********add blog*******************\\
if (isset($_POST['add_blog'])) {
    $blog_id = mt_rand(11111, 99999);
    $blog_title = $_POST['blog_title'];
    $blog_short_description = $_POST['blog_short_description'];
    $blog_content = $_POST['blog_content'];

    // blog image code
    if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] == 0) {
        $filename = basename($_FILES['blog_image']['name']);
        $tempname = $_FILES['blog_image']['tmp_name'];
        $destination = 'assets/uploads/blogimage/' . $filename;

        if (move_uploaded_file($tempname, $destination)) {
            $blog_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Image is not uploaded');</script>";
        exit();
    }

    $author_name = $_POST['author_name'];
    $published_on = date('M d, Y');

    $sql = "INSERT INTO blog (blog_id, blog_title, blog_short_description, blog_content, blog_image, author_name,published_on) 
            VALUES ('$blog_id', '$blog_title', '$blog_short_description', '$blog_content', '$blog_image', '$author_name','$published_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Inserted Successfully');
                window.location.href='view-blog.php';
              </script>";
    } else {
        echo "<script>alert('Not inserted');</script>";
    }
}

// **********get blog/ view blog******************\\
function get_blog()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM blog";
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        $trimmed_short_description = strlen($result['blog_short_description']) > 30 ? substr($result['blog_short_description'], 0, 30) . "..." : $result['blog_short_description'];
        $trimmed_content = strlen($result['blog_content']) > 30 ? substr($result['blog_content'], 0, 30) . "..." : $result['blog_content'];

        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['blog_id'] . "</td>
                <td>" . $result['blog_title'] . "</td>
                <td>" . $trimmed_short_description . "</td>
                <td>" . $trimmed_content . "</td>
                
                <td><img src='" . $result['blog_image'] . "' alt='Blog Image' class='model-image' data-bs-img='" . $result['blog_image'] . "' style='width: 100px; height: auto;'></td>
                 
                <td>" . $result['author_name'] . "</td>
                <td>" . $result['published_on'] . "</td>
                <td>
                    <!-- Three-dot Icon with Dropdown -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['blog_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['blog_id'] . "'>
                            <li><a class='dropdown-item' href='edit-blog.php?edit=" . $result['blog_id'] . "'>Edit</a></li>
                            <li><a class='dropdown-item' href='?blog_delete=" . $result['blog_id'] . "' onclick='return confirm(\"Are you sure you want to delete this blog?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
//**************************get blog end/view blog end**************************\\

// ********** Blog Delete Start**************\\
if (isset($_GET['blog_delete'])) {
    $blog_id = $_GET['blog_delete'];
    $delete_sql = "DELETE FROM blog WHERE blog_id='$blog_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Blog deleted successfully'); window.location.href='view-blog.php';</script>";
    } else {
        echo "<script>alert('Failed to delete category');</script>";
    }
}
//***************Blog Delete End*******************\\


// *****************************update blog start****************************\\
if (isset($_POST['update_blog'])) {
    $blog_id = $_POST['blog_id'];
    $blog_title = $_POST['blog_title'];
    $blog_short_description = $_POST['blog_short_description'];
    $blog_content = $_POST['blog_content'];
    $author_name = $_POST['author_name'];
    $published_on = date('M d, Y');

    // blog image code
    if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] == 0) {
        $filename = basename($_FILES['blog_image']['name']);
        $tempname = $_FILES['blog_image']['tmp_name'];
        $destination = 'assets/uploads/blogimage/' . $filename;

        if (move_uploaded_file($tempname, $destination)) {
            $blog_image = $destination;
            // Delete old image if a new one is uploaded
            $query = "SELECT blog_image FROM blog WHERE blog_id='$blog_id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            if ($row['blog_image'] && file_exists($row['blog_image'])) {
                unlink($row['blog_image']);
            }
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    } else {
        // Use existing image if no new image is uploaded
        $query = "SELECT blog_image FROM blog WHERE blog_id='$blog_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $blog_image = $row['blog_image'];
    }

    $sql = "UPDATE blog SET blog_title='$blog_title', blog_short_description='$blog_short_description', blog_content='$blog_content', blog_image='$blog_image', author_name='$author_name', published_on='$published_on' WHERE blog_id='$blog_id'";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Updated Successfully');
                window.location.href='view-blog.php';
              </script>";
    } else {
        echo "<script>alert('Not updated');</script>";
    }
}
// **********Blog Update End**************\\

//***********************************************  add category section ********************************\\
if (isset($_POST['add_category'])) {
    $cate_id = mt_rand(11111, 99999);
    $cate_name = $_POST['cate_name'];
    $cate_tagline = $_POST['cate_tagline'];

    // Category Image code
    if (isset($_FILES['cate_image']) && $_FILES['cate_image']['error'] == 0) {
        $filename = basename($_FILES['cate_image']['name']);
        $tempname = $_FILES['cate_image']['tmp_name'];
        $destination = 'assets/uploads/categoryimage/' . $filename;

        if (move_uploaded_file($tempname, $destination)) {
            $cate_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Image is not uploaded');</script>";
        exit();
    }

    $slug_url = SlugUrl($cate_name);
    $added_on = date('M d, Y');

    $sql = "INSERT INTO category (cate_id, cate_name, cate_tagline, cate_image, slug_url, added_on) 
            VALUES ('$cate_id', '$cate_name', '$cate_tagline', '$cate_image', '$slug_url', '$added_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Inserted Successfully');
                window.location.href='view-category.php';
              </script>";
    } else {
        echo "<script>alert('Not inserted');</script>";
    }
}
// *************add category section end*************\\


//****************get category start*****************\\
function get_category()
{
    include('db/db-conn.php');
    $sql = "SELECT * FROM category";
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['cate_id'] . "</td>
                <td>" . $result['cate_name'] . "</td>
                <td>" . $result['cate_tagline'] . "</td>
                <td><img src='" . $result['cate_image'] . "' alt='Category Image' class='model-image' data-bs-img='" . $result['cate_image'] . "' style='width: 100px; height: auto;'></td>
                <td>" . $result['slug_url'] . "</td>
                <td>" . $result['added_on'] . "</td>
                <td>
                    <!-- Three-dot Icon with Dropdown -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['cate_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['cate_id'] . "'>
                            <li><a class='dropdown-item' href='edit-category.php?edit=" . $result['cate_id'] . "'>Edit</a></li>
                            <li><a class='dropdown-item' href='?category_delete=" . $result['cate_id'] . "' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
//****************get category end**************\\



// ********** category Delete Start**************\\
if (isset($_GET['category_delete'])) {
    $cate_id = $_GET['category_delete'];
    $delete_sql = "DELETE FROM category WHERE cate_id='$cate_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Category deleted successfully'); window.location.href='view-category.php';</script>";
    } else {
        echo "<script>alert('Failed to delete category');</script>";
    }
}


//***************category Delete End*******************\\

//**************************************** Update Category************************************\\
if (isset($_POST['update_category'])) {
    $cate_id = $_POST['cate_id'];
    $cate_name = $_POST['cate_name'];
    $cate_tagline = $_POST['cate_tagline'];
    $cate_image = $_POST['current_image']; // Preserve existing image if not updated

    // Category Image code
    if (isset($_FILES['cate_image']) && $_FILES['cate_image']['error'] == 0) {
        $filename = basename($_FILES['cate_image']['name']);
        $tempname = $_FILES['cate_image']['tmp_name'];
        $destination = 'assets/uploads/categoryimage/' . $filename;

        if (move_uploaded_file($tempname, $destination)) {
            $cate_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    }

    $slug_url = SlugUrl($cate_name);

    // Remove `updated_on` from the query if the column does not exist
    $sql = "UPDATE category 
            SET cate_name='$cate_name', cate_tagline='$cate_tagline', cate_image='$cate_image', slug_url='$slug_url' 
            WHERE cate_id='$cate_id'";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Updated Successfully');
                window.location.href='view-category.php';
              </script>";
    } else {
        echo "<script>alert('Update failed');</script>";
    }
}
//*************************** update category*******************************\\

//*********************************************add Sub category Start ******************\\
if (isset($_POST['add-sub-category'])) {
    $sub_cate_id = mt_rand(11111, 99999);
    $parent_cate_id = $_POST['parent_cate_id'];
    $sub_cate_name = mysqli_real_escape_string($conn, $_POST['sub_cate_name']);
    $sub_cate_tagline = mysqli_real_escape_string($conn, $_POST['sub_cate_tagline']);
    $sub_cate_description = mysqli_real_escape_string($conn, $_POST['sub_cate_description']);
    $sub_cate_image = '';

    // Sub Category Image 
    if (isset($_FILES['sub_cate_image']) && $_FILES['sub_cate_image']['error'] == 0) {
        $filename = basename($_FILES['sub_cate_image']['name']);
        $tempname = $_FILES['sub_cate_image']['tmp_name'];
        $destination = 'assets/uploads/subcategoryimage/' . $filename;

        // Ensure the directory exists, and move the uploaded file
        if (!is_dir('assets/uploads/subcategoryimage/')) {
            mkdir('assets/uploads/subcategoryimage/', 0777, true);
        }

        if (move_uploaded_file($tempname, $destination)) {
            $sub_cate_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Image is not uploaded');</script>";
        exit();
    }
    // Sub Category Image 
    if (isset($_FILES['sub_cate_banner_image']) && $_FILES['sub_cate_banner_image']['error'] == 0) {
        $filename = basename($_FILES['sub_cate_banner_image']['name']);
        $tempname = $_FILES['sub_cate_banner_image']['tmp_name'];
        $destination = 'assets/uploads/subcategorybannerimage/' . $filename;

        // Ensure the directory exists, and move the uploaded file
        if (!is_dir('assets/uploads/subcategorybannerimage/')) {
            mkdir('assets/uploads/subcategorybannerimage/', 0777, true);
        }

        if (move_uploaded_file($tempname, $destination)) {
            $sub_cate_banner_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Image is not uploaded');</script>";
        exit();
    }

    $added_on = date('Y-m-d H:i:s');  // Changed to include full timestamp
    $slug_url = SlugUrl($sub_cate_name);

    // Insert into the database
    $sql = "INSERT INTO sub_category (
                sub_cate_id, parent_cate_id, sub_cate_name, 
                sub_cate_tagline, sub_cate_description, sub_cate_image,sub_cate_banner_image, 
                slug_url, added_on
            ) VALUES (
                '$sub_cate_id', '$parent_cate_id', '$sub_cate_name', 
                '$sub_cate_tagline', '$sub_cate_description', '$sub_cate_image','$sub_cate_banner_image', 
                '$slug_url', '$added_on'
            )";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script>alert('Inserted Successfully'); window.location.href='view-sub-category.php';</script>";
    } else {
        echo "<script>alert('Insertion Failed'); window.location.href='view-sub-category.php';</script>";
    }
}

//****************get sub-category start*****************\\
function get_sub_category()
{
    include('db/db-conn.php');
    $sql = "SELECT sc.*, c.cate_name FROM sub_category sc 
            JOIN category c ON sc.parent_cate_id = c.cate_id";
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['cate_name'] . "</td>
                <td>" . $result['sub_cate_id'] . "</td>
                <td>" . $result['sub_cate_name'] . "</td>
                <td>" . $result['sub_cate_tagline'] . "</td>
                <td>" . $result['sub_cate_description'] . "</td>
                <td><img src='" . $result['sub_cate_image'] . "' alt='Sub-Category Image' class='model-image' data-bs-img='" . $result['sub_cate_image'] . "' style='width: 100px; height: auto;'></td>
                <td><img src='" . $result['sub_cate_banner_image'] . "' alt='Sub-Category-BannerImage' class='model-image' data-bs-img='" . $result['sub_cate_banner_image'] . "' style='width: 100px; height: auto;'></td>
                <td>" . $result['slug_url'] . "</td>
                <td>" . $result['added_on'] . "</td>
                <td>
                    <!-- Three-dot Icon with Dropdown -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['sub_cate_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['sub_cate_id'] . "'>
                            <li><a class='dropdown-item' href='edit-sub-category.php?edit_sub_cate=" . $result['sub_cate_id'] . "'>Edit</a></li>
                            <li><a class='dropdown-item' href='?sub_category_delete=" . $result['sub_cate_id'] . "' onclick='return confirm(\"Are you sure you want to delete this sub-category?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
//****************get sub-category end**************\\

// **********  sub category Delete Start**************\\
if (isset($_GET['sub_category_delete'])) {
    $sub_cate_id = $_GET['sub_category_delete'];
    $delete_sql = "DELETE FROM sub_category WHERE sub_cate_id='$sub_cate_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Sub category deleted successfully'); window.location.href='view-sub-category.php';</script>";
    } else {
        echo "<script>alert('Failed to delete sub category');</script>";
    }
}
//*************** sub category Delete End*******************\\
//**************************************** Update Sub Category ************************************\\
if (isset($_POST['update_sub_category'])) {
    $sub_cate_id = $_POST['sub_cate_id'];
    $parent_cate_id = $_POST['parent_cate_id'];
    $sub_cate_name = mysqli_real_escape_string($conn, $_POST['sub_cate_name']);
    $sub_cate_tagline = mysqli_real_escape_string($conn, $_POST['sub_cate_tagline']);
    $sub_cate_description = mysqli_real_escape_string($conn, $_POST['sub_cate_description']);
    $sub_cate_image = $_POST['current_image']; // Preserve existing image if not updated
    $sub_cate_banner_image = $_POST['current_banner_image']; // Preserve existing image if not updated

    // Sub Category Image code
    if (isset($_FILES['sub_cate_image']) && $_FILES['sub_cate_image']['error'] == 0) {
        $filename = basename($_FILES['sub_cate_image']['name']);
        $tempname = $_FILES['sub_cate_image']['tmp_name'];
        $destination = 'assets/uploads/subcategoryimage/' . $filename;

        // Ensure the directory exists, and move the uploaded file
        if (!is_dir('assets/uploads/subcategoryimage/')) {
            mkdir('assets/uploads/subcategoryimage/', 0777, true);
        }

        if (move_uploaded_file($tempname, $destination)) {
            $sub_cate_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    }
    // Sub Category Image code
    if (isset($_FILES['sub_cate_banner_image']) && $_FILES['sub_cate_banner_image']['error'] == 0) {
        $filename = basename($_FILES['sub_cate_banner_image']['name']);
        $tempname = $_FILES['sub_cate_banner_image']['tmp_name'];
        $destination = 'assets/uploads/subcategorybannerimage/' . $filename;

        // Ensure the directory exists, and move the uploaded file
        if (!is_dir('assets/uploads/subcategorybannerimage/')) {
            mkdir('assets/uploads/subcategorybannerimage/', 0777, true);
        }

        if (move_uploaded_file($tempname, $destination)) {
            $sub_cate_banner_image = $destination;
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
            exit();
        }
    }

    $updated_on = date('Y-m-d H:i:s');
    $slug_url = SlugUrl($sub_cate_name);

    // Update the database
    $sql = "UPDATE sub_category 
            SET parent_cate_id='$parent_cate_id', 
                sub_cate_name='$sub_cate_name', 
                sub_cate_tagline='$sub_cate_tagline', 
                sub_cate_description='$sub_cate_description', 
                sub_cate_image='$sub_cate_image',
                sub_cate_banner_image='$sub_cate_banner_image', 
                slug_url='$slug_url', 
                updated_on='$updated_on' 
            WHERE sub_cate_id='$sub_cate_id'";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script>alert('Updated Successfully'); window.location.href='view-sub-category.php';</script>";
    } else {
        echo "<script>alert('Update Failed'); window.location.href='view-sub-category.php';</script>";
    }
}

//******************************************** Update Sub Category End *******************************\\

// **********************************category section delete*********************************\\










// *************************************job-Section***************************************************************\\

if (isset($_POST['add-job'])) {
    // Include database connection file
    include('db/db-conn.php');

    // Retrieve form data
    $job_id = mt_rand(11111, 99999);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $qualifications = mysqli_real_escape_string($conn, $_POST['qualifications']);
    $responsibilities = mysqli_real_escape_string($conn, $_POST['responsibilities']);
    $benefits = mysqli_real_escape_string($conn, $_POST['benefits']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $job_location = mysqli_real_escape_string($conn, $_POST['job_location']);
    $salary_minimum = mysqli_real_escape_string($conn, $_POST['salary_minumum']);
    $salary_maximum = mysqli_real_escape_string($conn, $_POST['salary_maximum']);
    $posted_on = date('M d, Y');

    // SQL query to insert the data into the database
    $sql = "INSERT INTO job(job_id,job_title, job_description,requirements,experience, qualifications, responsibilities, benefits, job_type, job_location, salary_minimum, salary_maximum,posted_on) 
            VALUES ('$job_id','$job_title', '$job_description','$requirements','$experience', '$qualifications', '$responsibilities', '$benefits', '$job_type', '$job_location', '$salary_minimum', '$salary_maximum','$posted_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Inserted Successfully');
                window.location.href='view-listed-job.php';
              </script>";
    } else {
        echo "<script>alert('Not inserted');</script>";
    }
}

// **********get job start**************** \\
function get_listed_job()
{
    include('db/db-conn.php');
    $sql = "SELECT * FROM job";
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['job_id'] . "</td>
                <td>" . $result['job_title'] . "</td>
                <td>" . $result['job_description'] . "</td>
                <td>" . $result['requirements'] . "</td>
                <td>" . $result['experience'] . "</td>
                <td>" . $result['qualifications'] . "</td>
                <td>" . $result['responsibilities'] . "</td>
                <td>" . $result['benefits'] . "</td>
                <td>" . $result['job_type'] . "</td>
                <td>" . $result['job_location'] . "</td>
                <td>" . $result['salary_minimum'] . "</td>
                <td>" . $result['salary_maximum'] . "</td>
                <td>" . $result['posted_on'] . "</td>
                <td>
                    <!-- Three-dot Icon with Dropdown -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['job_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['job_id'] . "'>
                            <li><a class='dropdown-item' href='edit-listed-job.php?edit=" . $result['job_id'] . "'>Edit</a></li>
                            <li><a class='dropdown-item' href='?listed_job_delete=" . $result['job_id'] . "' onclick='return confirm(\"Are you sure you want to delete this job?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
//***************get job end****************\\

//***************Job Delete Start***********\\
if (isset($_GET['listed_job_delete'])) {
    $job_id = $_GET['listed_job_delete'];
    $delete_sql = "DELETE FROM job WHERE job_id='$job_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Listed Job deleted successfully'); window.location.href='view-listed-job.php';</script>";
    } else {
        echo "<script>alert('Failed to delete Listed Job');</script>";
    }
}
//********Job Delete End************\\


if (isset($_POST['update-job'])) {
    // Include database connection file
    include('db/db-conn.php');

    // Retrieve form data
    $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $qualifications = mysqli_real_escape_string($conn, $_POST['qualifications']);
    $responsibilities = mysqli_real_escape_string($conn, $_POST['responsibilities']);
    $benefits = mysqli_real_escape_string($conn, $_POST['benefits']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $job_location = mysqli_real_escape_string($conn, $_POST['job_location']);
    $salary_minimum = mysqli_real_escape_string($conn, $_POST['salary_minimum']);
    $salary_maximum = mysqli_real_escape_string($conn, $_POST['salary_maximum']);
    $posted_on = date('M d, Y');

    // SQL query to update the job details
    $sql = "UPDATE job SET
                job_title = '$job_title',
                job_description = '$job_description',
                requirements = '$requirements',
                experience = '$experience',
                qualifications = '$qualifications',
                responsibilities = '$responsibilities',
                benefits = '$benefits',
                job_type = '$job_type',
                job_location = '$job_location',
                salary_minimum = '$salary_minimum',
                salary_maximum = '$salary_maximum',
                posted_on = '$posted_on'
            WHERE job_id = '$job_id'";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Updated Successfully');
                window.location.href='view-listed-job.php';
              </script>";
    } else {
        echo "<script>alert('Update Failed');</script>";
    }
}
// ************************************job queries start***********************************\\
if (isset($_POST['job_query'])) {

    // Retrieve form data
    $job_seeker_id = mt_rand(11111, 99999);
    $seeker_name = mysqli_real_escape_string($conn, $_POST['seeker_name']);
    $seeker_number = mysqli_real_escape_string($conn, $_POST['seeker_number']);  // Fixed typo: 'seeker_numnber' to 'seeker_number'
    $seeker_email = mysqli_real_escape_string($conn, $_POST['seeker_email']);


    if (isset($_FILES['seeker_resume'])) {
        $filename = $_FILES['seeker_resume']['name'];
        $tempname = $_FILES['seeker_resume']['tmp_name'];
        $seeker_resume_destination = 'assets/resume/seeker_resume/' . $filename;

        // Get the file extension
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Check if the file is a PDF
        if (strtolower($file_extension) === 'pdf') {
            // Move the uploaded file to the destination directory
            if (move_uploaded_file($tempname, $seeker_resume_destination)) {
                // echo "<script>alert('Resume uploaded successfully');</script>";
            } else {
                echo "<script>alert('Failed to upload resume');</script>";
            }
        } else {
            echo "<script>alert('Please upload a PDF file');</script>";
        }
    } else {
        echo "<script>alert('No file uploaded');</script>";
    }

    $seeker_message = mysqli_real_escape_string($conn, $_POST['seeker_message']);
    $applied_on = date('Y-m-d');  // Using a standard date format for storing in the database

    // SQL query to insert the data into the database
    $sql = "INSERT INTO job_seekers (job_seeker_id, seeker_name, seeker_number, seeker_email, seeker_resume, seeker_message, applied_on) 
            VALUES ('$job_seeker_id', '$seeker_name', '$seeker_number', '$seeker_email', '$seeker_resume_destination', '$seeker_message', '$applied_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
            alert('Your application has been submitted successfully! We will contact you shortly.');
            window.location.href='../careers.php';
          </script>";
    } else {
        echo "<script>alert('There was an issue submitting your application. Please try again.');</script>";
    }
}
// **********************get job seeker enquiry start*******************\\
function get_job_seekers()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM job_seekers"; // Assuming your table is named 'job_seekers'
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['job_seeker_id'] . "</td>
                <td>" . $result['seeker_name'] . "</td>
                <td>" . $result['seeker_email'] . "</td>
                <td>" . $result['seeker_number'] . "</td>
                <td>" . $result['seeker_message'] . "</td>
                <td>
                    <a href='" . $result['seeker_resume'] . "' target='_blank' class='btn btn-primary btn-sm'>👁️</a>
                    <a href='" . $result['seeker_resume'] . "' download class='btn btn-secondary btn-sm'>Download</a>
                </td>
                <td>" . $result['applied_on'] . "</td>
                <td>
                    <form method='post' action='seeker-status.php'>
                        <input type='hidden' name='job_seeker_id' value='" . $result['job_seeker_id'] . "'>
                        <select name='status' onchange='this.form.submit()'>
                            <option value='Pending' " . ($result['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                            <option value='Reviewed' " . ($result['status'] == 'Reviewed' ? 'selected' : '') . ">Reviewed</option>
                            <option value='Shortlisted' " . ($result['status'] == 'Shortlisted' ? 'selected' : '') . ">Shortlisted</option>
                            <option value='Rejected' " . ($result['status'] == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                        </select>
                    </form>
                </td>
                <td>
                    <!-- Action Buttons -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['job_seeker_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['job_seeker_id'] . "'>
                            <li><a class='dropdown-item' href='view-test-ride-request.php?id=" . $result['job_seeker_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?job_seeker_id=" . $result['job_seeker_id'] . "' onclick='return confirm(\"Are you sure you want to delete this candidate resume?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
// **********************get job seeker enquiry end*******************\\

//***************job query delete Start***********\\
if (isset($_GET['job_seeker_id'])) {
    $job_seeker_id = $_GET['job_seeker_id'];
    $delete_sql = "DELETE FROM job_seekers WHERE job_seeker_id='$job_seeker_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Listed Job Candidate details deleted successfully'); window.location.href='view-job-queries.php';</script>";
    } else {
        echo "<script>alert('Failed to delete Listed Job Seekers Detail');</script>";
    }
}
//********job query  delete End************\\

// ************************************job queries start***********************************\\
if (isset($_POST['job_apply'])) {

    // Retrieve form data
    $job_applier_id = mt_rand(11111, 99999);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $applier_name = mysqli_real_escape_string($conn, $_POST['applier_name']);
    $applier_number = mysqli_real_escape_string($conn, $_POST['applier_number']);  // Fixed typo: 'seeker_numnber' to 'seeker_number'
    $applier_email = mysqli_real_escape_string($conn, $_POST['applier_email']);


    if (isset($_FILES['applier_resume'])) {
        $filename = $_FILES['applier_resume']['name'];
        $tempname = $_FILES['applier_resume']['tmp_name'];
        $applier_resume_destination = 'assets/resume/applier_resume/' . $filename;

        // Get the file extension
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Check if the file is a PDF
        if (strtolower($file_extension) === 'pdf') {
            // Move the uploaded file to the destination directory
            if (move_uploaded_file($tempname, $applier_resume_destination)) {
                // echo "<script>alert('Resume uploaded successfully');</script>";
            } else {
                echo "<script>alert('Failed to upload resume');</script>";
            }
        } else {
            echo "<script>alert('Please upload a PDF file');</script>";
        }
    } else {
        echo "<script>alert('No file uploaded');</script>";
    }

    $applier_message = mysqli_real_escape_string($conn, $_POST['applier_message']);
    $applied_on = date('Y-m-d');  // Using a standard date format for storing in the database

    // SQL query to insert the data into the database
    $sql = "INSERT INTO job_appliers (job_applier_id,job_title, applier_name, applier_number, applier_email, applier_resume, applier_message, applied_on) 
            VALUES ('$job_applier_id','$job_title', '$applier_name', '$applier_number', '$applier_email', '$applier_resume_destination', '$applier_message', '$applied_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
            alert('Your application has been submitted successfully! We will contact you shortly.');
            window.location.href='../careers.php';
          </script>";
    } else {
        echo "<script>alert('There was an issue submitting your application. Please try again.');</script>";
    }
}
// **********************get job seeker enquiry start*******************\\
function get_job_appliers()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM job_appliers"; // Assuming your table is named 'job_seekers'
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['job_applier_id'] . "</td>
                <td>" . $result['job_title'] . "</td>
                <td>" . $result['applier_name'] . "</td>
                <td>" . $result['applier_email'] . "</td>
                <td>" . $result['applier_number'] . "</td>
                <td>" . $result['applier_message'] . "</td>
                <td>
                    <a href='" . $result['applier_resume'] . "' target='_blank' class='btn btn-primary btn-sm'>👁️</a>
                    <a href='" . $result['applier_resume'] . "' download class='btn btn-secondary btn-sm'>Download</a>
                </td>
                <td>" . $result['applied_on'] . "</td>
                <td>
                    <form method='post' action='applier-status.php'>
                        <input type='hidden' name='job_applier_id' value='" . $result['job_applier_id'] . "'>
                        <select name='status' onchange='this.form.submit()'>
                            <option value='Pending' " . ($result['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                            <option value='Reviewed' " . ($result['status'] == 'Reviewed' ? 'selected' : '') . ">Reviewed</option>
                            <option value='Shortlisted' " . ($result['status'] == 'Shortlisted' ? 'selected' : '') . ">Shortlisted</option>
                            <option value='Rejected' " . ($result['status'] == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                        </select>
                    </form>
                </td>
                <td>
                    <!-- Action Buttons -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['job_applier_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['job_applier_id'] . "'>
                            <li><a class='dropdown-item' href='view-test-ride-request.php?id=" . $result['job_applier_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?job_applier_id=" . $result['job_applier_id'] . "' onclick='return confirm(\"Are you sure you want to delete this candidate resume?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
// **********************get job seeker enquiry end*******************\\

//***************job query delete Start***********\\
if (isset($_GET['job_applier_id'])) {
    $job_applier_id = $_GET['job_applier_id'];
    $delete_sql = "DELETE FROM job_appliers WHERE job_applier_id='$job_applier_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert(' Candidate details deleted successfully'); window.location.href='view-job-applier.php';</script>";
    } else {
        echo "<script>alert('Failed to delete Candidate Detail');</script>";
    }
}
//********job query  delete End************\\


//**************************************job section end**********************************************

// *********************************customer enquiry***********************

if (isset($_POST['customer-enquiry'])) {

    // Retrieve form data and escape to prevent SQL injection
    $enquiry_id = rand(1111, 9999);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_phone = mysqli_real_escape_string($conn, $_POST['customer_phone']);
    $customer_message = mysqli_real_escape_string($conn, $_POST['customer_message']);
    $enquiry_on = date('M d, Y');
    $sql = "INSERT INTO customer_enquiry (enquiry_id, customer_name, customer_email, customer_phone, customer_message,enquiry_on) 
            VALUES ('$enquiry_id', '$customer_name', '$customer_email', '$customer_phone', '$customer_message','$enquiry_on')";

    $check = mysqli_query($conn, $sql);
    if ($check) {
        echo "<script type='text/javascript'>
                alert('Thank you for your enquiry! We will get back to you soon.');
               
              </script>";
    } else {
        echo "<script>alert('There was an error processing your enquiry. Please try again later.');</script>";
    }
}

function get_customer_enquiry()
{
    include('db/db-conn.php'); // Ensure the database connection is included

    // SQL query to fetch all customer enquiries
    $sql = "SELECT * FROM customer_enquiry ORDER BY created_at DESC";
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    // Loop through each enquiry and display in a table row
    while ($result = mysqli_fetch_assoc($check)) {
        $trimmed_message = strlen($result['customer_message']) > 50 ? substr($result['customer_message'], 0, 50) . "..." : $result['customer_message'];

        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['enquiry_id'] . "</td>
                <td>" . $result['customer_name'] . "</td>
                <td>" . $result['customer_email'] . "</td>
                <td>" . $result['customer_phone'] . "</td>
                <td>" . $trimmed_message . "</td>
                <td>" . $result['enquiry_on'] . "</td>
                <td>
                    <!-- Three-dot Icon with Dropdown -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['enquiry_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['enquiry_id'] . "'>
                            <li><a class='dropdown-item' href='view-enquiry.php?id=" . $result['enquiry_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?enquiry_delete=" . $result['enquiry_id'] . "' onclick='return confirm(\"Are you sure you want to delete this enquiry?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}

// ********** Enquiry Delete Start**************\\
if (isset($_GET['enquiry_delete'])) {
    $enquiry_id = $_GET['enquiry_delete'];
    $delete_sql = "DELETE FROM customer_enquiry WHERE enquiry_id='$enquiry_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Enquiry deleted successfully'); window.location.href='view-customer-enquiry.php';</script>";
    } else {
        echo "<script>alert('Failed to delete category');</script>";
    }
}
//***************enquiry Delete End*******************\\









//***************************dealers enquiry**********************************
// ************************dealers enquiry set start*****************
if (isset($_POST['become_dealer'])) {
    // Retrieve form data
    $dealer_enquiry_id = rand(1111, 9999);
    $name = $_POST['dealer_name'];
    $email = $_POST['dealer_email'];
    $mobile = $_POST['mobile'];
    $current_business = $_POST['dealer_business'];
    $investment_amount = $_POST['dealer_investment'];
    $exp_in_automobile = $_POST['dealer_experience'];
    $turnover_business = $_POST['dealer_turnover'];
    $pincode = $_POST['dealer_pincode'];
    $state = $_POST['dealer_state'];
    $city = $_POST['dealer_city'];

    // Prepare SQL query
    $sql = "INSERT INTO dealer_enquiry (dealer_enquiry_id,name, email, mobile, current_business, investment_amount, exp_in_automobile_industry, turnover_of_current_business, pincode, state, city) 
            VALUES ('$dealer_enquiry_id','$name', '$email', '$mobile', '$current_business', '$investment_amount', '$exp_in_automobile', '$turnover_business', '$pincode', '$state', '$city')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Dealer information submitted successfully! We'll get in touch soon.'); window.location.href='../dealership.php';</script>";
    } else {
        echo "<script>alert('Failed to submit your details. Please try again later or contact support for assistance.'); window.location.href='../dealership.php';</script>";
    }

    // Close database connection
    mysqli_close($conn);
}
// ************************dealers enquiry set end**************************
// ***********************get dealer enquiry start*****************
function get_dealer_enquiry()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM dealer_enquiry"; // Assuming your table is named 'dealer_enquiry'
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['dealer_enquiry_id'] . "</td>
                <td>" . $result['name'] . "</td>
                <td>" . $result['email'] . "</td>
                <td>" . $result['mobile'] . "</td>
                <td>" . $result['current_business'] . "</td>
                <td>" . $result['investment_amount'] . "</td>
                <td>" . $result['exp_in_automobile_industry'] . "</td>
                <td>" . $result['turnover_of_current_business'] . "</td>
                <td>" . $result['pincode'] . "</td>
                <td>" . $result['state'] . "</td>
                <td>" . $result['city'] . "</td>
                <td>" . $result['created_at'] . "</td>
                <td>
                    <!-- Action Buttons -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['dealer_enquiry_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['dealer_enquiry_id'] . "'>
                            <li><a class='dropdown-item' href='view-dealer-enquiry.php?id=" . $result['dealer_enquiry_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?dealer_enquiry_delete=" . $result['dealer_enquiry_id'] . "' onclick='return confirm(\"Are you sure you want to delete this enquiry?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
// ***********************get dealer enquiry end*****************
// ********** Enquiry Delete Start**************\\
if (isset($_GET['dealer_enquiry_delete'])) {
    $dealer_enquiry_id = $_GET['dealer_enquiry_delete'];
    $delete_sql = "DELETE FROM dealer_enquiry WHERE dealer_enquiry_id='$dealer_enquiry_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Dealer Enquiry deleted successfully'); window.location.href='view-dealers-enquiry.php';</script>";
    } else {
        echo "<script>alert('Failed to delete Enquiry');</script>";
    }
}
//***************enquiry Delete End*******************\\

// ***********************get dealer end*****************





// ************************catalogue enquiry set start*****************
if (isset($_POST['catalogue'])) {
    // Retrieve form data
    $catalogue_enquiry_id = rand(1111, 9999);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Prepare SQL query
    $sql = "INSERT INTO catalogue_enquiry (catalogue_enquiry_id, name, email, mobile, pincode, state, city) 
            VALUES ('$catalogue_enquiry_id', '$name', '$email', '$mobile', '$pincode', '$state', '$city')";

    // Execute query
    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('Catalogue request has been successfully submitted!'); window.location.href='../catalogue.php';</script>";
    } else {

        echo "<script>alert('Failed to Download Catalogue');</script>";
    }


    // Close database connection
    mysqli_close($conn);
}
// ************************catalogue enquiry set end**************************
// ***********************get catalogue enquiry start*****************
function get_catalogue_enquiry()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM catalogue_enquiry"; // Assuming your table is named 'catalogue_enquiry'
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['catalogue_enquiry_id'] . "</td>
                <td>" . $result['name'] . "</td>
                <td>" . $result['email'] . "</td>
                <td>" . $result['mobile'] . "</td>
                <td>" . $result['pincode'] . "</td>
                <td>" . $result['state'] . "</td>
                <td>" . $result['city'] . "</td>
                <td>" . $result['created_at'] . "</td>
                <td>
                    <!-- Action Buttons -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['catalogue_enquiry_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['catalogue_enquiry_id'] . "'>
                            <li><a class='dropdown-item' href='view-catalogue-enquiry.php?id=" . $result['catalogue_enquiry_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?catalogue_enquiry_delete=" . $result['catalogue_enquiry_id'] . "' onclick='return confirm(\"Are you sure you want to delete this enquiry?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
// ***********************get catalogue enquiry end*****************
// ********** catalogue Enquiry Delete Start**************\\
if (isset($_GET['catalogue_enquiry_delete'])) {
    $catalogue_enquiry_id = $_GET['catalogue_enquiry_delete'];
    $delete_sql = "DELETE FROM catalogue_enquiry WHERE catalogue_enquiry_id='$catalogue_enquiry_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Catalogue enquiry deleted successfully'); window.location.href='view-catalogue-enquiry.php';</script>";
    } else {
        echo "<script>alert('Failed to delete enquiry');</script>";
    }
}
//***************catalogue enquiry Delete End*******************\\

// *****************************catalogue section end************************************************\\

// **************************************test ride section start***************************************\\
// **********************add test ride enquiry*******************\\
if (isset($_POST['test_ride'])) {
    // Retrieve form data
    $test_ride_id = rand(1111, 9999);
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_number = $_POST['customer_number'];
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_category = $_POST['vehicle_category'];
    $vehicle_model = $_POST['vehicle_model'];
    $test_ride_date = $_POST['test_ride_date'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Prepare SQL query to insert data into database
    $sql = "INSERT INTO test_ride_requests (test_ride_id,customer_name, customer_email, customer_number, vehicle_type, vehicle_category, vehicle_model, test_ride_date, pincode, state, city) 
            VALUES ('$test_ride_id','$customer_name', '$customer_email', '$customer_number', '$vehicle_type', '$vehicle_category', '$vehicle_model', '$test_ride_date', '$pincode', '$state', '$city')";

    // Execute query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Your test ride request has been successfully submitted! We will contact you shortly.'); window.location.href='../test-ride.php';</script>";
    } else {
        echo "<script>alert('Failed to submit your details. Please try again later or contact support for assistance.'); window.location.href='../test-ride.php';</script>";
    }


    // Close database connection
    mysqli_close($conn);
}

// **********************add test ride enquiry end*******************\\
// **********************get test ride enquiry*******************\\
function get_test_ride()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM test_ride_requests"; // Assuming your table is named 'test_ride_requests'
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['test_ride_id'] . "</td>
                <td>" . $result['customer_name'] . "</td>
                <td>" . $result['customer_email'] . "</td>
                <td>" . $result['customer_number'] . "</td>
                <td>" . $result['vehicle_type'] . "</td>
                <td>" . $result['vehicle_category'] . "</td>
                <td>" . $result['vehicle_model'] . "</td>
                <td>" . $result['test_ride_date'] . "</td>
                <td>" . $result['pincode'] . "</td>
                <td>" . $result['state'] . "</td>
                <td>" . $result['city'] . "</td>
                <td>" . $result['created_at'] . "</td>
                <td>
                    <!-- Action Buttons -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['test_ride_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['test_ride_id'] . "'>
                            <li><a class='dropdown-item' href='view-test-ride-request.php?id=" . $result['test_ride_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?test_ride_delete=" . $result['test_ride_id'] . "' onclick='return confirm(\"Are you sure you want to delete this test ride request?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}
// **********************get test ride enquiry end*******************\\
// ********** test ride Enquiry Delete Start**************\\
if (isset($_GET['test_ride_delete'])) {
    $test_ride_id = $_GET['test_ride_delete'];
    $delete_sql = "DELETE FROM test_ride_requests WHERE test_ride_id='$test_ride_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('test ride enquiry deleted successfully'); window.location.href='view-test-ride-enquiry.php';</script>";
    } else {
        echo "<script>alert('Failed to delete enquiry');</script>";
    }
}
//***************test ride enquiry Delete End*******************\\


// ***********************Registraion*****************************\\
// *******************************warranty Registration*****************************************\\
// **********************add warranty registration*******************\\
if (isset($_POST['register_warranty'])) {
    // Retrieve form data
    $registration_id = rand(1111, 9999);
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_number = $_POST['customer_number'];
    $vehicle_type = $_POST['vehicle_type'];
    $category_type = $_POST['category_type'];
    $model_type = $_POST['model_type'];
    $purchase_date = $_POST['purchase_date'];
    $customer_address = $_POST['customer_address'];
    $dealer_name = $_POST['dealer_name'];
    $dealer_address = $_POST['dealer_address'];
    $dealer_pincode = $_POST['dealer_pincode'];
    $dealer_state = $_POST['dealer_state'];
    $dealer_city = $_POST['dealer_city'];

    // Prepare SQL query to insert data into database
    $sql = "INSERT INTO warranty_registrations (registration_id, customer_name, customer_email, customer_number, vehicle_type, category_type, model_type, purchase_date, customer_address, dealer_name, dealer_address, dealer_pincode, dealer_state, dealer_city) 
            VALUES ('$registration_id', '$customer_name', '$customer_email', '$customer_number', '$vehicle_type', '$category_type', '$model_type', '$purchase_date', '$customer_address', '$dealer_name', '$dealer_address', '$dealer_pincode', '$dealer_state', '$dealer_city')";

    // Execute query
    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('Warranty registration has been successfully submitted!'); window.location.href='../warranty-register.php';</script>";
    } else {
        echo "<script>alert('Warranty registration Failed!'); window.location.href='../warranty-register.php';</script>";
    }

    // Close database connection
    mysqli_close($conn);
}
// **********************add warranty registration end*******************\\
// **********************get warranty registrations*******************\\
function get_warranty_registrations()
{
    include('db/db-conn.php');

    $sql = "SELECT * FROM warranty_registrations";
    $check = mysqli_query($conn, $sql);
    $sno = 1;

    while ($result = mysqli_fetch_assoc($check)) {
        echo "<tr>
                <td>" . $sno++ . "</td>
                <td>" . $result['registration_id'] . "</td>
                <td>" . $result['customer_name'] . "</td>
                <td>" . $result['customer_email'] . "</td>
                <td>" . $result['customer_number'] . "</td>
                <td>" . $result['vehicle_type'] . "</td>
                <td>" . $result['category_type'] . "</td>
                <td>" . $result['model_type'] . "</td>
                <td>" . $result['purchase_date'] . "</td>
                <td>" . $result['customer_address'] . "</td>
                <td>" . $result['dealer_name'] . "</td>
                <td>" . $result['dealer_address'] . "</td>
                <td>" . $result['dealer_pincode'] . "</td>
                <td>" . $result['dealer_state'] . "</td>
                <td>" . $result['dealer_city'] . "</td>
                <td>
                    <form method='post' action='registration-status.php'>
                        <input type='hidden' name='registration_id' value='" . $result['registration_id'] . "'>
                        <select name='status' onchange='this.form.submit()'>
                            <option value='Pending' " . ($result['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                            <option value='Approved' " . ($result['status'] == 'Approved' ? 'selected' : '') . ">Approved</option>
                            <option value='Rejected' " . ($result['status'] == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                        </select>
                    </form>
                </td>
                <td>" . $result['created_at'] . "</td>
                <td>
                    <!-- Action Buttons -->
                    <div class='dropdown'>
                        <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton" . $result['registration_id'] . "' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='bi bi-three-dots'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton" . $result['registration_id'] . "'>
                            <li><a class='dropdown-item' href='view-warranty-request.php?id=" . $result['registration_id'] . "'>View</a></li>
                            <li><a class='dropdown-item' href='?warranty_delete=" . $result['registration_id'] . "' onclick='return confirm(\"Are you sure you want to delete this warranty registration?\");'>Delete</a></li>
                        </ul>
                    </div>
                </td>
              </tr>";
    }
}



// **********************get warranty registrations end*******************\\
// ********** warranty registration Delete Start**************\\
if (isset($_GET['warranty_delete'])) {
    $registration_id = $_GET['warranty_delete'];
    $delete_sql = "DELETE FROM warranty_registrations WHERE registration_id='$registration_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Warranty registration deleted successfully'); window.location.href='view-registered-warranty.php';</script>";
    } else {
        echo "<script>alert('Failed to delete registration');</script>";
    }
}
//***************warranty registration Delete End*******************\\
//*************************************************************** model*************************************** */
// ***********add mode *******************\\
if (isset($_POST['add-model'])) {
    // Generate a random model ID
    $model_id = mt_rand(11111, 99999);

    // Retrieve form data
    $pro_cate = $_POST['pro_cate'];
    $pro_sub_cate = $_POST['pro_sub_cate'];
    $pro_name = $_POST['pro_name'];
    $tagline = $_POST['tagline'];
    $model_desc = $_POST['model_desc'];
    $battery_type = $_POST['battery_type'];
    $battery_kwh = $_POST['battery_kwh'];
    $motor_type = $_POST['motor_type'];
    $charger_type = $_POST['charger_type'];
    $charging_time = $_POST['charging_time'];
    $wheel_size = $_POST['wheel_size'];
    $thief_lock = $_POST['thief_lock'];
    $side_stand_sensor = $_POST['side_stand_sensor'];
    $drl_light = $_POST['drl_light'];
    $reverse_mode = $_POST['reverse_mode'];
    $parking_mode = $_POST['parking_mode'];
    $anti_theft_wheel_lock = $_POST['anti_theft_wheel_lock'];
    $anty_theft_alarm = $_POST['anty_theft_alarm'];
    $smart_break_down_assistance = $_POST['smart_break_down_assistance'];
    $ladies_foot_rest = $_POST['ladies_foot_rest'];
    $drive_mode = $_POST['drive_mode'];
    $speed = $_POST['speed'];
    $driving_licence_and_registration_required = $_POST['driving_licence_and_registration_required'];
    $warranty = $_POST['warranty'];
    $chassis_warranty = $_POST['chassis_warranty'];
    $first_video_link = $_POST['first_video_link'];
    $second_video_link = $_POST['second_video_link'];

    // Initialize an array to store the paths of the uploaded images
    $model_images = [];

    // Handle image uploads for the model images
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_FILES['model_image' . $i]) && $_FILES['model_image' . $i]['error'] == 0) {
            $filename = $_FILES['model_image' . $i]['name'];
            $tempname = $_FILES['model_image' . $i]['tmp_name'];
            $destination = 'assets/uploads/modelimage/' . $filename;

            if (move_uploaded_file($tempname, $destination)) {
                // Store the image path in the array
                $model_images[$i] = $destination;
            } else {
                echo "<script>alert('Failed to upload image $i.');</script>";
                exit();
            }
        } else {
            $model_images[$i] = ''; // Set empty string if the image is not uploaded
            echo "<script>alert('Image $i is not uploaded.');</script>";
        }
    }

    // Handle video thumbnails
    if (isset($_FILES['first_video_thumbnail'])) {
        $first_video_thumbnail_filename = $_FILES['first_video_thumbnail']['name'];
        $first_video_thumbnail_tempname = $_FILES['first_video_thumbnail']['tmp_name'];
        $first_video_thumbnail_destination = 'assets/uploads/thumbnail/' . $first_video_thumbnail_filename;

        if (!move_uploaded_file($first_video_thumbnail_tempname, $first_video_thumbnail_destination)) {
            echo "<script>alert('Failed to upload the first video thumbnail.');</script>";
            exit();
        }
    } else {
        $first_video_thumbnail_destination = ''; // Set empty string if the thumbnail is not uploaded
        echo "<script>alert('First video thumbnail is not uploaded.');</script>";
    }

    if (isset($_FILES['second_video_thumbnail'])) {
        $second_video_thumbnail_filename = $_FILES['second_video_thumbnail']['name'];
        $second_video_thumbnail_tempname = $_FILES['second_video_thumbnail']['tmp_name'];
        $second_video_thumbnail_destination = 'assets/uploads/thumbnail/' . $second_video_thumbnail_filename;

        if (!move_uploaded_file($second_video_thumbnail_tempname, $second_video_thumbnail_destination)) {
            echo "<script>alert('Failed to upload the second video thumbnail.');</script>";
            exit();
        }
    } else {
        $second_video_thumbnail_destination = ''; // Set empty string if the thumbnail is not uploaded
        echo "<script>alert('Second video thumbnail is not uploaded.');</script>";
    }

    // SQL query to insert data into the model table, including image paths
    $sql = "INSERT INTO model (
                model_id, pro_cate, pro_sub_cate, pro_name, tagline, model_desc,
                battery_type, battery_kwh, motor_type, charger_type, charging_time,
                wheel_size, thief_lock, side_stand_sensor, drl_light, reverse_mode,
                parking_mode,anti_theft_wheel_lock, anty_theft_alarm, smart_break_down_assistance,
                ladies_foot_rest, drive_mode, speed,driving_licence_and_registration_required, warranty, chassis_warranty,
                first_video_link, second_video_link, first_video_thumbnail,
                second_video_thumbnail, model_image1, model_image2, model_image3,
                model_image4, model_image5, model_image6
            ) VALUES (
                '$model_id', '$pro_cate', '$pro_sub_cate', '$pro_name', '$tagline', '$model_desc',
                '$battery_type', '$battery_kwh', '$motor_type', '$charger_type', '$charging_time',
                '$wheel_size', '$thief_lock', '$side_stand_sensor', '$drl_light', '$reverse_mode',
                '$parking_mode','$anti_theft_wheel_lock', '$anty_theft_alarm', '$smart_break_down_assistance',
                '$ladies_foot_rest', '$drive_mode', '$speed','$driving_licence_and_registration_required', '$warranty', '$chassis_warranty',
                '$first_video_link', '$second_video_link', '$first_video_thumbnail_destination',
                '$second_video_thumbnail_destination', '{$model_images[1]}', '{$model_images[2]}',
                '{$model_images[3]}', '{$model_images[4]}', '{$model_images[5]}', '{$model_images[6]}'
            )";

    // Execute the query and check for errors
    $check = mysqli_query($conn, $sql);

    if ($check) {
        echo "<script type='text/javascript'>
                alert('Inserted Successfully');
                window.location.href='view-model.php';
              </script>";
    } else {
        // Display SQL error
        echo "<script>alert('Failed to insert data: " . mysqli_error($conn) . "');</script>";
    }
}




// ***********************add model end*******************************************\\

// **********get model/ view model******************\\
function get_model()
{
    global $conn;

    // Update the SQL query to join with the categories and sub_categories tables
    $sql = "SELECT m.*, c.cate_name AS pro_cate_name, sc.sub_cate_name AS pro_sub_cate_name
            FROM model m
            LEFT JOIN category c ON m.pro_cate = c.cate_id
            LEFT JOIN sub_category sc ON m.pro_sub_cate = sc.sub_cate_id";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $output = "";
    $counter = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
            <td>{$counter}</td>
            <td>{$row['pro_cate_name']}</td> <!-- Display parent category name -->
            <td>{$row['pro_sub_cate_name']}</td> <!-- Display subcategory name -->
            <td>{$row['model_id']}</td>
            <td>{$row['pro_name']}</td>
            <td>{$row['tagline']}</td>
            <td><img src='{$row['model_image1']}' alt='Image 1' style='width: 100px;'></td>
            <td><img src='{$row['model_image2']}' alt='Image 2' style='width: 100px;'></td>
            <td><img src='{$row['model_image3']}' alt='Image 3' style='width: 100px;'></td>
            <td><img src='{$row['model_image4']}' alt='Image 4' style='width: 100px;'></td>
            <td><img src='{$row['model_image5']}' alt='Image 5' style='width: 100px;'></td>
            <td>{$row['battery_type']}</td>
            <td>{$row['motor_type']}</td>
            <td>{$row['charger_type']}</td>
            <td>{$row['charging_time']}</td>
            <td>{$row['speed']}</td>
            <td>{$row['wheel_size']}</td>
            <td>{$row['thief_lock']}</td>
            <td>{$row['side_stand_sensor']}</td>
            <td>{$row['drl_light']}</td>
            <td>{$row['reverse_mode']}</td>
            <td>{$row['parking_mode']}</td>
            <td>{$row['anti_theft_wheel_lock']}</td>
            <td>{$row['anty_theft_alarm']}</td>
            <td>{$row['smart_break_down_assistance']}</td>
            <td>{$row['ladies_foot_rest']}</td>
            <td>{$row['drive_mode']}</td>
            <td>{$row['driving_licence_and_registration_required']}</td>
            <td>{$row['warranty']}</td>
            <td>{$row['chassis_warranty']}</td>
            
            <td><img src='{$row['first_video_thumbnail']}' alt='First Video Thumbnail' style='width: 100px;'></td>
            <td><img src='{$row['second_video_thumbnail']}' alt='Second Video Thumbnail' style='width: 100px;'></td>
            <td>{$row['model_desc']}</td>
            <td>
                <div class='dropdown'>
                    <button class='btn btn-link p-0 m-0' type='button' id='dropdownMenuButton{$row['model_id']}' data-bs-toggle='dropdown' aria-expanded='false'>
                        <i class='bi bi-three-dots'></i>
                    </button>
                    <ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton{$row['model_id']}'>
                        <li><a class='dropdown-item' href='edit-model.php?id={$row['model_id']}'>Edit</a></li>
                        <li><a class='dropdown-item' href='?model_delete=" . $row['model_id'] . "' onclick='return confirm(\"Are you sure you want to delete this model?\");'>Delete</a></li>
                        
                    </ul>
                </div>
            </td>
        </tr>";
        $counter++;
    }

    return $output;
}

//**************************get model end/view model end**************************\\

// ********** model Delete Start**************\\
if (isset($_GET['model_delete'])) {
    $model_id = $_GET['model_delete'];
    $delete_sql = "DELETE FROM model WHERE model_id='$model_id'";
    $delete_result = mysqli_query($conn, $delete_sql);

    if ($delete_result) {
        echo "<script>alert('Model deleted successfully'); window.location.href='view-model.php';</script>";
    } else {
        echo "<script>alert('Failed to delete model');</script>";
    }
}

//***************model Delete End*******************\\

//update model pending 
// *****************************update model start****************************\\
// Update model data upon form submission
if (isset($_POST['update-model'])) {
    // Retrieve form data
    $pro_cate = $_POST['pro_cate'];
    $pro_sub_cate = $_POST['pro_sub_cate'];
    $pro_name = $_POST['pro_name'];
    $tagline = $_POST['tagline'];
    $model_desc = $_POST['model_desc'];
    $battery_type = $_POST['battery_type'];
    $battery_kwh = $_POST['battery_kwh'];
    $motor_type = $_POST['motor_type'];
    $charger_type = $_POST['charger_type'];
    $charging_time = $_POST['charging_time'];
    $wheel_size = $_POST['wheel_size'];
    $thief_lock = $_POST['thief_lock'];
    $side_stand_sensor = $_POST['side_stand_sensor'];
    $drl_light = $_POST['drl_light'];
    $reverse_mode = $_POST['reverse_mode'];
    $parking_mode = $_POST['parking_mode'];
    $anti_theft_wheel_lock = $_POST['anti_theft_wheel_lock'];
    $anty_theft_alarm = $_POST['anty_theft_alarm'];
    $smart_break_down_assistance = $_POST['smart_break_down_assistance'];
    $ladies_foot_rest = $_POST['ladies_foot_rest'];
    $drive_mode = $_POST['drive_mode'];
    $speed = $_POST['speed'];
    $driving_licence_and_registration_required = $_POST['driving_licence_and_registration_required'];
    $warranty = $_POST['warranty'];
    $chassis_warranty = $_POST['chassis_warranty'];
    $first_video_link = $_POST['first_video_link'];
    $second_video_link = $_POST['second_video_link'];

    // Initialize an array to store the paths of the uploaded images
    $model_images = [];

    // Handle image uploads for the model images
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_FILES['model_image' . $i]) && $_FILES['model_image' . $i]['error'] == 0) {
            $filename = $_FILES['model_image' . $i]['name'];
            $tempname = $_FILES['model_image' . $i]['tmp_name'];
            $destination = 'assets/uploads/modelimage/' . $filename;

            if (move_uploaded_file($tempname, $destination)) {
                // Store the image path in the array
                $model_images[$i] = $destination;
            } else {
                $model_images[$i] = $row['model_image' . $i]; // Keep the existing image if upload fails
            }
        } else {
            $model_images[$i] = $row['model_image' . $i]; // Keep the existing image if not uploaded
        }
    }

    // Handle video thumbnails
    if (isset($_FILES['first_video_thumbnail']) && $_FILES['first_video_thumbnail']['error'] == 0) {
        $first_video_thumbnail_filename = $_FILES['first_video_thumbnail']['name'];
        $first_video_thumbnail_tempname = $_FILES['first_video_thumbnail']['tmp_name'];
        $first_video_thumbnail_destination = 'assets/uploads/thumbnail/' . $first_video_thumbnail_filename;

        if (move_uploaded_file($first_video_thumbnail_tempname, $first_video_thumbnail_destination)) {
            $first_video_thumbnail = $first_video_thumbnail_destination;
        }
    }

    if (isset($_FILES['second_video_thumbnail']) && $_FILES['second_video_thumbnail']['error'] == 0) {
        $second_video_thumbnail_filename = $_FILES['second_video_thumbnail']['name'];
        $second_video_thumbnail_tempname = $_FILES['second_video_thumbnail']['tmp_name'];
        $second_video_thumbnail_destination = 'assets/uploads/thumbnail/' . $second_video_thumbnail_filename;

        if (move_uploaded_file($second_video_thumbnail_tempname, $second_video_thumbnail_destination)) {
            $second_video_thumbnail = $second_video_thumbnail_destination;
        }
    }

    // SQL query to update the model
    $sql = "UPDATE model SET 
            pro_cate = '$pro_cate', 
            pro_sub_cate = '$pro_sub_cate', 
            pro_name = '$pro_name', 
            tagline = '$tagline', 
            model_desc = '$model_desc',
            battery_type = '$battery_type', 
            battery_kwh = '$battery_kwh', 
            motor_type = '$motor_type', 
            charger_type = '$charger_type', 
            charging_time = '$charging_time',
            wheel_size = '$wheel_size', 
            thief_lock = '$thief_lock', 
            side_stand_sensor = '$side_stand_sensor', 
            drl_light = '$drl_light', 
            reverse_mode = '$reverse_mode',
            parking_mode = '$parking_mode', 
            anti_theft_wheel_lock = '$anti_theft_wheel_lock', 
            anty_theft_alarm = '$anty_theft_alarm', 
            smart_break_down_assistance = '$smart_break_down_assistance',
            ladies_foot_rest = '$ladies_foot_rest', 
            drive_mode = '$drive_mode', 
            speed = '$speed', 
            driving_licence_and_registration_required = '$driving_licence_and_registration_required',
            warranty = '$warranty', 
            chassis_warranty = '$chassis_warranty', 
            first_video_link = '$first_video_link', 
            second_video_link = '$second_video_link', 
            first_video_thumbnail = '$first_video_thumbnail',
            second_video_thumbnail = '$second_video_thumbnail', 
            model_image1 = '{$model_images[1]}', 
            model_image2 = '{$model_images[2]}', 
            model_image3 = '{$model_images[3]}',
            model_image4 = '{$model_images[4]}', 
            model_image5 = '{$model_images[5]}', 
            model_image6 = '{$model_images[6]}'
            WHERE model_id = '$model_id'";

    $check = mysqli_query($conn, $sql);

    if ($check) {
        echo "<script>alert('Model updated successfully'); window.location.href='view-model.php';</script>";
    } else {
        echo "<script>alert('Error updating model'); window.location.href='edit-model.php?id=$model_id';</script>";
    }
}

// **********model Update End**************\\
// *****************************************model end***********************************************


?>