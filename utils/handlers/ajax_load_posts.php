<?php
    require "../_config.php";
    require "../../partials/classes/User.php";
    require "../../partials/classes/Post.php";

    $limit = 5; // Num of posts to loaded per "page"

    $posts = new Post($conn, $_REQUEST['userLoggedIn']);
    $posts->loadPosts($_REQUEST, $limit);
?>