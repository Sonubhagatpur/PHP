
// normal method of images upload.
<?php
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'file-management');

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (name, size, downloads) VALUES ('$filename', $size, 0)";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}
?>

// advance method of images upload


!DOCTYPE html>
<?php
  
  $target_dir = $_POST["dirname"]."/";
  $target_file = $target_dir 
    . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  
  if($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // To check whether directory exist or not
    if(!empty($_POST["dirname"])) {
        if(!is_dir($_POST["dirname"])) {    
            mkdir($_POST["dirname"]);    
            $uploadOk = 1;            
        }
    }
    else {
        echo "Specify the directory name...";
        $uploadOk = 0;
        exit;    
    }
  
    // Check if file was uploaded without errors
    if(isset($_FILES["fileToUpload"]) && 
        $_FILES["fileToUpload"]["error"] == 0) {
        $allowed_ext = array("jpg" => "image/jpg",
                            "jpeg" => "image/jpeg",
                            "gif" => "image/gif",
                            "png" => "image/png");
        $file_name = $_FILES["fileToUpload"]["name"];
        $file_type = $_FILES["fileToUpload"]["type"];
        $file_size = $_FILES["fileToUpload"]["size"];
      
        // Verify file extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
  
        if (!array_key_exists($ext, $allowed_ext)) {
            die("Error: Please select a valid file format.");
        }    
              
        // Verify file size - 2MB max
        $maxsize = 2 * 1024 * 1024;
          
        if ($file_size > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }                    
      
        // Verify MYME type of the file
        if (in_array($file_type, $allowed_ext))
        {
            // Check whether file exists before uploading it
            if (file_exists("upload/" . $_FILES["fileToUpload"]["name"])) {
                echo $_FILES["fileToUpload"]["name"]." is already exists.";
            }        
            else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 
                  $target_file)) {
                    echo "The file ".  $_FILES["fileToUpload"]["name"]. 
                      " has been uploaded.";
                } 
                else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        else {
            echo "Error: Please try again.";
        }
    }
    else {
        echo "Error: ". $_FILES["fileToUpload"]["error"];
    }
}
?>
  
</body>
</html>