<?php 
    session_start();
    include_once("../controller/controller.php");
    if (isset($_SESSION['user_id'])) {
        // User is already logged in, redirect to personal collection
        header("Location: personal-collection.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['loaded_animation'] = true;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $loginResult = loginUser($username, $password);
        if (!empty($loginResult)) {
            header("Location: personal-collection.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukuku</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/TextPlugin.min.js"></script>

    <script>
        <?php if (!isset($_SESSION['loaded_animation'])) { ?>
        document.addEventListener("DOMContentLoaded", function() {
        const tl = gsap.timeline();
        
        // split the title text
        let split = SplitText.create(".title", { type: "words, chars" });
        
        // Set initial styles
        gsap.set(".background", { opacity: 0 });
        // Animate logo
        tl.from('.logo', {
            duration: 1, 
            opacity: 0,    
            y: 50,      
            ease: "back.out(1.7)"
        })
        .to(".title", { opacity: 1, duration: 0.1 }, "<") // start at same time as logo
        .from(split.chars, {
            duration: 1, 
            opacity: 0,    
            y: 50,         
            stagger: 0.05, 
            ease: "back.out(1.7)"
        }, "<"); // start at same time as logo

        tl.to('.logo', {
            duration: 1, 
            opacity: 0,    
            x: 160,      
            ease: "back.out(1.7)"  
        }).to(".title", { opacity: 1, duration: 0.1 }, "<").to(split.chars, {
            duration: 0.1, 
            opacity: 0,    
            x: 50,         
            stagger: 0.05, 
            ease: "back.out(1.7)"
        }, "<");

        tl.to(".background", { 
            opacity: 1, 
            y: 0,
            duration: 1,
            ease: "power3.out" 
        }, "-=0.3");
    });
    <?php } ?>
    </script>
</head>
<body class="bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] overflow-x-hidden">
    <div class="relative w-screen h-screen flex flex-col justify-center items-center">
        <?php if (!isset($_SESSION['loaded_animation'])){ ?>
        <div class="absolute flex items-center gap-2 top-[50vh]">
            <svg class="mt-2 logo text-black" xmlns="http://www.w3.org/2000/svg" width="25" height="25" class="bi bi-book-fill" viewBox="0 0 16 16">
                <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
            </svg>
            <h1 class="title text-[36px] font-bold">Bukuku</h1>
        </div>
        <?php } ?>
        <form action="" method="POST" class="">
            <div class="background flex flex-col items-center gap-[30px] justify-center p-6 bg-[#FBFBFD] shadow-md rounded-lg sm:w-[500px]">
                <h1 class="text-[36px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">Bukuku</h1>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Username</p>
                    <input type="text" name="username" placeholder="Username" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Password</p>
                    <input type="password" name="password" placeholder="Password" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-[#0071E3] text-white p-2 rounded-lg hover:bg-blue-700 transition duration-200">Login</button>
                
                <?php
                if (isset($error)) {
                    echo '<div style="color:red; background-color:pink; border-radius: 8px; padding: 4px; width: 100%; display: flex; justify-content: center; align-items: center;">' . $error . '</div>';
                }
                ?>
                <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-[#0071e3] hover:underline">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>