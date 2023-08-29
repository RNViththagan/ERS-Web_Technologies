<?php
ob_start();
if (isset($_SESSION['userid'])) {
    if (isset($_SESSION['role']))
        header("location:../admin_select.php");
    else
        header("location:../");
}
require_once('../config/userDataController.php');

if (!isset($_SESSION['code-sent'])) {
  header("location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
            rel="shortcut icon"
            href="../assets/img/logo/ERS_logo_icon.ico"
            type="image/x-icon" />
    <title>ERS | Verification</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script
            src="https://kit.fontawesome.com/5ce4b972fd.js"
            crossorigin="anonymous"></script>
</head>

<body class="h-screen w-full lg:relative">
<div class="login-bg flex items-center justify-center"></div>
<div class="card h-[495px] w-10/12 lg:w-7/12 absolute-center lg:h-[500px] lg:p-0 z-0">
    <!-- Mobile n tab view design -->
    <div class="lg:h-full flex lg:grid flex-col z-10 lg:grid-cols-2 items-center lg:justify-items-center">
        <img
                src="../assets/img/logo/ERS_logo.gif"
                alt="ERS_logo"
                class="w-28 align-middle lg:col-start-1 lg:self-end " />
        <h2 class="my-5 text-lg font-[var(--title)] lg:my-0 lg:col-start-1 lg:text-xl">Exam Registration System</h2>
        <img
            src="../assets/img/undraw_code_typing.svg"
            alt="vector img"
            class="hidden w-60 lg:block lg:col-start-1 " />
        <h3 class="text-lg underline font-semibold text-gray-900 mb-3 lg:text-2xl lg:mb-0 lg:col-start-2 lg:row-start-1 lg:self-end">
            Verification Code
        </h3>


        <?php if (isset($errors['otp-error'])) { ?>
            <div class="error-text lg:col-start-2 lg:row-start-2 lg:self-end"><?php echo $errors['otp-error']; ?></div>
        <?php } elseif (isset($errors['wrong-otp'])) { ?>
            <div class="error-text lg:col-start-2 lg:row-start-2 lg:self-end"><?php echo $errors['wrong-otp']; ?></div>
        <?php } else { ?>
            <p class="text-sm w-[90%] text-justify mb-4 lg:col-start-2 lg:row-start-2 lg:self-end">
                Check your E-mail. We've sent you a verification code to your email.
                Verification code will be expire within 3 minutes.
            </p>
        <?php } ?>

        <form
                action="user_verification.php"
                method="post"
                class="flex flex-col items-center justify-around lg:col-start-2 lg:row-span-2 lg:self-start lg:w-full"
                id="reg-otp-form">

            <div id="otp-inputs" class="w-64 flex items-center justify-around <?php echo (isset($errors['wrong-otp']) ? "wrong-otp" : "")?>">
                <input
                        class="otp-input-box"
                        type="number"
                        name="number1"
                        autofocus />
                <input
                        class="otp-input-box"
                        type="number"
                        name="number2"
                        disabled />
                <input
                        class="otp-input-box"
                        type="number"
                        name="number3"
                        disabled />
                <input
                        class="otp-input-box"
                        type="number"
                        name="number4"
                        disabled />
                <input
                        class="otp-input-box"
                        type="number"
                        name="number5"
                        disabled />
                <input
                        class="otp-input-box"
                        type="number"
                        name="number6"
                        disabled />
            </div>
            <div class="text-xs mt-5 font-normal">Time left - <span id="timer" class="font-semibold"></span></div>
            <input
                    type="submit"
                    name="verify-pw-otp"
                    value="Verify"
                    class="otp-btn btn text-white bg-[var(--primary)] disabled:bg-[#788BFF] mt-5"
                    id="otp-submit-btn"
                    disabled />
            <div class="text-center mt-7 ">
                <p class="text-xs lg:text-base">Didn't Receive the OTP?</p>
                <a
                    href="../config/userDataController.php?reg-code-resend=true"
                    class="text-xs text-[var(--primary)] underline cursor lg:text-base"
                >Resend</a>
            </div>
        </form>
        <div class="text-center mt-7 lg:col-start-1 lg:mt-0 ">
            <p>Remember Password?</p>
            <a href="../login.php" class="text-[var(--primary)] underline"
            >Go Back</a>
        </div>

    </div>
    <div class="-z-10 lg:absolute lg:inset-2/4 lg:-translate-x-full lg:-translate-y-1/2 lg:w-1/2 lg:h-full lg:bg-[#bfd7ff] lg:rounded-2xl"></div>
</div>

<script src="../assets/js/script.js"></script>
<script>
    let timerOn = true;

    function timer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;

        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('timer').innerHTML = m + ':' + s;
        remaining -= 1;

        if(remaining >= 0 && timerOn) {
            setTimeout(function() {
                timer(remaining);
            }, 1000);
            return;
        }

        if(!timerOn) {
            // Do validate stuff here
            return;
        }

        button.setAttribute("disabled", "");

    }

    timer(180);
</script>
</body>
</html>
