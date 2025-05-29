<?php include_once("../controller/controller.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukuku</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] overflow-x-hidden">
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="text" method="POST">
            <div class="flex flex-col items-center gap-[30px] justify-center p-6 bg-[#FBFBFD] shadow-md rounded-lg sm:w-[500px]">
                <h1 class="text-[36px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">Bukuku</h1>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Username</p>
                    <input type="text" name="username" placeholder="Username" class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Password</p>
                    <input type="password" name="password" placeholder="Password" class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-[#0071E3] text-white p-2 rounded-lg hover:bg-blue-700 transition duration-200">Login</button>
                <p class="text-gray-600">Don't have an account? <a href="register.php" class="text-[#0071e3] hover:underline">Register here</a></p>
            </div>
        </form>
    </div>
</body>
</html>