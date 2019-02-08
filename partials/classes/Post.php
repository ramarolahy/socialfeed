<?php
class Post {
    private $user_obj;
    private $conn;

    // User constructor
    public function __construct($conn, $user){
        $this->conn = $conn;
        // Create an instance of the user within the Post constructor
        $this->user_obj = new User($conn, $user);
    }
    // Method to get user's first and last name
    public function submitPost($body, $posted_to) {
        $body = strip_tags($body); // removes html tags
        $body = mysqli_real_escape_string($this->conn, $body);
        $check_empty = preg_replace('/\s+/', '', $body); // Replaces spaces with ''

        // $check_empty will help us prevent users from posting empty
        if($check_empty != "") {
            //Get current date and time
            $post_date = date("Y-m-d H:i:s");  // since m is month, i is minutes
            //Get username
            $posted_by = $this->user_obj->getUsername();
            // If posting on own profile, set posted_to to none
            if($posted_to == $posted_by) $posted_to = "none";
            // Insert post into DB
            $query = mysqli_query($this->conn, "INSERT INTO posts (id, body, posted_by, posted_to, post_date, user_closed, deleted, likes) VALUES(NULL, '$body', '$posted_by', '$posted_to', '$post_date', 'no', 'no', '0')");
            $returned_id = mysqli_insert_id($this->conn);  // returns the post id
            // Insert notification

            // Update post count for user
            $num_posts = $this->user_obj->getNumPosts();
            $num_posts++;
            $update_query = mysqli_query($this->conn, "UPDATE users SET num_posts='$num_posts' WHERE username='$posted_by'");
        }
    }

    public function loadPosts($data, $limit) {
        $page = $data['page'];
        $userLoggedIn = $this->user_obj->getUsername();

        // If the page that is being loaded is page 1
        if($page == 1)
            // Start at post id=0
            $start = 0;
        else
            $start = ($page - 1) * $limit;

        $str = ""; // String to return
        $data_query = mysqli_query($this->conn, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

        if(mysqli_num_rows($data_query) > 0) {
            /*This loop will go over each row of data and check if: 
                1- account is closed with isClosed()
                2- the row was already read by comparing it to the start row
                    The rows will grouped 10 per page.
                3- IF those are false then the row data will be gathered
                    for printing.
            */
            $num_iterations = 0; //Number of results checked (not necessarily posted yet)
            $count = 1; // To keep track of how many results have been loaded

            while($row = mysqli_fetch_array($data_query)) {
                $id = $row['id'];
                $body = $row['body'];
                $posted_by = $row['posted_by'];
                $post_date_time = $row['post_date'];
    
                // Prepare posted_to string so it can be included even if not posted to a user
                if($row['posted_to'] == 'none') {
                    // if posting from friend's profile then include empty string
                    $posted_to = "";
                } else {
                    // else get posted_to fname and lname (make instance of User)
                    $posted_to_obj = new User($conn, $row['posted_to']);
                    $posted_to_name = $posted_to_obj->getFirstAndLastName();
                    // return a link to the posted_to profile page
                    $posted_to = "to <a href='" . $row['posted_to'] ."' >" . $posted_to_name . "</a>";
                }
    
                // Check if posted_by has a closed account
                $posted_by_obj = new User($this->conn, $posted_by);
                if($posted_by_obj->isClosed()) continue;

                // Increment $num_iterations and compare to start row.
                // Rows within each page should equal or greater than start row UP to 10 rows 
                if($num_iterations++ < $start) continue;
                // Stop once we reach 10 rows inside the current page
                if ($count > $limit)
                    break;
                else
                    $count++;
                
                // Get post information
                $poster_details_query = mysqli_query($this->conn, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$posted_by'");
                $poster_row = mysqli_fetch_array($poster_details_query);
                $poster_fname = $poster_row['first_name'];
                $poster_lname = $poster_row['last_name'];
                $poster_pic = $poster_row['profile_pic'];
    
                // Timestamp
                $current_date_time = date("Y-m-d H:i:s");
                $start_date = new DateTime($post_date_time); // Time of post
                $end_date = new DateTime($current_date_time); // Current time
                // diff() gives the difference btwn 2 dates see https://stackoverflow.com/questions/15688775/php-find-difference-between-two-datetimes 
                $interval = $start_date->diff($end_date); 
    
                if($interval->y >= 1) { // if over a year ago
                    if($interval == 1)
                        $time_message = $interval->y . " year ago"; // prints 1 year ago
                    else
                        $time_message = $interval->y . " years ago"; // prints 1+ years ago
                }
                // Determining time strings
                if($interval->y >= 1) { // if over a year ago
                    if($interval == 1)
                        $time_message = $interval->y . " year ago"; // prints 1 year ago
                    else
                        $time_message = $interval->y . " years ago"; // prints 1+ years ago
                }
                // If a month or more ago
                else if($interval->m >= 1) {
                    // Check days first
                    if($interval->d == 0) 
                        $days = " ago"; // 1 month and 0 day prints: 1 month ago
                    else if($interval->d == 1)
                        $days = $interval->d . " day ago";
                    else   
                        $days = $interval->d . " days ago";
                    // Append days to month
                    if($interval->m == 1) {
                        $time_message = $interval->m . " month". $days; // 1 month 2 days ago
                    }
                    else {
                        $time_message = $interval->m . " months". $days; // 2 months ago
                    }
                }
                // If posted within days
                else if($interval->d >= 1) {
                    if($interval->d == 1)
                        $time_message = $interval->d . " yesterday";
                    else   
                        $time_message = $interval->d . " days ago";
                }
                // If posted within hours
                else if($interval->h >= 1) {
                    if($interval->h == 1)
                        $time_message = $interval->h . " hour ago";
                    else   
                        $time_message = $interval->h . " hours ago";
                }
                // If posted within minutes
                else if($interval->i >= 1) {
                    if($interval->i == 1)
                        $time_message = $interval->i . " minute ago";
                    else   
                        $time_message = $interval->i . " minutes ago";
                }
                // If posted within seconds
                else {
                    if($interval->s < 30)
                        $time_message = " just now";
                    else   
                        $time_message = $interval->s . " seconds ago";
                }  
                // Get html and css here: https://www.bootdey.com/snippets/view/Social-post#html 
                // Use "" when using variables inside.
                $str .= "
                        <li class='list-group-item'>
                        <div class='post-heading clearfix'>
                            <div class='float-left image'>
                                <img src='$poster_pic' class='img-thumbnail avatar' alt='$poster_fname'>
                            </div>
                            <div class='float-left clearfix meta'>
                                <div class='title h5'>
                                    <a href='#'><b>$poster_fname $poster_lname</b></a>
                                    $posted_to
                                </div>
                                <h6 class='text-muted time'>$time_message</h6>
                            </div>
                        </div>
                        <div class='post-description'>
                            <p>$body</p>
                            <div class='float-right stats'>
                                <button href='#' class='btn btn-default stat-item'>
                                    <i class='fa fa-thumbs-up icon'></i>&nbsp;2
                                </button>
                                <button href='#' class='btn btn-default stat-item'>
                                    <i class='fa fa-share icon'></i>&nbsp;12
                                </button>
                            </div>
                        </div>
                        </li>
                ";
            }

            if($count > $limit) {
                // Hidden element used to hold page number
                $str .= "
                    <input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
                    <input type='hidden' class='noMorePosts' value='false'>        
                ";
            } else {
                $str .= "
                    <input type='hidden' class='noMorePosts' value='true'>
                    <p style='text-align:center;'>No more posts to show.</p>
                ";
            }
        }
        echo $str;
    }
}
?>