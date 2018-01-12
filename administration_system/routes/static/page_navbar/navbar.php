    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">

            <!--HTML5 Stylizing of the button (using icon bars) to be used when collapsed-->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Brand title -->
            <a class="navbar-brand" href="../index.php">N.E.R.D Railway Route Finder</a>
        </div>

        <!--Navigation bar replaced by button when collapsed-->
        <div id="navbar" class="navbar-collapse collapse">

            <!--Default (left) side of the navigation bar-->
            <ul class="nav navbar-nav">
                <li><a href="../help.php"><span class="glyphicon glyphicon-question-sign"></span>Help and Support</a></li>
            </ul>

            <!--Right hand side of the navigation bar-->
            <ul class="nav navbar-nav navbar-right">
				<?if(!empty($_SESSION['logged_in']) and $_SESSION['logged_in'])  // logged in
				{ ?>
					<li class="active"><a href="../administration_page/profile.php"><span class="glyphicon glyphicon-log-in"></span>    My Account</a></li>
					<li class="active"><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span>    Sign Out</a></li>
				<?}
				else  // visitor
				{?>
					<li class="active"><a href="../indexLogin.php"><span class="glyphicon glyphicon-log-in"></span>    Login</a></li>
				<?}?>
                
            </ul>
        </div>
    </div>
    </nav>
