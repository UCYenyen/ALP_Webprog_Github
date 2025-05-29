<?php
    session_start(); 
    include_once("../controller/controller.php");

    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        logoutUser();
        header("Location: ../view/index.php");
        exit;
    }

        // Update the form handling code in controller.php
    if(isset($_POST['action']) && $_POST['action'] === 'update_profile') {
        if(isset($_POST['username'], $_POST['current_password'])) {
            $user_id = intval($_SESSION['user_id']);
            $username = $_POST['username'];
            $new_password = !empty($_POST['new_password']) ? $_POST['new_password'] : '';
            $current_password = $_POST['current_password'];
            
            $result = updateUserProfile($user_id, $username, $new_password, $current_password, 'profile_image');
            if($result === true) {
                header("Location: ../view/account.php?success=1");
            } else {
                header("Location: ../view/account.php?error=" . urlencode($result));
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukuku - Account</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        // Add JavaScript for image preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    let preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    document.getElementById('currentImage').style.display = 'none';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
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
            <?php if(isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image'])): ?>
                <a href="account.php">
                    <img src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                </a>
            <?php else: ?>
                <a href="account.php" class="w-10 h-10 rounded-full bg-black block"></a>
            <?php endif; ?>
        </div>
        </div>
    </nav>
    
   <main class="flex justify-center w-full">
        <div class="w-full bg-white backdrop-blur-lg rounded-3xl shadow-2xl p-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-6 drop-shadow text-center">Edit Account</h1>

            <?php if(isset($_GET['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    Profile updated successfully!
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                
                <!-- Profile Image Section with preview -->
                <div class="flex flex-col items-start space-y-4 mb-6">
                    <div class="w-full flex flex-col gap-2">
                        <p class="text-gray-700 text-sm font-medium">Profile Image</p>
                        <div class="mb-2">
                            <?php if(isset($_SESSION['profile_image']) && !empty($_SESSION['profile_image'])): ?>
                                <img id="currentImage" src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" alt="Current Profile" class="w-24 h-24 rounded-full object-cover">
                            <?php endif; ?>
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
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>"
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
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Save
                    </button>
                    <button type="button" onclick="window.location.href='?action=logout'" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        Logout
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>