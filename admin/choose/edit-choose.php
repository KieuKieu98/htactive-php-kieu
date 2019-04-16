<?php
require_once "../connect.php";

$title = $desctiption = $image = "";
$title_err = $description_err = $image_err = "";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
     $input_title = trim($_POST["title"]);
     if(empty($input_title)){
         $title_err = "Please enter a title.";
     } else{
         $title = $input_title;
     }
     // Validate title
     $input_desctiption= trim($_POST["description"]);
     if(empty($input_description)){
         $desctiption_err = "Please enter an description.";     
     } else{
         $description = $input_description;
     }
         // Validate content
         $input_image= trim($_POST["image"]);
         if(empty($input_title)){
             $image_err = "Please enter an content.";     
         } else{
             $image = $input_image;
         }

     if(empty($title_err) && empty($description_err) && empty($image_err)){

        $sql = "UPDATE chooses SET title=?, description=?, image=? WHERE id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_icon, $param_description, $param_image, $param_id);
            
            $param_title = $title;
            $param_description = $description;
            $param_image = $image;
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                header("location: choose.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
} else{

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        $sql = "SELECT * FROM chooses WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){

                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $title = $row["title"];
                    $desctiption = $row["description"];
                    $image = $row["image"];
                } else{
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

        mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
    }  else{

        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                    <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                    <label>title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                    <span class="help-block"><?php echo $title_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                    <label>description</label>
                    <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                    <span class="help-block"><?php echo $description_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
                    <label>Image</label>
                    <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                    <span class="help-block"><?php echo $content_err;?></span>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="choose.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>