<?php
    session_start();
    include_once("../controller/controller.php"); 
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['action'])) {
        if($_GET['action'] == 'logout'){
            logoutUser();
        }else if($_GET['action'] == 'delete'){
            deleteUser($_SESSION['user_id']);
            exit();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = null;
        $profile_image = null;

        if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
            $new_password = htmlspecialchars($_POST['new_password']);
        }
        
        $password = htmlspecialchars($_POST['current_password']);
        $_SESSION['last_password'] = $password; // Store the last password for comparison

        

        if (isset($_FILES['profile_image'])) {
            $profile_image = htmlspecialchars($_FILES['profile_image']['name']);
        }

        updateUser($_SESSION['user_id'], $password, $new_password, $profile_image);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukuku</title>
    <script src="../controller/controller.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/TextPlugin.min.js"></script>

   <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tl = gsap.timeline();
            tl.from(".slide", {
                x: -100,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                ease: "power3.out"
            });
            tl.from(".card", {
                opacity: 0,
                duration: 0.5,
                stagger: 0.1,
                ease: "back.out(1.7)"
            }, .2); // Start at the same time as the previous animation
        });
    </script>
    
    <script>
    function makeBackgroundToFit(){
        const body = document.getElementById('container');
        <?php if(empty($allBooks)) { ?>
        body.classList.add('h-screen');
        <?php } else { ?>
        body.classList.remove('h-screen');
        <?php } ?>
    }
    </script>
</head>
<body class="" onload='makeBackgroundToFit()'>
    <div id="mobile-navbar" class="z-100 hidden fixed flex justify-between flex-col w-screen h-screen bg-[#F3F7FA]/97 backdrop-blur-sm p-12">
        <div class="p-4">
            <div onclick='openMoibileNavbar()' class="flex justify-end w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="black" x="0px" y="0px" width="50" height="50" viewBox="0 0 30 30">
                    <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z"></path>
                </svg>
            </div>
        </div>
        <div class="flex flex-col gap-4 items-center">
            <a href="account.php" class="w-full text-[20px] text-center font-bold mb-4">
                Account
            </a>
            <a href="personal-collection.php" class="w-full text-[20px] text-center font-bold mb-4">
                Personal Collections
            </a>
            <a href="community-collection.php" class="text-[20px] text-center font-bold mb-4">
                Community Collections
            </a>
        </div>
        <div></div>
    </div>

    <div id="container" class="flex flex-col gap-[30px] bg-gradient-to-b from-[#D4EAF5] to-[#F3F7FA] p-12">
        <!-- Navbar -->
        <nav class="slide flex justify-center items-center">
            <div class="w-screen p-6 flex items-center justify-between bg-white shadow-md rounded-lg">
                <h1 class="text-[32px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">
                    Bukuku
                </h1>
                <div class="hidden md:flex gap-[48px] text-[22px]">
                    <a href="personal-collection.php">Personal Collection</a>
                    <a href="community-collection.php">Community Collection</a>
                </div>
                <div onclick='openMoibileNavbar()' class="flex md:hidden flex-col gap-1">
                    <div class="w-8 h-1 bg-black"></div>
                    <div class="w-8 h-1 bg-black"></div>
                    <div class="w-8 h-1 bg-black"></div>
                </div>
                <div class="hidden md:flex">
                    <?php if((isset($_SESSION['profile_image']))){?>
                            <a href="account.php" class="w-12 h-12 rounded-full flex">
                                <img src="uploads/profiles/<?= $_SESSION['profile_image'] ?>" class="w-full h-full object-top object-cover rounded-full border-2 border-white shadow-md">
                            </a>
                    <?php } else { ?>
                            <a href="account.php" class="w-10 h-10 rounded-full bg-black block"></a>
                    <?php } ?>
                </div>
            </div>
        </nav>
        
        <main class="slide flex justify-center w-full">
            <div class="w-full bg-white backdrop-blur-lg rounded-3xl shadow-2xl p-8">
                <h1 class="text-3xl font-bold text-slate-900 mb-6 drop-shadow text-center">Edit Account</h1>

                <form action="" method="POST" class="space-y-6" enctype="multipart/form-data">
                    <?php
                    if (isset($password) && !empty($password)) {
                        if ($password != $_SESSION['last_password']) {
                            // If the password is incorrect, show an error message
                            echo "<div class='bg-red-300 w-full px-4 py-2 border border-gray-300 rounded-lg'>Incorrect password!</div>";
                        } else {
                            // If the password is correct and form was submitted, show success message
                            echo "<div class='bg-green-300 w-full px-4 py-2 border border-gray-300 rounded-lg'>Update success!</div>";
                        }
                    }?>

                    <input type="hidden" name="action" value="update_profile">
                    
                    <!-- Profile Image Section with preview -->
                    <div class="flex flex-col items-start space-y-4 mb-6">
                        <div class="w-full flex flex-col gap-2">
                            <p class="text-gray-700 text-sm font-medium">Profile Image</p>
                            <div class="mb-2">
                                <!-- Image preview element -->
                                <img id="imagePreview" src="#" alt="Image Preview" class="w-24 h-24 rounded-full object-cover hidden object-top">
                            </div>
                            <label class="bg-[#EBF1F4] w-[6.5rem] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left">
                                Choose File
                                <input type="file" name="profile_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" value="<?= $_SESSION['username']?>" readonly disabled
                            class="bg-[#E4E4E4] w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <div class="flex flex-col-reverse sm:flex-row justify-between gap-4">
                        <a href="?action=delete" class="px-6 py-2 bg-slate-400 text-white rounded-lg hover:bg-red-600 transition inline-block text-center">
                                Delete Account
                        </a>
                        <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-4">
                            <button type="submit" name="save" class="w-full px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                Save
                            </button>
                            <a href="?action=logout" class="w-full px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition inline-block text-center">
                                Logout
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>