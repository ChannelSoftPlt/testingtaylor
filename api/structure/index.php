<!DOCTYPE html>
<html lang="en">
<head>
    <title>BFrame</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="http://yofu.my/ordering/default_img/app_icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
    <body>

        <div class="container">
        <h2>Generate File</h2>
        <p>Please fill in all fields that given below:</p>
            <form action="generate_file.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <label for="model">Model Class</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="my_model" required>
                </div>
                <div class="form-group">
                <label for="pwd">Database Name</label>
                <input type="text" class="form-control" id="database" name="database" required>
                </div>
                <div class="form-group">
                <label for="pwd">Table Name</label>
                <input type="text" class="form-control" id="table" name="table" required>
                </div>
                <div class="form-group">
                <label for="pwd">Directory</label>
                <input type="text" class="form-control" id="directory" name="directory" placeholder="/path/to/your/folder" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
            <div class="col-sm-12 copy-right" style="text-align:center; margin-top:0px;">
                <label for="inputType" class="col-sm-12 control-label">
                <i class="fa fa-copyright" style="font-size:13px;color:#000">
                </i>
                All rights reserved by Chafor
                </label>
            </div>
        </div>
    </body>
</html>
?>
