<?php 
    session_start();
    include_once("../controller/controller.php");
    
    // Redirect to login if not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    
    // Get the current user's ID
    $user_id = $_SESSION['user_id'];

    $allOwnedBooks = getPersonalBooks($user_id);


    if (isset($_GET['action']) && $_GET['action'] == 'book-page-personal') {
        openBookPagePersonal($_GET['id']);
    }

    $searchedBook = null;

    $isSearchingFavorite = false;
    $isSearchingOwned = false; 

    if (isset($_GET['action'])) {
        if($_GET['action'] == 'book-page'){
            openBookPage($_GET['id']);
        }

        if($_GET['action'] == 'search-favorite'){
            $searchQuery = $_GET['search-favorite'] ?? '';
            $isSearchingFavorite = true;
            $searchedBook = searchBook($searchQuery);
        }else if($_GET['action'] == 'search-owned'){
            $searchQuery = $_GET['search-owned'] ?? '';
            $isSearchingOwned = true;
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
    <script src="../controller/controller.js"></script>

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
<body onload='makeBackgroundToFit()'>
    <!-- Mobile navbar if clicked -->
    <div id="mobile-navbar" class="z-100 hidden fixed flex justify-between flex-col w-screen h-screen bg-[#F3F7FA]/90 backdrop-blur-sm p-12">
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

        <!-- Main Content -->
        <div class="slide flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
            <!-- TOP -->
            <div class="flex gap-2 sm:gap-0 flex-col sm:flex-row items-left sm:justify-between sm:items-center">
                <h1 class="text-[32px] font-bold text-left">Favorite Books</h1>
                <form action="" method="get" class="flex gap-4 items-center justify-center bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg">
                    <input type="hidden" name="action" value="search-favorite">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search-favorite"
                        placeholder="Search books..."
                        class="focus:outline-none w-full"
                        value="<?php echo isset($_GET['search-favorite']) ? $_GET['search-favorite'] : ''; ?>"
                        oninput="this.value ? displaySearchedBook() : resetBookDisplay();"
                    >
                </form>
            </div>
            <!-- BOOKS -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-[20px] w-full">
                <?php 
                if(!$isSearchingFavorite){
                    foreach($allOwnedBooks as $book){
                        if($book['is_favorite'] == 1){
                            $coverImage = $book['cover_image'];
                            $bookId = $book['book_id'];
                ?>
                        <a href="?action=book-page-personal&id=<?= $bookId ?>" class="card w-full h-full">
                            <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                        </a>
                <?php 
                        }
                    }
                }else{
                    foreach($searchedBook as $book){
                        if(checkIfBookIsFavorite($book['id'])){
                            $coverImage = $book['cover_image'];
                            $bookId = $book['id'];
                ?>
                        <a href="?action=book-page-personal&id=<?= $bookId ?>" class="card w-full h-full">
                            <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                        </a>
                <?php 
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Collections -->
        <div class="slide flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
            <!-- TOP -->
            <div class="flex gap-2 sm:gap-0 flex-col sm:flex-row items-left sm:justify-between sm:items-center">
                <h1 class="text-[32px] font-bold text-left">My Books</h1>
                <form action="" method="get" class="flex gap-4 items-center justify-center bg-[#EBF1F4] p-2 border border-gray-300 rounded-lg">
                    <input type="hidden" name="action" value="search-owned">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search-owned"
                        placeholder="Search books..."
                        class="focus:outline-none w-full"
                        value="<?php echo isset($_GET['search-owned']) ? $_GET['search-owned'] : ''; ?>"
                        oninput="this.value ? displaySearchedBook() : resetBookDisplay();"
                    >
                </form>
            </div>
            <?php if($allOwnedBooks != null || empty($allOwnedBooks)){?>
            <!-- BOOKS -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-[20px] w-full">
                <?php 
                if(!$isSearchingOwned){
                    foreach($allOwnedBooks as $book){
                ?>
                    <a href="?action=book-page-personal&id=<?=$book['book_id']?>" class="card w-full h-full">
                        <img class="rounded-lg object-cover object-left w-full h-full" src="<?=$book['cover_image']?>" id="book_<?= $book['id'] ?>">
                    </a>
                <?php 
                    }
                }else{
                    foreach($searchedBook as $book){
                        $coverImage = $book['cover_image'];
                        $bookId = $book['id'];
                ?>
                    <a href="?action=book-page-personal&id=<?= $bookId ?>" class="card w-full h-full">
                        <img class="object-cover object-left w-full h-full rounded-lg" src="<?= $coverImage ?>">
                    </a>
                <?php 
                    }
                }
                ?>
            </div>
            <?php } else {?>
                <div class="flex justify-center items-center w-full h-full">
                    <p class="text-gray-500 text-lg">No books found in your personal collection.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>