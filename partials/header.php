
<!-- INSERT HEADER/NAV HERE -->
<nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
<div class="container" id="nav-container">
    <a class="navbar-brand" href="index.php"><?php echo 'Hi ' . $user['first_name'] . '!' ?></a>
    
    <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="flex-row-reverse collapse navbar-collapse" id="navbarNav">
    
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Messages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Notifications</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Friends</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./utils/handlers/_logout.php">Logout</a>
        </li>
        </ul>
    </div>
    
</div>   

</nav>
