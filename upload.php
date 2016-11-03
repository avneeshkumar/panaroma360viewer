<?php
    session_start();
    $target_dir = "uploads/";
    $files1 = scandir($target_dir,1);
    $target_dir = $target_dir.(((int)$files1[0])+1).'/';
    $_SESSION["DIRNAME"] = $target_dir;
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    #echo $target_dir;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            exec('convert -crop 25%x100% '.$target_file.' '.$target_dir.'o.jpg' , $outputArray);     
                # code...
            exec('convert -resize 1024x1024! '.$target_dir.'o-0.jpg '.$target_dir.'px.jpg' , $outputArray);
            exec('convert -resize 1024x1024! '.$target_dir.'o-1.jpg '.$target_dir.'nz.jpg' , $outputArray);
            exec('convert -resize 1024x1024! '.$target_dir.'o-2.jpg '.$target_dir.'nx.jpg' , $outputArray);
            exec('convert -resize 1024x1024! '.$target_dir.'o-3.jpg '.$target_dir.'pz.jpg' , $outputArray);
            exec("cp ny.jpg ".$target_dir);
            exec("cp py.jpg ".$target_dir);
            header('Location: viewer/');
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>
