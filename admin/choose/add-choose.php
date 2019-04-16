<?php
// Include config file
require_once "../connect.php";

$icon = $desctiption = $image = "";
$icon_err = $desctiption_err = $image_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_icon = trim($_POST["icon"]);
    if(empty($input_icon)){
        $icon_err = "Please enter an icon.";
    } else{
        $icon = $input_icon;
    }
 
    $input_desctiption= trim($_POST["desctiption"]);
    if(empty($input_desctiption)){
        $desctiption_err = "Please enter an desctiption.";     
    } else{
        $desctiption = $input_desctiption;
    }
    $input_image= trim($_POST["image"]);
        if(empty($input_title)){
            $image_err = "Please enter an content.";     
        } else{
            $image = $input_image;
    }
    
    if(empty($icon_err) && empty($desctiption_err) && empty($image_err)){
        $sql = "INSERT INTO chooses (icon, description, image) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_icon, $param_desctiption, $param_image);
            
              
            $param_icon = $icon;
            $param_desctiption = $desctiption;
            $param_image = $image;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: choose.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                    <div class="form-group <?php echo (!empty($icon_err)) ? 'has-error' : ''; ?>">
                    <label>Icon</label>
                    <input type="text" name="icon" class="form-control" value="<?php echo $icon; ?>">
                    <span class="help-block"><?php echo $icon_err;?></span>
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