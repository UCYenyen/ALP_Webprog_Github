<?php
//fungsi buat konek ke database
function my_ConnectDB(){

    $host = "localhost";
    $username = "root"; // Default XAMPP username
    $password = ""; // Default XAMPP password
    $database = "alp_webprog"; // Replace with your actual database name

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
// fungsi buat close koneksi ke database
function my_closeDB($conn){

    mysqli_close($conn);
}
// fungsi buat read user data
function readUserData(){
    $allDaTA = array();
    $conn = my_ConnectDB();
    if($conn != null){
        $sql_query = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if($result-> num_rows > 0){
             while($row = $result->fetch_assoc()){
                // Simpan data dari db ke dalam array
                $data['id'] = $row['id'];
                $data['username'] = $row['username'];
                $data['password'] = $row['password'];
                array_push( $allDaTA, $data);
            }
        }
    }
    return $allDaTA;
}

function getBook($title){
    $data = array();
    $conn = my_ConnectDB();
    $sql_query = "SELECT * FROM books WHERE title = '$title'";
    $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['id'] = $row['id'];
            $data['title'] = $row['title'];
            $data['author'] = $row['author'];
            $data['description'] = $row['description'];
        }
    }
    my_closeDB($conn);
    return $data;

}
function loginUser($username , $password){
    $data = array();
    $conn = my_ConnectDB();
    $sql_query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['id'] = $row['id'];
            $data['username'] = $row['username'];
            $data['password'] = $row['password'];
        }
    }
    my_closeDB($conn);
    return $data;
}
function logoutUser() {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Unset all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    return true;
}
function registerUser($username, $password){
    $conn = my_ConnectDB();

    // Check if username already exists
    // Cek username sudah ada atau belum
    $sql_query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql_query);
    if (mysqli_num_rows($result) > 0) {
        my_closeDB($conn);
        return false; // Username sudah ada
    }
    // Jika username belum ada, lanjutkan registrasi
    $sql_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $sql_query);
    my_closeDB($conn);
    return $result;
}

function createBook($title, $author, $genre, $year_published, $cover_image, $description, $link, $popularity_counter, $owner_id){
    $conn = my_ConnectDB();
    // Ensure owner_id exists in users table before inserting
    $owner_id = intval($owner_id);
    $check_user_query = "SELECT id FROM users WHERE id = $owner_id";
    $check_user_result = mysqli_query($conn, $check_user_query);
    if (mysqli_num_rows($check_user_result) == 0) {
        my_closeDB($conn);
        return false; // owner_id does not exist
    }

    $sql_query = "INSERT INTO books (title, author, genre, year_published, cover_image, description, link, popularity_counter, owner_id) VALUES ('$title', '$author', '$genre', '$year_published', '$cover_image', '$description', '$link', '$popularity_counter', '$owner_id')";
    $result = mysqli_query($conn, $sql_query);
    my_closeDB($conn);
    return $result;
}
function showAllBooks(){
    $allBooks = array();
    $conn = my_ConnectDB();
    if($conn != null){
        $sql_query = "SELECT * FROM Books";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if($result-> num_rows > 0){
             while($row = $result->fetch_assoc()){
                // Simpan data dari db ke dalam array
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['author'] = $row['author'];
                $data['genre'] = $row['genre'];
                $data['year_published'] = $row['year_published'];
                $data['description'] = $row['description'];
                $data['link'] = $row['link'];
                $data['cover_image'] = $row['cover_image'];
                array_push( $allBooks, $data);
            }
        }
    }
    return $allBooks;
}
function showTrendingBooks(){
    $allBooks = array();
    $conn = my_ConnectDB();
    if($conn != null){
        $sql_query = "SELECT * FROM Books ORDER BY popularity_counter DESC"; // Ambil 8 buku terpopuler
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if($result-> num_rows > 0){
             while($row = $result->fetch_assoc()){
                // Simpan data dari db ke dalam array
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['author'] = $row['author'];
                $data['genre'] = $row['genre'];
                $data['year_published'] = $row['year_published'];
                $data['description'] = $row['description'];
                $data['link'] = $row['link'];
                $data['cover_image'] = $row['cover_image'];
                array_push( $allBooks, $data);
            }
        }
    }
    return $allBooks;
}

function getBookById($id) {
    $data = array();
    $conn = my_ConnectDB();
    $id = intval($id); // Ensure integer value for security
    $sql_query = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    }
    my_closeDB($conn);
    return $data;
}

