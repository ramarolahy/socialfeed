<!doctype html>
<html lang="en">

<head>
    <?php include "./partials/head.php"?>
</head>
<?php
require_once "./partials/classes/User.php";
require_once "./partials/classes/Post.php";

// Create user instance
$user_obj = new User($conn, $userLoggedIn);
// Get user fname and lname
$userInfo = $user_obj->getFirstAndLastName();

// Submit post to db when user clics on post
if (isset($_POST['post_btn'])) {
    $newPost = new Post($conn, $userLoggedIn);
    $newPost->submitPost($_POST['post_text'], 'none');
    $_POST['post_text'] = "";
}

// Create post instance to populate page (cannot use dp post due to scoping)
$post = new Post($conn, $userLoggedIn);
?>

<body>
    <!-- HEADER / NAVBAR -->
    <header>
        <?php include "./partials/header.php"?>
    </header>
    <!-- CONTENT -->
    <div class="container">
        <div class="row">
            <div class="col-3">
                <!-- USER PROFILE CARD -->
                <div class="card">
                    <!-- Profile pic AND about user -->
                    <a href="<?php echo $userLoggedIn ?>">
                        <img src="<?php echo $user['profile_pic'] ?>" class="card-img-top" alt="<?php echo $user['first_name'] . '\' picture' ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $userInfo ?>
                        </h5>
                        <p class="card-text">A little intro about the
                            <?php echo $user['first_name'] ?>
                        </p>
                        <h5 class="card-title">Posts</h5>
                        <p class="card-text">You have
                            <?php echo $user['num_posts'] ?> posts.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Popular topics
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">Dapibus ac facilisis in</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                    </ul>
                </div>
                <!-- END -- USER PROFILE CARD -->
            </div>
            <div class="col-6">
                <!-- POST CARD -->
                <div class="card">
                    <div class="card-header">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Keep it secret!
                            </label>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="form-group">
                                <form class="post_form" action="index.php" method="POST">
                                    <textarea class="form-control" id="post_text" name="post_text" rows="2" placeholder="Wanna say something?"></textarea>
                                    <button type="submit" name="post_btn" id="post_btn" class="btn btn-dark float-right">Post
                                        it!</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- ====================================================== -->
                <!-- POSTS LIST -->
                <div class="card">
                    <ul class="list-group list-group-flush posts__list__wrapper">
                        <!-- POPULATE POSTS HERE -->

                    </ul>
                    <div id="spinner" class="card-body">
                        <div class="hidden d-flex justify-content-center" role="status">
                            <img src="./public/img/icons/spinner.gif">
                        </div>
                    </div>
                </div>
                <script>
                    const userLoggedIn = '<?php echo $userLoggedIn; ?>';

                    $(document).ready(function () {
                        $('#spinner').show();
    
                        // Original ajax request for loading first post
                        $.ajax({
                            url: "./utils/handlers/ajax_load_posts.php",
                            type: "POST",
                            data: "page=1&userLoggedIn=" + userLoggedIn,
                            cache: false,

                            success: function (data) {
                                
                                $('#spinner').hide();
                                $('.posts__list__wrapper').html(data);
                            }
                        });

                        $(window).scroll(function () {
                                const height = $('.posts__list__wrapper').height(); // Div containing posts
                                const scroll_Top = $(this).scrollTop();
                                const page = $('.posts__list__wrapper').find('.nextPage').val();
                                const noMorePosts = $('.posts__list__wrapper').find('.noMorePosts').val();

                                // If user scrolls to the bottom of the page
                                if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight) && noMorePosts == 'false') {
                                    $('#spinner').show();
                                    
                                    const ajaxReq = $.ajax({
                                        url: "./utils/handlers/ajax_load_posts.php",
                                        type: "POST",
                                        data: `page=${page}&userLoggedIn=` + userLoggedIn,
                                        cache: false,

                                        success: function (response) {
                                            $('.posts__list__wrapper').find('.nextPage').remove(); // Removes current .nextpage
                                            $('.posts__list__wrapper').find('.noMorePosts').remove(); // Removes current .nextpage

                                            $('#spinner').hide();
                                            $('.posts__list__wrapper').append(response);
                                        }
                                    }); // End if
                                    return false;
                                };
                        });
                    });
                </script>

            </div>

            <!-- ADDS AND RANDOM COMMUNICATION -->
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="./public/img/flowers.jpeg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Local event</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="btn btn-primary">Interested</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Local Add</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>
            </div>
        </div>
        <html>

        <footer>

        </footer>
</body>

</html>