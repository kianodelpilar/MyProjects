<?php


require 'session-file.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

function generateOTP($length = 6){
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

$email = $_SESSION['email'];
$otp = generateOTP();
$_SESSION['otp'] = $otp;

$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'akoa36253@gmail.com';
    $mail->Password = 'lqmk ierh qjzy cnmj';
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('akoa36253@gmail.com', 'Mura,g Facebook');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Forgot Password OTP';
    $mail->Body    = 'Your OTP is: ' . $otp;

    $mail->send();
    echo 'OTP sent successfully.';

    $conn = connect();
    $sql = "UPDATE users SET otp='$otp' WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        echo "OTP saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
