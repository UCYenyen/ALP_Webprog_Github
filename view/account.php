<?php
    session_start();
    include_once("../controller/controller.php"); 
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        logoutUser();
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
<body class="h-screen sm:h-full flex flex-col gap-[30px] bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] p-12">
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
    
    <main class="flex justify-center w-full">
        <div class="w-full bg-white backdrop-blur-lg rounded-3xl shadow-2xl p-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-6 drop-shadow text-center">Edit Account</h1>

            <form action="" method="POST" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                
                <!-- Profile Image Section with preview -->
                <div class="flex flex-col items-start space-y-4 mb-6">
                    <div class="w-full flex flex-col gap-2">
                        <p class="text-gray-700 text-sm font-medium">Profile Image</p>
                        <div class="mb-2">
                            <!-- Image preview element -->
                            <img id="imagePreview" src="#" alt="Image Preview" class="w-24 h-24 rounded-full object-cover hidden">
                        </div>
                        <label class="bg-[#EBF1F4] w-[6.5rem] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left">
                            Choose File
                            <input type="file" name="profile_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                </div>

                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value=""
                        class="bg-[#EBF1F4] w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="new_password"
                        class="bg-[#EBF1F4] w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Leave blank if you don't want to change password</p>
                </div>
                <div>
                    <label for="current_password" class="block mb-2 text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="bg-[#EBF1F4] w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Required to confirm changes</p>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="submit" name="save" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Save
                    </button>
                    <a href="?action=logout" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition inline-block text-center">
                        Logout
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>