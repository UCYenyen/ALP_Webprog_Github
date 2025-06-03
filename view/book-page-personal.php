<?php 
    session_start();
    include_once("../controller/controller.php");

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    $bookDetails = getBookById($_SESSION['book_id']);

    if(isset($_GET['action'])){
        if($_GET['action'] == 'favorite'){
            favoriteBook($_SESSION['book_id']);
        } else if($_GET['action'] == 'remove'){
            removeBook($_SESSION['user_id'], $_SESSION['book_id']);
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
                        src="<?= $bookDetails['cover_image']?>"  
                        class="w-full h-auto object-cover rounded-md shadow-md"
                    >
                </div>
                
                <!-- Book Details -->
                <div class="w-full md:w-3/4">
                    <div class="h-full gap-4 flex flex-col justify-between gap-4">
                        <div>
                            <h1 class="text-[32px] font-bold mb-2"><?= $bookDetails["title"] ?></h1>
                            <div class="flex flex-col gap-2">
                                <p class="text-lg"><strong>Author:</strong> <?= $bookDetails["author"] ?></p>
                                <p class="text-lg"><strong>Genre:</strong> <?= $bookDetails["genre"] ?></p>
                                <p class="text-lg"><strong>Year published:</strong> <?= $bookDetails["year_published"] ?></p>
                            </div>
                            <p class="mt-4 w-[97%] text-justify"><?= $bookDetails["description"] ?></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end gap-4">
                            <a href="<?= $bookDetails["link"]?>" target="_blank" class="flex items-center justify-center gap-2 bg-[#0071E3] text-white px-6 py-2 rounded-md">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 22.2453C17.595 22.2453 22.2454 17.5948 22.2454 11.9998C22.2454 6.39497 17.5847 1.75439 11.9897 1.75439C6.38529 1.75439 1.755 6.39497 1.755 11.9998C1.755 17.5948 6.39515 22.2453 12 22.2453ZM9.399 15.8973C8.37429 15.8973 7.62086 16.2585 7.28958 16.5603C7.15886 16.6605 7.02815 16.7308 6.81729 16.7308C6.55586 16.7308 6.34543 16.6001 6.34543 16.2388V8.47397C6.70672 7.74111 7.86215 7.14839 9.13758 7.14839C10.2729 7.14839 11.2269 7.66054 11.5886 8.35354V16.6605C11.5384 16.6507 11.2671 16.49 11.1767 16.4394C10.8853 16.2585 10.323 15.8973 9.399 15.8973ZM14.592 15.8973C13.668 15.8973 13.0954 16.2487 12.8139 16.4394C12.7136 16.4998 12.4723 16.6708 12.4024 16.6807V8.35354C12.774 7.66054 13.728 7.14839 14.8431 7.14839C16.1186 7.14839 17.274 7.74111 17.6353 8.47397V16.2388C17.6353 16.6001 17.4347 16.7308 17.1733 16.7308C16.9624 16.7308 16.8219 16.6605 16.7014 16.5603C16.3697 16.259 15.6064 15.8973 14.592 15.8973Z" fill="#FBFBFB"/>
                                </svg>
                                Read
                            </a>
                            <?php if(!checkIfBookIsFavorite($_SESSION['book_id'])){?>
                            <a href="?action=favorite" class="flex items-center justify-center gap-2 bg-[#E3009B] text-white px-6 py-2 rounded-md">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 1C17.0711 1 22 5.92886 22 12C22 18.0711 17.0711 23 11 23C4.92886 23 0 18.0711 0 12C0 5.92886 4.92886 1 11 1ZM10.9873 17.9666L10.9833 17.9689H10.9911L10.9873 17.9666ZM10.9873 17.9666C20.5927 12.4307 16.0449 7.98156 13.8669 7.45992C12.4077 7.11067 11.4565 8.02298 10.9873 8.66373C10.5181 8.02298 9.56673 7.11067 8.10769 7.45992C5.92969 7.98139 1.38153 12.4307 10.9873 17.9666Z" fill="#FBFBFB"/>
                                </svg>
                                Favorite
                            </a>
                            <?php } else { ?>
                            <a href="?action=favorite" class="flex items-center justify-center gap-2 bg-[#E3009B] text-white px-6 py-2 rounded-md">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 1C17.5711 1 22.5 5.92886 22.5 12C22.5 18.0711 17.5711 23 11.5 23C5.42886 23 0.5 18.0711 0.5 12C0.5 5.92886 5.42886 1 11.5 1ZM11.4873 17.9666L11.4833 17.9689H11.4911L11.4873 17.9666ZM11.4873 17.9666C21.0927 12.4307 16.5449 7.98156 14.3669 7.45992C12.9077 7.11067 11.9565 8.02298 11.4873 8.66373C11.0181 8.02298 10.0667 7.11067 8.60769 7.45992C6.42969 7.98139 1.88153 12.4307 11.4873 17.9666Z" fill="#FBFBFB"/>
                                    <ellipse cx="11.5" cy="12" rx="10.5" ry="11" fill="white"/>
                                    <path d="M7.73125 6.06123C8.45938 5.93936 9.19375 6.00186 9.875 6.22686L11.4313 8.64874L9.075 11.005C9.02812 11.0519 9 11.1175 9.00313 11.1862C9.00625 11.255 9.03437 11.3175 9.08437 11.3644L12.5844 14.6144C12.675 14.6987 12.8156 14.705 12.9125 14.6237C13.0094 14.5425 13.0312 14.405 12.9656 14.2987L11.0781 11.2331L13.9125 8.87061C13.9938 8.80499 14.0219 8.69248 13.9875 8.59561L13.275 6.61436C14.1656 6.09249 15.225 5.88936 16.2656 6.06436C18.4219 6.42061 20 8.28311 20 10.4675V10.6487C20 11.9456 19.4625 13.1862 18.5125 14.0706L12.8656 19.3425C12.6313 19.5612 12.3219 19.6831 12 19.6831C11.6781 19.6831 11.3688 19.5612 11.1344 19.3425L5.4875 14.0706C4.5375 13.1862 4 11.9456 4 10.6487V10.4675C4 8.28311 5.57812 6.42061 7.73125 6.06123Z" fill="#E3009B"/>
                                </svg>
                                Unfavorite
                            </a>
                            <?php } ?>
                            <a href="?action=remove" class="flex items-center justify-center gap-2 bg-[#FE3A31] text-white px-6 py-2 rounded-md">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.59 7.46984V8.02984H10.47V7.46984C10.4809 7.36834 10.5189 7.27164 10.58 7.18984C10.6597 7.13355 10.7528 7.09908 10.85 7.08984H13.4C13.4433 7.1106 13.481 7.14147 13.51 7.17984C13.5458 7.21509 13.5762 7.25555 13.6 7.29984C13.6131 7.35629 13.6097 7.41533 13.59 7.46984Z" fill="#FBFBFB"/>
                                    <path d="M15.25 2H8.75C6.9606 2.00265 5.24525 2.71465 3.97995 3.97995C2.71465 5.24525 2.00265 6.9606 2 8.75V15.25C2.00265 17.0394 2.71465 18.7548 3.97995 20.0201C5.24525 21.2853 6.9606 21.9974 8.75 22H15.25C17.0402 22 18.7571 21.2888 20.023 20.023C21.2888 18.7571 22 17.0402 22 15.25V8.75C22 6.95979 21.2888 5.2429 20.023 3.97703C18.7571 2.71116 17.0402 2 15.25 2ZM17.5 8.88C17.4692 8.96192 17.4175 9.03433 17.35 9.09C17.2878 9.15223 17.2127 9.20003 17.13 9.23C17.0444 9.249 16.9556 9.249 16.87 9.23H16.32V15.58C16.3214 15.861 16.2663 16.1395 16.1581 16.3989C16.0499 16.6583 15.8907 16.8933 15.69 17.09C15.4943 17.2921 15.2595 17.4522 14.9999 17.5605C14.7403 17.6688 14.4613 17.7231 14.18 17.72H9.93C9.36325 17.7174 8.82046 17.4911 8.4197 17.0903C8.01894 16.6895 7.79263 16.1468 7.79 15.58V9.21H7.25C7.17405 9.22483 7.09595 9.22483 7.02 9.21C6.94444 9.17753 6.87637 9.12988 6.82 9.07C6.76198 9.01205 6.71459 8.94435 6.68 8.87C6.66618 8.7906 6.66618 8.7094 6.68 8.63C6.68548 8.46752 6.75356 8.31345 6.87 8.2C6.92519 8.14101 6.99173 8.09378 7.06562 8.06113C7.13951 8.02848 7.21923 8.01109 7.3 8.01H9.72V7.72C9.73 7.313 9.89 6.925 10.17 6.63C10.4596 6.34923 10.8467 6.19153 11.25 6.19H13.08C13.4852 6.19208 13.8732 6.35376 14.16 6.64C14.308 6.78 14.424 6.951 14.5 7.14C14.581 7.322 14.619 7.52 14.61 7.72V8.01H17.03C17.1125 8.00973 17.1941 8.02647 17.2698 8.05916C17.3455 8.09185 17.4137 8.13979 17.47 8.2C17.5281 8.25532 17.5741 8.32211 17.6051 8.39612C17.6361 8.47014 17.6514 8.54977 17.65 8.63C17.6301 8.72156 17.589 8.80718 17.53 8.88H17.5Z" fill="#FBFBFB"/>
                                </svg>
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>