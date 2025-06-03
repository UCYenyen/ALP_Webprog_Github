<?php 
    session_start();
    include_once("../controller/controller.php");

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $bookDetails = getBookById($_SESSION['book_id']);

    if(isset($_GET['action'])){
        if($_GET['action'] == 'edit'){
            header("Location: edit-book.php");
            exit();
        } else if($_GET['action'] == 'get'){
            getBook($_SESSION['book_id'], $_SESSION['user_id']);
        } else if($_GET['action'] == 'delete'){
            deleteBook($_SESSION['book_id']);
        }
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
    <div id="mobile-navbar" class="hidden fixed flex justify-between flex-col w-screen h-screen bg-[#F3F7FA]/97 backdrop-blur-sm p-12">
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

        <!-- Book Details -->
        <div class="flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
            <div class="flex flex-col md:flex-row gap-8 h-full justify-between">
                <!-- Book Cover Image -->
            <div class="w-full sm:w-[21rem]">
                    <img 
                        src="<?= $bookDetails["cover_image"] ?>"  
                        class="w-full h-auto object-cover rounded-md shadow-md"
                    >
                </div>
                
                <!-- Book Details -->
                <div class="w-full md:w-3/4">
                    <div class="h-full flex flex-col justify-between">
                        <div>
                            <h1 class="text-[32px] font-bold mb-2"><?= $bookDetails["title"] ?></h1>
                            <div class="flex flex-col gap-2">
                                <p class="text-lg"><strong>Author:</strong> <?= $bookDetails["author"] ?></p>
                                <p class="text-lg"><strong>Genre:</strong> <?= $bookDetails["genre"] ?></p>
                                <p class="text-lg"><strong>Year published:</strong> <?= $bookDetails["year_published"] ?></p>
                            </div>
                            <p class="mt-4 text-justify"><?= $bookDetails["description"]?></p>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end gap-4">
                            <?php if(!checkIfBookAlreadyOwned($bookDetails['id'], $_SESSION['user_id'])){?>
                            <a href="?action=get" class="flex items-center justify-center gap-2 bg-[#0071E3] text-white px-6 py-2 rounded-md">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 20.11 20.11 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 3.9 3.9 3 5 3ZM8 17H16V15H8V17ZM16 10H13.5V7H10.5V10H8L12 14L16 10Z" fill="#FBFBFB"/>
                                </svg>
                                Get
                            </a>
                            <?php } else { ?>
                                <p class="text-gray-400">You already owned this book.</p>
                            <?php } ?>
                            <?php if($bookDetails['owner_id'] == $_SESSION['user_id']){?>
                            <a href="?action=edit" class="flex items-center justify-center gap-2 bg-[#56C877] text-white px-6 py-2 rounded-md">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 3C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19ZM16.7 9.35C16.92 9.14 16.92 8.79 16.7 8.58L15.42 7.3C15.3705 7.24765 15.3108 7.20594 15.2446 7.17744C15.1784 7.14895 15.1071 7.13425 15.035 7.13425C14.9629 7.13425 14.8916 7.14895 14.8254 7.17744C14.7592 7.20594 14.6995 7.24765 14.65 7.3L13.65 8.3L15.7 10.35L16.7 9.35ZM7 14.94V17H9.06L15.12 10.94L13.06 8.88L7 14.94Z" fill="#FBFBFB"/>
                                </svg>
                                Edit
                            </a>

                            <a href="?action=delete" class="flex items-center justify-center gap-2 bg-[#FE3A31] text-white px-6 py-2 rounded-md">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.59 7.46984V8.02984H10.47V7.46984C10.4809 7.36834 10.5189 7.27164 10.58 7.18984C10.6597 7.13355 10.7528 7.09908 10.85 7.08984H13.4C13.4433 7.1106 13.481 7.14147 13.51 7.17984C13.5458 7.21509 13.5762 7.25555 13.6 7.29984C13.6131 7.35629 13.6097 7.41533 13.59 7.46984Z" fill="#FBFBFB"/>
                                    <path d="M15.25 2H8.75C6.9606 2.00265 5.24525 2.71465 3.97995 3.97995C2.71465 5.24525 2.00265 6.9606 2 8.75V15.25C2.00265 17.0394 2.71465 18.7548 3.97995 20.0201C5.24525 21.2853 6.9606 21.9974 8.75 22H15.25C17.0402 22 18.7571 21.2888 20.023 20.023C21.2888 18.7571 22 17.0402 22 15.25V8.75C22 6.95979 21.2888 5.2429 20.023 3.97703C18.7571 2.71116 17.0402 2 15.25 2ZM17.5 8.88C17.4692 8.96192 17.4175 9.03433 17.35 9.09C17.2878 9.15223 17.2127 9.20003 17.13 9.23C17.0444 9.249 16.9556 9.249 16.87 9.23H16.32V15.58C16.3214 15.861 16.2663 16.1395 16.1581 16.3989C16.0499 16.6583 15.8907 16.8933 15.69 17.09C15.4943 17.2921 15.2595 17.4522 14.9999 17.5605C14.7403 17.6688 14.4613 17.7231 14.18 17.72H9.93C9.36325 17.7174 8.82046 17.4911 8.4197 17.0903C8.01894 16.6895 7.79263 16.1468 7.79 15.58V9.21H7.25C7.17405 9.22483 7.09595 9.22483 7.02 9.21C6.94444 9.17753 6.87637 9.12988 6.82 9.07C6.76198 9.01205 6.71459 8.94435 6.68 8.87C6.66618 8.7906 6.66618 8.7094 6.68 8.63C6.68548 8.46752 6.75356 8.31345 6.87 8.2C6.92519 8.14101 6.99173 8.09378 7.06562 8.06113C7.13951 8.02848 7.21923 8.01109 7.3 8.01H9.72V7.72C9.73 7.313 9.89 6.925 10.17 6.63C10.4596 6.34923 10.8467 6.19153 11.25 6.19H13.08C13.4852 6.19208 13.8732 6.35376 14.16 6.64C14.308 6.78 14.424 6.951 14.5 7.14C14.581 7.322 14.619 7.52 14.61 7.72V8.01H17.03C17.1125 8.00973 17.1941 8.02647 17.2698 8.05916C17.3455 8.09185 17.4137 8.13979 17.47 8.2C17.5281 8.25532 17.5741 8.32211 17.6051 8.39612C17.6361 8.47014 17.6514 8.54977 17.65 8.63C17.6301 8.72156 17.589 8.80718 17.53 8.88H17.5Z" fill="#FBFBFB"/>
                                </svg>
                                Delete
                            </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>