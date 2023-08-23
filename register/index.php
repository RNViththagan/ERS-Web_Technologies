<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
            rel="shortcut icon"
            href="../assets/img/logo/ERS_logo_icon.ico"
            type="image/x-icon"/>
    <title>ERS | Register</title>
    <script
            src="https://kit.fontawesome.com/5ce4b972fd.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body class="w-full h-full">
<div class="login-bg flex items-center justify-center"></div>
<div class="card h-[550px] w-10/12 absolute-center">
    <!-- Mobile n tab view design -->
    <div class="lg:hidden flex flex-col items-center">
        <img
                src="../assets/img/logo/ERS_logo.gif"
                alt="ERS_logo"
                class="w-28 align-middle"/>
        <h2 class="my-5 text-lg">Exam Registration System</h2>
        <h3 class="text-lg underline font-semibold text-gray-900 mb-3">
            Sign-Up
        </h3>
        <form
                action=""
                method="post"
                class="flex flex-col items-center justify-around">
            <div class="text-input">
                <i class="fa-solid fa-user"></i>
                <div></div>
                <input type="text" name="username" placeholder="UserName"/>
            </div>
            <div class="text-input">
                <i class="fa-solid fa-at"></i>
                <div></div>
                <input type="email" name="email" placeholder="E-mail"/>
            </div>
            <div class="text-input">
                <i class="fa-solid fa-lock"></i>
                <div></div>
                <input type="password" name="password" placeholder="Password"/>
            </div>
            <div class="text-input">
                <i class="fa-solid fa-lock"></i>
                <div></div>
                <input
                        type="password"
                        name="cpassword"
                        placeholder="Confirm Password"/>
            </div>
            <input
                    type="submit"
                    name="reg-btn"
                    value="Sign-Up"
                    class="btn text-white bg-[var(--primary)] mt-5 formbutton"/>
        </form>
        <div class="text-center mt-7">
            <p>Already have an account?</p>
            <a href="../login.php" class="text-[var(--primary)] underline"
            >Sign-In</a
            >
        </div>
    </div>

    <!-- Desktop view design -->
    <div class="hidden lg:block">
        <div>
            <h2>Exam Registration System</h2>
            <img
                    src="../assets/img/undraw_online_test_re_kyfx.svg"
                    alt="Online test vector img"
                    class="w-60"/>
            <div>
                <p>Already have an account?</p>
                <a href="../login.php">Sign-In</a>
            </div>
        </div>
        <div>
            <h3>Sign-Up</h3>
            <form action="" method="post">
                <div class="text-input">
                    <i class="fa-solid fa-user" style="color: #5465ff"></i>
                    <input
                            type="text"
                            name="username"
                            id="username"
                            placeholder="UserName"/>
                </div>
                <div class="text-input">
                    <i class="fa-solid fa-at"></i>
                    <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="E-mail"/>
                </div>
                <div class="text-input">
                    <i class="fa-solid fa-lock"></i>
                    <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Password"/>
                </div>
                <div class="text-input">
                    <i class="fa-solid fa-lock"></i>
                    <input
                            type="password"
                            name="cpassword"
                            id="cpassword"
                            placeholder="Password"/>
                </div>
                <input class="formbutton" type="submit" name="reg-btn" value="Sign-Up"/>
            </form>
        </div>
    </div>
</div>
</body>
</html>
