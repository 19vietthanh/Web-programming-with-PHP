<?php 
    $image_fieldname="image_file";
    $php_errors = array(1 => 'Maximum file size in php.ini exceeded',
    2 => 'Maximum file size in HTML form exceeded', 
    3 => 'Only part of the file was uploaded',
    4 => 'No file was selected to upload.');
    ($_FILES[$image_fieldname]['error'] == 0)
        or die("the server couldn't upload the image you selected".  
            $php_errors[$_FILES[$image_fieldname]['error']]);
    // Kiểm tra đây có phải là một file upload hợp pháp hay không?
    @is_uploaded_file ($_FILES[$image_fieldname]['tmp_name'])
    or die("Possible file upload attack:".
    "filename".$_FILES[$image_fieldname]['tmp_name'].".");
    // Kiểm tra đây có phải là một file ảnh hay không? 
    @getimagesize($_FILES[$image_fieldname]['tmp_name'])
        or die("you selected a file for a book that ".
                "isn't an image.".
                "{$_FILES[$image_fieldname]['tmp_name']}".
                "isn't a valid image file.");
    /*Kết nối cơ sở dữ liệu*/
    $mysqli= new mysqli("localhost","root","","bookstore");
    if ($mysqli->connect_error) { 
        die('Connect Error ('.$mysqli->connect_errno.')'
         . $mysqli->connect_error); 
    }
    //Lưu thông tin về tựa sách và phân giới thiệu vào bằng hooks/
    if (isset($_POST["title"]) && isset($_POST["introduction"])){ 
        $sql="insert into bookstore.books(title, introduction)".
        "values('".$_POST["title"]."','".
        $mysqli->escape_string($_POST["introduction"])."');";
        $mysqli->query($sql) or die ($mysqli->error);
    }else{ 
        echo "Book's information is required"; 
        exit;  
    }
    $book_id=$mysqli->insert_id; 
    $image = $_FILES[$image_fieldname];
    $image_filename = $image['name'];
    $image_mime_type = $image['type'];
    $image_size = $image['size'];
    $image_data = file_get_contents($image['tmp_name']);
    $insert_image_sql = "insert into images" . 
    "(book_id, filename, mime_type, file_size, image_data)" . 
    "VALUES ({$book_id}, '{$image_filename}', '{$image_mime_type}',". 
    "'{$image_size}', '{$mysqli->escape_string($image_data)}');";
    $mysqli->query($insert_image_sql) or die ($mysqli->error);
?>