<?php 
    session_start();
    include_once("../controller/controller.php");

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = htmlspecialchars($_POST['title']);
        $author = htmlspecialchars($_POST['author']);
        $genre = htmlspecialchars($_POST['genre']);
        $year_published = htmlspecialchars($_POST['year_published']);
        $description = htmlspecialchars($_POST['description']);
        $link = htmlspecialchars($_POST['link']);
        $cover = htmlspecialchars($_FILES['cover']['name']);

        addNewBook($title, $author, $genre, $year_published, $cover, $description, $link);
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
</head>
<body class="">
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
        <nav class="flex justify-center items-center">
            <div class="w-screen p-6 flex items-center justify-between bg-white shadow-md rounded-lg">
                <h1 class="text-[32px] font-bold bg-gradient-to-r from-[#042740] to-[#5283AB] bg-clip-text text-transparent">
                    Bukuku
                </h1>
                <div class="hidden md:flex gap-[48px] text-[22px]">
                    <a 
                        class="rounded-xl p-2 transition-all duration-200 ease-in-out hover:bg-[#0071E3]/80 hover:text-white" 
                        href="personal-collection.php"
                    >
                        Personal Collection
                    </a>
                    <a 
                        class="rounded-xl p-2 transition-all duration-200 ease-in-out hover:bg-[#0071E3]/80 hover:text-white" 
                        href="community-collection.php"
                    >
                        Community Collection
                    </a>
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
                    <input type="number" name="year_published" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Description</p>
                    <textarea name="description" maxlength="1000" rows="6" cols="50" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-[16px]">Link</p>
                    <input type="link" name="link" required class="w-full bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-full flex flex-col gap-2 justify-left">
                    <p class="font-bold text-[16px]">Cover</p>
                    <img id="imagePreview" src="#" alt="Image Preview" class="w-24 h-24 rounded-lg object-cover hidden object-top">
                    <label class="bg-[#EBF1F4] w-[6.5rem] p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-left">
                        Choose File
                        <input type="file" name="cover" required class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                <button type="submit" class="w-fill px-16 bg-[#0071E3] text-white p-2 rounded-lg hover:bg-blue-700 transition duration-200">Add</button>
            </div>
        </form>
    </div>   
</body>
</html>