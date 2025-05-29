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
?>
