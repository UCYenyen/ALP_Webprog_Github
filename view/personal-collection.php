<?php 
    session_start();
    include_once("../controller/controller.php");
    
    // Redirect to login if not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
    
    // Get the current user's ID
    $user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukuku - Personal Collection</title>
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

    <!-- Main Content -->
    <div class="flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
        <!-- TOP -->
        <div class="flex flex-col sm:flex-row justify-between justify-left sm:items-center">
            <h1 class="text-[32px] font-bold text-left">Favorite Books</h1>
            <form action="" method="get" class="flex items-center gap-2 bg-[#EBF1F4]">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <!-- Search Icon SVG -->
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search books..."
                        class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                    >
                </div>
            </form>
        </div>
        <!-- BOOKS -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-[20px] w-full">
            <?php
                $favoriteBooks = getUserFavoriteBooks($user_id);
                if (!empty($favoriteBooks)) {
                    foreach($favoriteBooks as $book) {
            ?>
                <a href="bookPage.php?id=<?= htmlspecialchars($book['id']) ?>" class="w-full h-full">
                    <img class="object-cover object-left w-full h-full" src="<?= htmlspecialchars($book['cover_image']) ?>">
                </a>
            <?php
                    }
                } else {
                    echo '<p class="col-span-4 text-center text-gray-500 py-4">No favorite books yet.</p>';
                }
            ?>
        </div>
    </div>

    <!-- Collections -->
    <div class="flex flex-col bg-white shadow-md rounded-lg p-6 gap-[20px]">
        <!-- TOP -->
        <div class="flex flex-col sm:flex-row justify-between justify-left sm:items-center">
            <h1 class="text-[32px] font-bold text-left">My Books</h1>
            <form action="" method="get" class="flex items-center gap-2 bg-[#EBF1F4]">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <!-- Search Icon SVG -->
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        placeholder="Search books..."
                        class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                    >
                </div>
            </form>
        </div>
        <!-- BOOKS -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-[20px] w-full">
            <?php
                $personalBooks = getUserPersonalCollection($user_id);
                if (!empty($personalBooks)) {
                    foreach($personalBooks as $book) {
            ?>
                <a href="bookPage.php?id=<?= htmlspecialchars($book['id']) ?>" class="w-full h-full">
                    <img class="object-cover object-left w-full h-full" src="<?= htmlspecialchars($book['cover_image']) ?>">
                </a>
            <?php
                    }
                } else {
                    echo '<p class="col-span-4 text-center text-gray-500 py-4">No books in your collection yet. Visit the community collection to add books!</p>';
                }
            ?>
        </div>
    </div>
</body>
</html>