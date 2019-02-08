<?php
class User {
    private $user;
    private $conn;

    // User constructor
    public function __construct($conn, $user){
        $this->conn = $conn;
        $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }
    // Method to get username
    public function getUsername(){
        return $this->user['username'];
    }
    // Method to update num of post
    public function getNumPosts() {
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT num_posts FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_posts'];
    }
    // Method to get user's first and last name
    public function getFirstAndLastName() {
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . " " . $row['last_name'];
    }
    // Method to check if user account is closed
    public function isClosed() {
        $username = $this->user['username'];
        $query = mysqli_query($this->conn, "SELECT user_closed FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        
        ($row['user_closed'] == 'yes') ? true : false ;
    }
}
?>