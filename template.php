

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Local Home Storage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      .col-lg-4{
        -moz-box-shadow: 1px 6px 12px -6px #888; /* Для Firefox */
        -webkit-box-shadow: 1px 6px 12px -6px #888; /* Для Safari и Chrome */
        box-shadow: 1px 6px 12px -6px #888; /* Параметры тени */
        border-radius: 8px 8px 8px 8px;
        margin:0px 0px 20px 20px;
        max-width:151px;
        float:left;
      }
      .title{
        margin:10px 0px 10px 5px;
        float:left;
        color:gray;
      }
      .col-lg-4 .img-rounded{
        border-radius: 8px 8px 0px 0px; 
      }
      .col-lg-4 .btn-group{
        float:right;
        margin:10px 5px 10px 0px;
      }
      .col-lg-4 img{
        height:125px;
        width:370px;
        opacity:0.8;
      }
      
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
            <span class="glyphicon glyphicon-bar"></span>
            <span class="glyphicon glyphicon-bar"></span>
            <span class="glyphicon glyphicon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">LocalBox</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <!-- MAIN CONTAINER -->
    <div class="container">

      <!-- Example row of columns -->
      <div class="row">

        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/new folder.png">
          <h4 class="title">new folder</h4>
        </div>

        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/image.png">
          <h5 class="title">screen.jpg</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/image.png">
          <h5 class="title">SW1.jpg</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>


        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/image.png">
          <h5 class="title">SW2.jpg</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>


        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/image.png">
          <h5 class="title">SW3.jpg</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>



        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/image.png">
          <h5 class="title">SW4.jpg</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>



        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/archive.png">
          <h5 class="title">images.rar</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Unzip</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>



        <div class="col-lg-4">
          <img class="img-rounded" src="/assets/icons/video.png">
          <h5 class="title">Star Wars....</h5>
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle btn-small" data-toggle="dropdown" href="#">
              Action
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- dropdown menu links -->
              <li><a tabindex="-1" href="#">Open</a></li>
              <li><a tabindex="-1" href="#">Rename</a></li>
              <li><a tabindex="-1" href="#">Download</a></li>
              <li class="divider"></li>
              <li><a tabindex="-1" href="#">Delete</a></li>
            </ul>
          </div>
        </div>
      </div>
<!-- FOOTER -->


    </div> <!-- /container -->
    <hr>

    <footer>
      <p>&copy; Company 2013</p>
    </footer>
    <!-- ban bootstrap styles -->

    <style>
    .col-lg-4{
      float: left;
      margin-left: 20px;
    }
    </style>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap.js"></script>

  </body>
</html>