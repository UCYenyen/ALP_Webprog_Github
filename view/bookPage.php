<?php 
    session_start();
    include_once("../controller/controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bryan Fernando - Obie Zuriel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex flex-col gap-[30px] bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] p-12">
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
            <div class="hidden md:block">
                <a href="account.php" class="w-10 h-10 rounded-full bg-black block"></a>
            </div>
        </div>
    </nav>

    <!-- Book Details -->
    <div class="flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
        <div class="relative flex flex-col md:flex-row gap-8 h-full justify-between">
            <!-- Book Cover Image -->
            <div class="w-full md:w-1/4">
                <img 
                    src=""  
                    class="w-full h-auto object-cover rounded-md shadow-md"
                >
            </div>
            
            <!-- Book Details -->
            <div class="w-full h-full md:w-3/4">
                <h1 class="text-[32px] font-bold mb-2">Title</h1>
                <div class="flex flex-col gap-2">
                    <p class="text-lg"><strong>Author:</strong> Banana</p>
                    <p class="text-lg"><strong>Genre:</strong> Sex</p>
                    <p class="text-lg"><strong>Year published:</strong> 2024</p>
                </div>
                <p class="mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti dolore numquam aliquid harum, cumque sed. Quisquam, saepe. Cum possimus ipsum placeat eaque sequi corrupti eligendi, quisquam provident a! Ducimus, id. ?></p>
                <a href="#" class="text-blue-500 hover:underline mt-2 inline-block" id="read-more">Read more</a>
                
                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 absolute bottom-1 right-1">
                    <button type="submit" class="flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Get
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>