// Add this function to your controller.php file
function addToPersonalCollection($book_id, $user_id) {
    $conn = my_ConnectDB();
    if($conn != null){
        // Check if the book is already in the user's collection
        $check_sql = "SELECT * FROM personal_collections WHERE book_id = $book_id AND user_id = $user_id";
        $check_result = mysqli_query($conn, $check_sql);
        
        if(mysqli_num_rows($check_result) > 0) {
            // Book already in collection
            my_closeDB($conn);
            return false;
        }
        
        // Insert the book into the personal collection
        $sql = "INSERT INTO personal_collections (book_id, user_id, is_favorite) VALUES ($book_id, $user_id, 0)";
        $result = mysqli_query($conn, $sql);
        my_closeDB($conn);
        return $result;
    }
    return false;
}

// Add this to handle form submissions from your views
if(isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'add_to_collection':
            if(isset($_POST['book_id'], $_POST['user_id'])) {
                $book_id = intval($_POST['book_id']);
                $user_id = intval($_POST['user_id']);
                $result = addToPersonalCollection($book_id, $user_id);
                header('Location: ../view/personal-collection.php');
                exit;
            }
            break;
    }
}

// Get books from a user's personal collection
function getUserPersonalCollection($user_id) {
    $books = array();
    $conn = my_ConnectDB();
    if($conn != null){
        // Join personal_collections with books to get book details
        $sql_query = "SELECT b.* FROM books b 
                      INNER JOIN personal_collections pc ON b.id = pc.book_id 
                      WHERE pc.user_id = $user_id";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['author'] = $row['author'];
                $data['genre'] = $row['genre'];
                $data['year_published'] = $row['year_published'];
                $data['description'] = $row['description'];
                $data['link'] = $row['link'];
                $data['cover_image'] = $row['cover_image'];
                $data['owner_id'] = $row['owner_id'];
                array_push($books, $data);
            }
        }
    }
    my_closeDB($conn);
    return $books;
}

// Get favorite books from a user's personal collection
function getUserFavoriteBooks($user_id) {
    $books = array();
    $conn = my_ConnectDB();
    if($conn != null){
        // Join personal_collections with books to get book details, filter by is_favorite = 1
        $sql_query = "SELECT b.* FROM books b 
                      INNER JOIN personal_collections pc ON b.id = pc.book_id 
                      WHERE pc.user_id = $user_id AND pc.is_favorite = 1";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['author'] = $row['author'];
                $data['genre'] = $row['genre'];
                $data['year_published'] = $row['year_published'];
                $data['description'] = $row['description'];
                $data['link'] = $row['link'];
                $data['cover_image'] = $row['cover_image'];
                $data['owner_id'] = $row['owner_id'];
                array_push($books, $data);
            }
        }
    }
    my_closeDB($conn);
    return $books;
}
function updateUserProfile($user_id, $username, $new_password, $current_password, $profile_image_file) {
    $conn = my_ConnectDB();
    if($conn != null) {
        // First verify the current password
        // Check current password using plain text (not recommended for production)
        $sql_check = "SELECT * FROM users WHERE id = $user_id AND password = '$current_password'";
        $result = mysqli_query($conn, $sql_check);

        if(mysqli_fetch_assoc($result)) {
            // Password verified, start building update
            $sql_update = "UPDATE users SET username = ?";
            $params = [$username];
            $types = "s";

            // If new password is provided, hash it and include in update
            if(!empty($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql_update .= ", password = ?";
                $params[] = $hashed_password;
                $types .= "s";
            }

            // Process profile image if provided
            $profile_image_path = '';
            if($profile_image_file && isset($_FILES[$profile_image_file]) && $_FILES[$profile_image_file]['error'] == 0) {
                $target_dir = "../view/uploads/profiles/";
                if(!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES[$profile_image_file]["name"], PATHINFO_EXTENSION);
                $new_filename = "profile_{$user_id}_" . time() . ".{$file_extension}";
                $target_file = "{$target_dir}{$new_filename}";

                if(move_uploaded_file($_FILES[$profile_image_file]["tmp_name"], $target_file)) {
                    $profile_image_path = "uploads/profiles/{$new_filename}";
                    $sql_update .= ", profile_image = ?";
                    $params[] = $profile_image_path;
                    $types .= "s";
                }
            }

            $sql_update .= " WHERE id = ?";
            $params[] = $user_id;
            $types .= "i";

            $stmt = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            $update_result = mysqli_stmt_execute($stmt);

            if($update_result) {
                // Update session data
                $_SESSION['username'] = $username;
                if(!empty($profile_image_path)) {
                    $_SESSION['profile_image'] = $profile_image_path;
                }
                my_closeDB($conn);
                return true;
            }
        } else {
            my_closeDB($conn);
            return "Current password is incorrect.";
        }
    }
    my_closeDB($conn);
    return "Failed to update profile.";
}
?>
