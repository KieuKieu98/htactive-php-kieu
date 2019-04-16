<?php
require_once "../connect.php";

$icon = $title = $content = "";
$icon_err = $title_err = $content_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_icon = trim($_POST["icon"]);
    if(empty($input_icon)){
        $icon_err = "Please enter an icon.";
    } else{
        $icon = $input_icon;
    }
    $input_title= trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter an title.";     
    } else{
        $title = $input_title;
    }
    $input_content= trim($_POST["content"]);
        if(empty($input_title)){
            $content_err = "Please enter an content.";     
        } else{
            $content = $input_content;
    }
    if(empty($icon_err) && empty($title_err) && empty($content_err)){
        $sql = "INSERT INTO service (icon, title, content) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_icon, $param_title, $param_content);
            $param_icon = $icon;
            $param_title = $title;
            $param_content = $content;

            if(mysqli_stmt_execute($stmt)){
                header("location: service.php");
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
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <div class="form-group <?php echo (!empty($content_err)) ? 'has-error' : ''; ?>">
                            <label>Content</label>
                            <input type="text" name="content" class="form-control" value="<?php echo $content; ?>">
                            <span class="help-block"><?php echo $content_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="service.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>