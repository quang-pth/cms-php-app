<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <!-- <li><a href="">Users Online: <?php echo users_online() ?></a></li> -->
                <li><a href="">Users Online: <span class="user-online"></span> </a></li>
                <li><a href="../index.php">HOME SITE</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <?php 
                            $query = "SELECT * FROM messages WHERE message_status = 0";
                            $select_all_messages = mysqli_query($connection, $query);
                            confirmQuery($select_all_messages);

                            while ($row = mysqli_fetch_assoc($select_all_messages)) {
                                $message_author = $row['message_author_email'];
                                $created_at = $row['created_at'];
                                $message_content = substr($row['message_content'], 0, 40);
                             ?>
                                <li class="message-preview">
                                <a href="#">
                                    <div class="media">
                                        <span class="pull-left">
                                            <img class="media-object" src="http://placehold.it/50x50" alt="">
                                        </span>
                                        <div class="media-body">
                                            <h5 class="media-heading">
                                                <strong><?php echo $message_author ?></strong>
                                            </h5>
                                            <p class="small text-muted"><i class="fa fa-clock-o"></i><?php echo $created_at ?></p>
                                            <p><?php echo $message_content ?>...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                             <?php 
                            }
                        ?>
                        <!-- <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li> -->
                        <li class="message-footer">
                            <a href="messages.php?source=view_all_messages">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <!-- View All News Unapproved Comments -->
                <?php 
                    $query = "SELECT * FROM comments WHERE comment_status = 'unapproved' ORDER BY comment_id DESC";
                    $select_unapproved_comments = mysqli_query($connection, $query);
                    confirmQuery($select_unapproved_comments);
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <?php 
                            while ($row = mysqli_fetch_assoc($select_unapproved_comments)) {
                                echo "<li>";
                                echo "<a href='#'>Unapproved Comments From: <span class='label label-primary'>{$row['comment_author']}</span></a>";
                                echo "</li>";   
                            }
                        ?>
                        <!-- <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li> -->
                        <li class="divider"></li>
                        <li>
                            <a href="comments.php">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                    <?php echo !empty($_SESSION['username']) ? $_SESSION['username'] : '' ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="messages.php?source=view_all_messages"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="./posts.php">View All Posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post">Add New Post</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories </a>
                    </li>
                    <li class="">
                        <a href="comments.php"><i class="fa fa-fw fa-file"></i>Comments</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_user">Add User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-file"></i> Profile</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>