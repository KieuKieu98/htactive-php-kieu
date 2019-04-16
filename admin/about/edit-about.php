<?php
require_once "../connect.php";

$icon = $title = $description = "";
$icon_err = $title_err = $description_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

     $input_icon = trim($_POST["icon"]);
     if(empty($input_icon)){
         $icon_err = "Please enter a icon.";
     } else{
         $icon = $input_icon;
     }

     $input_title= trim($_POST["title"]);
     if(empty($input_title)){
         $title_err = "Please enter an title.";     
     } else{
         $title = $input_title;
     }
    $input_description= trim($_POST["description"]);
         if(empty($input_description)){
             $description_err = "Please enter an description.";     
         } else{
             $description = $input_description;
    }

     if(empty($icon_err) && empty($title_err) && empty($description_err)){
        $sql = "UPDATE abouts SET icon=?, title=?, description=? WHERE id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_icon, $param_title, $param_description, $param_id);
            
            $param_icon = $icon;
            $param_title = $title;
            $param_description = $description;
            $param_id = $id;
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: about.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        $sql = "SELECT * FROM abouts WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $icon = $row["icon"];
                    $title = $row["title"];
                    $description = $row["description"];
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
                    <div class="form-group <?php echo (!empty($icon_err)) ? 'has-error' : ''; ?>">
                    <label>Icon</label>
                    <input type="text" name="icon" class="form-control" value="<?php echo $icon; ?>">
                    <span class="help-block"><?php echo $icon_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                    <label>Title</label>
                    <textarea name="title" class="form-control"><?php echo $title; ?></textarea>
                    <span class="help-block"><?php echo $title_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                    <span class="help-block"><?php echo $description_err;?></span>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="about.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>