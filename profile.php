<!doctype html>
<html lang="en">

<head>
    <?php include "./partials/head.php"?>
</head>

<body>
    <!-- HEADER / NAVBAR -->
    <header>
        <?php include "./partials/header.php"?>
    </header>
    <!-- CONTENT -->
    <div class="container">
        <div class="row">
            <div class="col-4">
                <!-- USER PROFILE CARD -->
                <div class="card">
                    <!-- Profile pic AND about user -->
                    <img src="<?php echo $user['profile_pic']?>" class="card-img-top" alt="<?php echo $user['first_name'] . '\' picture' ?>">
                    <div class="card-body">
                        <h5 class="card-title">About
                            <?php echo $user['first_name'] ?>
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
            
            <div class="col-8">
                <!-- POST CARD -->
                
            </div>
        </div>
        <div>

            <footer>

            </footer>
</body>

</html>