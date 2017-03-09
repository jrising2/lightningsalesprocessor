<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <header>
            <!-- Header Bar Start -->
            <div id="topHeaderRow">
                <nav class="navbar navbar-inverse " role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <p class="navbar-text">Welcome to <strong>Book Store</strong></p>
                    </div>

                    <div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Header Bar End -->


            <div class="row">
                <div class="col-md-4">
                    <h1>Book Store</h1>
                </div>
                <div class="navbar-collapse pull-right">
                    <form class="form-inline" role="search">
                        <div class="input-group">
                            <label class="sr-only" for="search">Search</label>
                            <input type="text" class="form-control" placeholder="Search" name="search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Navigation Start -->
            <div id="mainNavigationRow">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Books</a></li>
                            <li><a href="#">Customer Service</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Main Navigation End -->

        </header>

        <!-- Main Body Start, uses similar implementation to checkout and transaction history -->


        <!-- Main Body for the homepage -->
        <div id="homebody" class="tab-pane fade in active">
            <h2>Home</h2>
            <hr>
            <div class="panel-body">
                <div class="row">
                    <em><h3>Recently Added</h3></em>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title</p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title</p>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <em><h3>On Sale</h3></em>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title <span class="text-danger">10% Off</span></p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title <span class="text-danger">10% Off</span></p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title <span class="text-danger">10% Off</span></p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#"><img clas="image-responsive" src="http://placehold.it/200x200">
                            <p>Title <span class="text-danger">10% Off</span></p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Body End -->

            <!-- Footer Start -->
            <hr>
            <footer>
                <div class="row">
                    <div class="col-md-3">
                        <h4><span class="glyphicon glyphicon-info-sign"></span> About Us</h4>
                        <ul class="nav nav-stacked">
                            <li><a href="#">About Book Store</a></li>
                            <li><a href="#">Investor Relations</a></li>
                            <li><a href="#">Careers at Book Store</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4><span class="glyphicon glyphicon-earphone"></span> Customer Service</h4>
                        <ul class="nav nav-stacked">
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">In-Store Pickup</a></li>
                            <li><a href="#">Shipping</a></li>
                            <li><a href="#">Terms and Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4><span class="glyphicon glyphicon-link"></span> Links</h4>
                        <ul class="nav nav-stacked">
                            <li><a href="#">Kent State University</a></li>
                            <li><a href="#">Barnes And Noble</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4><span class="glyphicon glyphicon-envelope"></span> Contact us</h4>
                        <form role="form">
                            <div class="form-group tight-form-group">
                                <label class="sr-only" for="name">Name</label>
                                <input type="text" class="form-control" name="email" placeholder="Enter name ...">
                            </div>
                            <div class="form-group tight-form-group">
                                <label class="sr-only" for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email ...">
                            </div>
                            <div class="form-group tight-form-group">
                                <label class="sr-only" for="email">Email</label>
                                <textarea class="form-control" rows="3" placeholder="Enter message ..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </footer>
            <!-- Footer End -->

            <!-- Bootstrap core JavaScript
        ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </div>
</body>

</html>