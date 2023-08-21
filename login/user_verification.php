<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="../img/logo/ERS_logo_icon.ico"
      type="image/x-icon" />
    <title>ERS | Verification Page</title>
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script
      src="https://kit.fontawesome.com/5ce4b972fd.js"
      crossorigin="anonymous"></script>
  </head>

  <body class="w-full h-full">
    <div class="login-bg flex items-center justify-center"></div>
    <div class="card h-[475px] w-10/12 absolute-center">
      <!-- Mobile n tab view design -->
      <div class="lg:hidden flex flex-col items-center">
        <img
          src="../img/logo/ERS_logo.gif"
          alt="ERS_logo"
          class="w-28 align-middle" />
        <h2 class="mt-3 mb-5 text-lg">Exam Registration System</h2>
        <h3 class="text-lg underline font-semibold text-gray-900 mb-3">
          Verification Code
        </h3>
        <p class="text-sm w-[90%] text-justify mb-5">
          Check your E-mail. We've sent you a verification code to your email.
          Verification code will be expire within 3 minutes.
        </p>
        <form
          action=""
          method="post"
          class="flex flex-col items-center justify-around"
          id="reg-otp-form">
          <div class="otp-inputs w-64 flex items-center justify-around">
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
          <input
            type="submit"
            name="verify-otp"
            value="Verify"
            class="otp-btn btn text-white bg-[var(--primary)] disabled:bg-[#788BFF] mt-5"
            disabled />
        </form>
        <div class="text-center mt-7">
          <p class="text-sm">Didn't Receive the OTP?</p>
          <a
            href="#"
            class="text-sm text-[var(--primary)] underline"
            >Resend</a
          >
        </div>
      </div>
    </div>

    <script src="../js/script.js"></script>
  </body>
</html>
