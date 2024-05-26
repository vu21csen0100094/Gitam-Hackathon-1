<?php
$con = mysqli_connect("localhost", "root", "12345678", "codeaddict");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_img'])) {
    $messages = "";
    
    foreach ($_FILES['choosefile']['name'] as $key => $filename) {
        $tempfile = $_FILES['choosefile']['tmp_name'][$key];
        $folder = "image/" . basename($filename);
        
        if (empty($filename)) {
            $messages .= "<div class='alert alert-danger' role='alert'><h4 class='text-center'>Blank not allowed for file at index $key</h4></div>";
        } else {
            if (move_uploaded_file($tempfile, $folder)) {
                $sql = "INSERT INTO `images`(`image`) VALUES ('$filename')";
                $result = mysqli_query($con, $sql);
                $messages .= "<div class='alert alert-success' role='alert'><h4 class='text-center'>Image $filename uploaded</h4></div>";
            } else {
                $messages .= "<div class='alert alert-danger' role='alert'><h4 class='text-center'>Failed to upload image $filename</h4></div>";
            }
        }
    }

    echo "<div id='php-messages'>$messages</div>";
}

// Fetch images for display
$sql2 = "SELECT * FROM `images`";
$result2 = mysqli_query($con, $sql2);
$tableRows = '';

while ($fetch = mysqli_fetch_assoc($result2)) {
    $tableRows .= "
    <tr>
        <td>{$fetch['id']}</td>
        <td><img src='./image/{$fetch['image']}' width='100px' alt=''></td>
        <td><a href='delete.php?id={$fetch['id']}' class='btn btn-outline-danger'>Delete</a></td>
    </tr>";
}

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
    <link rel='stylesheet' href='styles.css'>
    <title>Student Study Materials Upload</title>
</head>
<body>
    <div class='alert alert-secondary' role='alert'>
        <h4 class='text-center'>Student Study Materials Upload</h4>
    </div>
    <div class='container col-12 m-5'>
        <div class='col-6 m-auto'>
            <div id='php-messages'>{$messages}</div>
            <form action='index.php' method='post' class='form-control' enctype='multipart/form-data'>
                <input type='file' class='form-control' name='choosefile[]' multiple>
                <div class='col-6 m-auto'>
                    <button type='submit' name='btn_img' class='btn btn-outline-success m-4'>
                        Submit
                    </button>
                </div>
            </form>
            <table class='table text-center'>
                <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <tbody id='php-table-rows'>{$tableRows}</tbody>
            </table>
        </div>
    </div>
    <script src='scripts.js'></script>
</body>
</html>";
?>
