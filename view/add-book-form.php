<?php 
    session_start();
    include_once("../controller/controller.php");

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
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
<body class="flex flex-col gap-[30px] bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] p-12 overflow-x-hidden">
    <!-- Navbar -->
    <nav class="flex justify-center items-center">
        <div class="w-screen p-6 flex items-center justify-between bg-white shadow-md rounded-lg">
            <h1 class="text-[32px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">
                Bukuku
            </h1>
            <div class="hidden md:flex gap-[48px] text-[24px]">
                <a href="personal-collection.php">Personal Collection</a>
                <a href="community-collection.php">Community Collection</a>
            </div>
            <div class="flex md:hidden flex-col gap-1">
                <div class="w-8 h-1 bg-black"></div>
                <div class="w-8 h-1 bg-black"></div>
                <div class="w-8 h-1 bg-black"></div>
            </div>
            <a href="account.php" class="hidden md:block w-10 h-10 rounded-full bg-black"></a>
        </div>
    </nav>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex flex-col items-center gap-[30px] justify-center p-6 bg-[#FBFBFD] shadow-md rounded-lg">
            <h1 class="text-[36px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">Add Book</h1>
            <div class="w-full flex flex-col gap-2">
                <p class="font-bold text-[16px]">Title</p>
                <input type="text" name="title" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full flex flex-col gap-2">
                <p class="font-bold text-[16px]">Author</p>
                <input type="text" name="author" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full flex flex-col gap-2">
                <p class="font-bold text-[16px]">Genre</p>
                <input type="text" name="genre" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full flex flex-col gap-2">
                <p class="font-bold text-[16px]">Year Published</p>
                <input type="text" name="year_published" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full flex flex-col gap-2">
                <p class="font-bold text-[16px]">Description</p>
                <textarea maxlength="1000" rows="6" cols="50" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="w-full flex flex-col gap-2">
                <p class="font-bold text-[16px]">Link</p>
                <input type="text" name="link" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-full flex flex-col gap-2 justify-left">
                <p class="font-bold text-[16px]">Cover</p>
                <label class="bg-[#EBF1F4] w-[6.5rem] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left">
                    Choose File
                    <input type="file" name="cover" required class="hidden">
                </label>
            </div>
            <button type="submit" class="w-fill px-16 bg-[#0071E3] text-white p-2 rounded-lg hover:bg-blue-700 transition duration-200">Add</button>
        </div>
    </form>
</body>
</html>