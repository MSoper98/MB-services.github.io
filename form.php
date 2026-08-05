<?php
if($status=="success"){
    echo "<div class='success'>
            Thank you! Your request has been sent.
          </div>";
}

if($status=="error"){
    echo "<div class='error'>
            Sorry, something went wrong. Please try again.
          </div>";
}
?>

<?php
$status = "";
if(isset($_POST['submit'])){
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $project = htmlspecialchars(trim($_POST['project']));
    $message = htmlspecialchars(trim($_POST['message']));

    $to = "msoper1998@gmail.com";

    $subject = "New Estimate Request - $project";
    $body = "
New Contact Request

Name:
$name

Email:
$email

Phone:
$phone

Message:
$message
";
    $headers = "From: $email";
    $uploadDir = "uploads/";
    if(!file_exists($uploadDir)){
        mkdir($uploadDir,0777,true);
    }

    $attachmentMessage = "";
$allowed = [
    "jpg",
    "jpeg",
    "png",
    "gif",
    "pdf",
    "doc",
    "docx"
];

$uploadDir = "uploads/";

if(!file_exists($uploadDir)){
    mkdir($uploadDir,0777,true);
}

$fileCount = count($_FILES['upload']['name']);

if($fileCount > 6){
    $status = "error";

}else{
    for($i = 0; $i < $fileCount; $i++){
        if($_FILES['upload']['error'][$i] === 0){
            $filename = basename($_FILES['upload']['name'][$i]);
            $extension = strtolower(
                pathinfo($filename, PATHINFO_EXTENSION)
            );

            if(in_array($extension,$allowed)){
                $targetFile = 
                    $uploadDir . 
                    time() . "_" . 
                    $filename;
                if($_FILES['upload']['size'][$i] > 10 * 1024 * 1024){
                    continue;
                    }

                if(move_uploaded_file(
                    $_FILES['upload']['tmp_name'][$i],
                    $targetFile
                )){

                    $attachmentMessage .= 
                    "\nUploaded File:\n" . 
                    $targetFile . 
                    "\n";
                }
            }
        }
    }
}
?>