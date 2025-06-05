<?php 
    session_start();
    include_once("../controller/controller.php");

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    
    $allBooks = getAllBook();
    $trendingBooks = getTrendingBooks();
    $searchedBook = null;

    $isSearchingTrending = false;
    $isSearchingCommunity = false; 

    if (isset($_GET['action'])) {
        if($_GET['action'] == 'book-page'){
            openBookPage($_GET['id']);
        }

        if($_GET['action'] == 'search-trending'){
            $searchQuery = $_GET['search-trending'] ?? '';
            $isSearchingTrending = true;
            $searchedBook = searchBook(title: $searchQuery);
        }else if($_GET['action'] == 'search-community'){
            $searchQuery = $_GET['search-community'] ?? '';
            $isSearchingCommunity = true;
            $searchedBook = searchBook($searchQuery);
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
    <script src="../controller/controller.js"></script>
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
</head>
<body onload="makeBackgroundToFit()">
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

        <!-- Trending Books -->
        <div class="slide flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
            <!-- TOP -->
            <div class="flex gap-2 sm:gap-0 flex-col sm:flex-row items-left sm:justify-between sm:items-center">
                <h1 class="text-[32px] font-bold text-left">Trending Books</h1>
                <form action="" method="get" class="flex gap-4 items-center justify-center bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg">
                    <input type="hidden" name="action" value="search-trending">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search-trending"
                        placeholder="Search books..."
                        class="focus:outline-none w-full"
                        value="<?php echo isset($_GET['search-trending']) ? $_GET['search-trending'] : ''; ?>"
                        oninput="this.value ? displaySearchedBook() : resetBookDisplay();"
                    >
                </form>
            </div>
            <!-- BOOKS -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-[20px] w-full">
                <?php 
                if(!$isSearchingTrending){
                    foreach($trendingBooks as $book){
                        $coverImage = $book['cover_image'];
                        $bookId = $book['id']; // Make sure to get the book ID
                ?>
                    <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full">
                        <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                    </a>
                <?php 
                    }
                }else{
                    foreach($searchedBook as $book){
                        $coverImage = $book['cover_image'];
                        $bookId = $book['id'];
                ?>
                    <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full">
                        <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                    </a>
                <?php 
                    }
                }
                ?>
            </div>
        </div>

        <!-- Community Collections -->
        <div class="slide flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
            <!-- TOP -->
            <div class="flex gap-2 sm:gap-0 flex-col sm:flex-row items-left sm:justify-between sm:items-center">
                <h1 class="text-[32px] font-bold text-left">Community Books</h1>
                <form action="" method="get" class="flex gap-4 items-center justify-center bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg">
                    <input type="hidden" name="action" value="search-community">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search-community"
                        placeholder="Search books..."
                        class="focus:outline-none w-full"
                        value="<?php echo isset($_GET['search-community']) ? $_GET['search-community'] : ''; ?>"
                        oninput="this.value ? displaySearchedBook() : resetBookDisplay();"
                    >
                </form>
            </div>
            <!-- BOOKS -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-[20px] w-full">
                <?php 
                if(!$isSearchingCommunity){
                    foreach($allBooks as $book){
                        $coverImage = $book['cover_image'];
                        $bookId = $book['id'];   
                ?>
                    <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full">
                        <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                    </a>
                <?php 
                    }
                }else{
                    foreach($searchedBook as $book){
                            $coverImage = $book['cover_image'];
                            $bookId = $book['id'];
                    ?>
                        <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full">
                            <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                        </a>
                    <?php 
                        }
                    }
                ?>
            </div>
            <!-- Navigation -->
            <div class="flex justify-end w-full">
                <a href="add-book-form.php" class="flex w-full sm:w-fit items-center justify-center sm:justify-end gap-2 bg-[#0071E3] text-white px-6 py-2 rounded-md">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.34502 4.01717C10.4389 3.67462 13.5611 3.67462 16.655 4.01717C18.368 4.20917 19.75 5.55817 19.951 7.27717C20.3176 10.4152 20.3176 13.5852 19.951 16.7232C19.75 18.4422 18.368 19.7912 16.655 19.9832C13.5611 20.3257 10.4389 20.3257 7.34502 19.9832C5.63202 19.7912 4.25002 18.4422 4.04902 16.7232C3.68247 13.5855 3.68247 10.4158 4.04902 7.27817C4.15069 6.44304 4.5314 5.66671 5.12945 5.07501C5.7275 4.48331 6.50785 4.11091 7.34402 4.01817M12 7.00717C12.1989 7.00717 12.3897 7.08619 12.5303 7.22684C12.671 7.36749 12.75 7.55826 12.75 7.75717V11.2502H16.243C16.4419 11.2502 16.6327 11.3292 16.7733 11.4698C16.914 11.6105 16.993 11.8013 16.993 12.0002C16.993 12.1991 16.914 12.3898 16.7733 12.5305C16.6327 12.6712 16.4419 12.7502 16.243 12.7502H12.75V16.2432C12.75 16.4421 12.671 16.6328 12.5303 16.7735C12.3897 16.9142 12.1989 16.9932 12 16.9932C11.8011 16.9932 11.6103 16.9142 11.4697 16.7735C11.329 16.6328 11.25 16.4421 11.25 16.2432V12.7502H7.75702C7.55811 12.7502 7.36734 12.6712 7.22669 12.5305C7.08604 12.3898 7.00702 12.1991 7.00702 12.0002C7.00702 11.8013 7.08604 11.6105 7.22669 11.4698C7.36734 11.3292 7.55811 11.2502 7.75702 11.2502H11.25V7.75717C11.25 7.55826 11.329 7.36749 11.4697 7.22684C11.6103 7.08619 11.8011 7.00717 12 7.00717Z" fill="white"/>
                    </svg>
                    Add
                </a>
            </div>
        </div>
    </div>
</body>
</html>