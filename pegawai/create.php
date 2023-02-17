<?php
require_once "config.php";

$name = $alamat = $gaji = "";
$name_err = $alamat_err = $gaji_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    $input_alamat = trim($_POST["alamat"]);
    if(empty($input_alamat)){
        $alamat_err = "Please enter an address.";
    } else{
        $alamat = $input_alamat;
    }
    $input_gaji = trim($_POST["gaji"]);
    if(empty($input_gaji)){
        $gaji_err = "Please enter the salary amount.";
    } elseif(!ctype_digit($input_gaji)){
        $gaji_err = "Please enter a positive integer value.";
    } else{
        $gaji = $input_gaji;
    }
    if(empty($name_err) && empty($alamat_err) && empty($gaji_err)){

        $sql = "INSERT INTO tb_karyawan (name, alamat, gaji) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($db, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_alamat, $param_gaji);
            $param_name = $name;
            $param_alamat = $alamat;
            $param_gaji = $gaji;
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create riri</title>
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
                        <h2>Tambah Record</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data pegawai ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($alamat_err)) ? 'has-error' : ''; ?>">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"><?php echo $alamat; ?></textarea>
                            <span class="help-block"><?php echo $alamat_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($gaji_err)) ? 'has-error' : ''; ?>">
                            <label>Gaji</label>
                            <input type="text" name="gaji" class="form-control" value="<?php echo $gaji; ?>">
                            <span class="help-block"><?php echo $gaji_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>