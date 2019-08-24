<header class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="index.php" class="navbar-brand">WebbiSkools</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></button>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){ ?>
                <li><a href="logout.php">Logout</a></li>
                <?php }else{ ?>
                <li><a href="login.php">Login</a></li>
                <?php } ?>                   
                <li><a href="index.php">Quizzes</a></li>
            </ul>
        </div>
    </div>
</header>