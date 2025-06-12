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
            $searchQuery = $_GET['search-trending'];
            $isSearchingTrending = true;
            $searchedBook = searchBook($searchQuery);
        }else if($_GET['action'] == 'search-community'){
            $searchQuery = $_GET['search-community'];
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
            }, "<");
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
                    <a 
                        class="rounded-xl p-2 transition-all duration-200 ease-in-out hover:bg-[#0071E3]/80 hover:text-white" 
                        href="personal-collection.php"
                    >
                        Personal Collection
                    </a>
                    <a 
                        class="bg-[#0071E3]/60 text-white rounded-xl p-2 transition-all duration-200 ease-in-out hover:bg-[#005bb5]/80" 
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
                    <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full border-1 border-gray-200 rounded-lg">
                        <img class="object-cover object-center w-full h-full rounded-lg" src="<?= $coverImage ?>">
                    </a>
                <?php 
                    }
                }else{
                    foreach($searchedBook as $book){
                        $coverImage = $book['cover_image'];
                        $bookId = $book['id'];
                ?>
                    <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full border-1 border-gray-200 rounded-lg">
                        <img class="object-cover object-center w-full h-full rounded-lg" src="<?= $coverImage ?>">
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
                    >
                </form>
            </div>
            <!-- BOOKS -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-[20px] w-full">
                <a href="add-book-form.php" class="card w-full h-full border-1 border-gray-200 rounded-lg">
                    <div class="bg-[#DDE1E6]/75 w-full h-full flex flex-col items-center justify-center rounded-lg">
                        <svg class='w-1/3 h-1/3 opacity-[75%]' width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.34502 1.01717C7.4389 0.674616 10.5611 0.674616 13.655 1.01717C15.368 1.20917 16.75 2.55817 16.951 4.27717C17.3176 7.41516 17.3176 10.5852 16.951 13.7232C16.75 15.4422 15.368 16.7912 13.655 16.9832C10.5611 17.3257 7.4389 17.3257 4.34502 16.9832C2.63202 16.7912 1.25002 15.4422 1.04902 13.7232C0.682473 10.5855 0.682473 7.41583 1.04902 4.27817C1.15069 3.44304 1.5314 2.66671 2.12945 2.07501C2.7275 1.48331 3.50785 1.11091 4.34402 1.01817M9.00002 4.00717C9.19893 4.00717 9.3897 4.08619 9.53035 4.22684C9.671 4.36749 9.75002 4.55826 9.75002 4.75717V8.25017H13.243C13.4419 8.25017 13.6327 8.32919 13.7733 8.46984C13.914 8.61049 13.993 8.80126 13.993 9.00017C13.993 9.19908 13.914 9.38985 13.7733 9.5305C13.6327 9.67115 13.4419 9.75017 13.243 9.75017H9.75002V13.2432C9.75002 13.4421 9.671 13.6328 9.53035 13.7735C9.3897 13.9142 9.19893 13.9932 9.00002 13.9932C8.80111 13.9932 8.61034 13.9142 8.46969 13.7735C8.32904 13.6328 8.25002 13.4421 8.25002 13.2432V9.75017H4.75702C4.55811 9.75017 4.36734 9.67115 4.22669 9.5305C4.08604 9.38985 4.00702 9.19908 4.00702 9.00017C4.00702 8.80126 4.08604 8.61049 4.22669 8.46984C4.36734 8.32919 4.55811 8.25017 4.75702 8.25017H8.25002V4.75717C8.25002 4.55826 8.32904 4.36749 8.46969 4.22684C8.61034 4.08619 8.80111 4.00717 9.00002 4.00717Z" fill="#0071E3" fill-opacity="0.7"/>
                        </svg>
                        <h1 class="text-4xl font-bold text-[#0071E3] opacity-[50%] ">Add</h1>
                    </div>
                </a>
                <?php 
                if(!$isSearchingCommunity){
                    foreach($allBooks as $book){
                        $coverImage = $book['cover_image'];
                        $bookId = $book['id'];   
                ?>
                    <a href="?action=book-page&id=<?= $bookId ?>" class="card w-full h-full border-1 border-gray-200 rounded-lg">
                        <img class="object-cover object-center w-full h-full rounded-lg" src="<?= $coverImage ?>">
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
    </div>
</body>
</html>