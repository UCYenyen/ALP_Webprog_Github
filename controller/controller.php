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

// fungsi buat delete akun user
function deleteUser($id){
    if($id > 0){
        $conn = my_ConnectDB();
        $sql_query = "DELETE FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        my_closeDB($conn);
    }
    return $result;
}

function getUserById($id){
    $data = array();
    if($id > 0){
        $conn = my_ConnectDB();
        $sql_query = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $sql_query) or die("Error: " . mysqli_error($conn));
        if($result-> num_rows > 0){
            while($row = $result->fetch_assoc()){
                // Simpan data dari db ke dalam array
                $data['id'] = $row['id'];
                $data['username'] = $row['username'];
                $data['password'] = $row['password'];
            }
        }
        my_closeDB($conn);
        return $data;
    }
}
?>