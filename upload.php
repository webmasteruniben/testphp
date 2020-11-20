<?php 

    defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

    defined("DB_HOST") ? null : define("DB_HOST", "localhost:3306");
    defined("DB_USER") ? null : define("DB_USER", "root");
    defined("DB_PASS") ? null : define("DB_PASS", "Pa55w0rd@1");
    defined("DB_NAME") ? null : define("DB_NAME", "admin_test_data");

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    echo "submit " . $_POST['submit'];
    
    if(isset($_POST['submit'])) {

        echo "submit " . $_POST['submit'];

        $profile_id = $_POST['id'];
        echo $profile_id . "<br>";

        $profile_photo = $_FILES['profile_photo']['name'];
        echo $profile_photo . "<br>";

        $uploaddir = __DIR__ .DS.'images';
        $fullpath = $uploaddir.DS.$profile_photo;


        echo $fullpath . "<br>";

        $move = move_uploaded_file($_FILES['profile_photo']['tmp_name'], $fullpath);

        $query = mysqli_query($connection, "UPDATE products SET profile_pic='{$profile_photo}' WHERE id={$profile_id}");
        if(!$query) {
            die("QUERY FAILED: " . mysqli_error($connection));
        }


        $message = "";
        $location = "candidates.html";
        if (!$move) { 
            $message .= "File did not upload";
        } else { 
            header("Location: $location ");
        }

        echo $message;
    }


?>
