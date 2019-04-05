
<?php

    if(isset($_POST["submit"])){

        if(!empty($_FILES["attachment"]["name"])){
        $file_name = $_FILES["attachment"]["name"];
        $temp_name = $_FILES["attachment"]["tmp_name"];
        $file_type = $_FILES["attachment"]["type"];
        $email = $_POST["email"];

        $base = basename($file_name);
        $extension = substr($base, strlen($base)-4, strlen($base));

        /**files extensions allowed */
        $allowed_extensions = array(".doc", "docx",".pdf","zip","png",".jpeg",".jpg");

        if(in_array($extension, $allowed_extensions)){
            $to = $email;
            $subject = $_POST["subject"];
            $message = $_POST["message"];
            $txt = "You have received an email from ".$firstName.".\n\n".$message;
            $file = $temp_name;

            $content = chunk_split(base64_encode(file_get_contents($file)));
            $uid = md5(uniqid(time()));

            /**File plain text attachment */
            $header = "From: ".$email;
            $header .= "Content-Type: multipart/mixed; boundary=\"".$uid;
            $header .= "--".$uid."\r\n";
            $header .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
            $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n\r\n";
            $header .= $message."\"\r\n\r\n";
           
            /** File attachment */
            $header .= "--".$uid."\r\n";
            $header .= "Content-Type:".$file_type."; name=\"".$file_name."\"\r\n\r\n";
            $header .= "Content-Transfer-Encoding: base64\r\n";
            $header .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n";
            $header .= $content."\r\n\r\n";
            
            /**Checks status of sent mail whether failed or success */
            if(mail($to, $subject, $txt,$header)){
                echo "Success";
            }else{
                echo "Fail";
            }
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>PostCard</title>
</head>
<body>
    <!-- Form -->
<form action="index.php" class="text-center border border-light p-5" method="post" enctype="multipart/form-data">

<p class="h4 mb-4">Post Card Email</p>

<div class="form-row mb-4">
    <div class="col">
        <!-- First name -->
        <input type="text" id="firstName" class="form-control" placeholder="First Name" name="firstname">
    </div>
    <div class="col">
        <!-- Last name -->
        <input type="text" id="lastName" class="form-control" placeholder="Last Name" name="lastname">
    </div>
</div>

<div class="form-row mb-4">
    <div class="col">
        <!-- Subject -->
        <input type="text" id="subject" class="form-control" placeholder="Subject" name="subject">
    </div>
    <div class="col">
        <!-- Last name -->
        <input type="text" id="message" class="form-control" placeholder="message" name="message">
    </div>
</div>

<!-- E-mail -->
<input type="email" id="formEmail" class="form-control mb-4" placeholder="email" name="email">
<input type="file" id="pictureFile" class="form-control mb-4" placeholder="Upload A File" name="file">

<!-- Submit Button -->
<input class="btn btn-info my-4 btn-block" type="submit" value="Send Email" name="submit">
</form>



<div class="video-wrap" id="videoCam">
   <video id="video" playsinline autoplay></video>
</div>

<!-- Triggers the web cam-->
<div class="controller">
  <button id="snap">Capture</button>
</div>

<canvas id="canvas" width="640" height="480">

</canvas>


<script src="app.js"></script>
</body>
</html>