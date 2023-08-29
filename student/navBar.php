<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script
      src="https://kit.fontawesome.com/5ce4b972fd.js"
      crossorigin="anonymous"></script>
</head>
<body>
    <nav class="w-full h-[15vh] min-h-fit drop-shadow-md bg-white fixed top-0 left-0">
        <div class="w-10/12 h-full m-auto flex items-center justify-between">
            <a href="index.php">
                <img src="../assets/img/logo/ERS_logo.gif" alt="logo" class="w-28 align-middle">
            </a>    
            <ul class="flex items-center justify-around gap-10">
                <li><a href="exam_reg.php" class="hidden btn outline-btn md:block">Exam Registration</a></li>

                <?php if (!isset($profile_img)) { ?>
                    <li onclick="openMenu()" class="py-2 px-3 bg-[var(--primary)] rounded-full drop-shadow-md cursor-pointer lh:relative"><i class="fa-solid fa-user text-2xl text-[#dfeaff]"></i></li>
                <?php } else { ?>
                    <img onclick="openMenu()" class="w-10 h-10 lg:w-12 lg:h-12 rounded-full drop-shadow-md cursor-pointer ring-4" src="../assets/uploads/<?php echo $profile_img; ?>" alt="user img">
                <?php } ?>
                
            </ul>
                       
        </div>
        <div class="hidden top-[14.8vh] right-0 h-56 w-full bg-white -translate-y-full z-20 transition-transform lg:top-[16vh] lg:drop-shadow-2xl lg:right-24 lg:w-56 lg:translate-x-full lg:h-72 lg:rounded-tl-3xl lg:rounded-br-3xl lg:text-gray-800" id="user-menu">
            <ul class="w-11/12 h-full m-auto flex flex-col items-center justify-around text-center">
                <li class="mt-3 "><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="exam_reg.php">Exam Registration</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class=""><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="index.php">Dashboard</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class=""><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="../contact.html">Contact</a></li>
                <div class="h-px w-3/4 bg-gray-300"></div>
                <li class="mb-3 "><a class="py-4 hover:text-blue-600 hover:font-bold hover:tracking-wide transition-all" href="../logout.php">Logout</a></li>
            </ul>   
        </div>   
    </nav>
</body>

<script>
    const userMenu = document.getElementById('user-menu');

    function openMenu() {
        userMenu.classList.toggle('hidden');
        userMenu.classList.toggle('absolute');
        userMenu.classList.toggle('-translate-y-full');
        userMenu.classList.toggle('lg:translate-x-full');
    }
</script>