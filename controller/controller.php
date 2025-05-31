<?php

function my_ConnectDB(){
    $host = "localhost";
    $username = "root"; 
    $password = ""; 
    $database = "bukuku"; 

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function my_closeDB($conn){
    mysqli_close($conn);
}

function loginUser($username , $password){
    $conn = my_ConnectDB();
    $data = array();
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
    $sql_query = "SELECT id FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql_query);
    if (mysqli_num_rows($result) > 0) {
        my_closeDB($conn);
        return false; 
    }
    
    $sql_query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $sql_query);
    my_closeDB($conn);
    return $result; 
}

function logoutUser() {
    session_destroy();
    header("Location: index.php");
    exit();
}

function getPersonalBooks($user_id){
    $conn = my_ConnectDB();
    $allData = array();
    $ownedBooks = array();

    if($conn != null){
        $sql_query = "SELECT * FROM personal_collections WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data['id'] = $row['id'];
                $data['book_id'] = $row['book_id'];
                $data['user_id'] = $row['user_id'];
                $data['is_favorite'] = $row['is_favorite'];

                $ownedBooks = getBookById($row['book_id']);
                $data['cover_image'] = $ownedBooks['cover_image'];
                array_push($allData, $data);
            }
        }
    }
    return $allData;
}

function getAllBook(){
    $allData = array();
    $conn = my_ConnectDB();
    if($conn != null){
        $sql_query = "SELECT * FROM books";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['author'] = $row['author'];
                $data['description'] = $row['description'];
                $data['cover_image'] = $row['cover_image'];
                array_push($allData, $data);
            }
        }
    }

    return $allData;
}

function getBookById($book_id){
    $conn = my_ConnectDB();
    $data = array();
    if($conn != null){
        $sql_query = "SELECT * FROM books WHERE id = '$book_id'";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['genre'] = $row['genre'];
                $data['year_published'] = $row['year_published'];
                $data['owner_id'] = $row['owner_id'];
                $data['author'] = $row['author'];
                $data['description'] = $row['description'];
                $data['cover_image'] = $row['cover_image'];
            }
        }
    }
    my_closeDB($conn);
    return $data;
}

function openBookPagePersonal($book_id) {
    $_SESSION['book_id'] = $book_id;
    header("Location: book-page-personal.php");
    exit();
}

function openBookPage($book_id) {
    $_SESSION['book_id'] = $book_id;
    header("Location: book-page.php");
    exit();
}

// fungsi buat read user data
function readUserData(){
    $allData = array();
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
                array_push( $allData, $data);
            }
        }
    }
    return $allData;
}


function checkIfBookAlreadyOwned($book_id, $user_id) {
    $conn = my_ConnectDB();
    $sql_query = "SELECT * FROM personal_collections WHERE book_id = '$book_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
    $exists = $result->num_rows > 0;
    my_closeDB($conn);
    return $exists;
}




function getTrendingBooks(){
    $allData = array();
    $conn = my_ConnectDB();
    if($conn != null){
        $sql_query = "SELECT * FROM books ORDER BY popularity_counter DESC LIMIT 8";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data['id'] = $row['id'];
                $data['title'] = $row['title'];
                $data['author'] = $row['author'];
                $data['description'] = $row['description'];
                $data['cover_image'] = $row['cover_image'];
                array_push($allData, $data);
            }
        }
    }

    return $allData;
}
function searchBook($title){
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
?>
