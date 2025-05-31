<?php
    include_once("../controller/controller.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = registerUser($username, $password);
        if ($result) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Username already exists!"; 
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
</head>
<body class="bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] overflow-x-hidden">
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="" method="POST">
            <div class="flex flex-col items-center gap-[30px] justify-center p-6 bg-[#FBFBFD] shadow-md rounded-lg sm:w-[500px]">
                <h1 class="text-[36px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">Bukuku</h1>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Username</p>
                    <input type="text" name="username" placeholder="Username" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Password</p>
                    <input type="password" name="password" placeholder="Password" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-[#0071E3] text-white p-2 rounded-lg hover:bg-blue-700 transition duration-200">Register</button>
                <?php
                if (isset($error)) {
                    echo '<div style="color:red; background-color:pink; border-radius: 8px; padding: 4px; width: 100%; display: flex; justify-content: center; align-items: center;">' . $error . '</div>';
                }
                ?>
                <p class="text-gray-600">Already have an account? <a href="index.php" class="text-[#0071e3] hover:underline">Login here</a></p>
            </div>
        </form>
    </div>
</body>
</html>