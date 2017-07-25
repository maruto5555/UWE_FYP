<!DOCTYPE html>
<html lang="en">
<head>
    <title>Travel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url('css/login.css'); ?>">
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<!--    boostrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

    <!--    kendoui-->
    <link href="<?php echo base_url('kendoUi/shared/styles/examples-offline.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('kendoUi/styles/kendo.common.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('kendoUi/styles/kendo.rtl.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('kendoUi/styles/kendo.default.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('kendoUi/styles/kendo.default.mobile.min.css');?>" rel="stylesheet">
    <script src="<?php echo base_url('kendoUi/js/jszip.min.js');?>"></script>
    <script src="<?php echo base_url('kendoUi/js/kendo.all.min.js');?>"></script>
    <script src="<?php echo base_url('kendoUi/shared/js/console.js');?>"></script>
<!--    jquery ui-->
<!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
<!--    <link rel="stylesheet" href="/resources/demos/style.css">-->
<!--    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
        .row.content {height: 900px}
        /* Add a gray background color and some padding to the footer */
        footer {
            background-color: #f2f2f2;
            padding: 25px;
        }
    </style>

</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('index.php/travelAttraction/selectCountry'); ?>">Travel</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav " id="myTabs">
                <li class="active"><a href="<?php echo base_url('index.php/travelAttraction/selectCountry'); ?>"><span class="glyphicon glyphicon-home"></span>Home</a>
                </li>
                <li><a href="<?php echo base_url('index.php/TravelShare'); ?>"><span
                                class="glyphicon glyphicon-book"></span>Travel Share</a></li>
                <li><a href="<?php echo base_url('index.php/Home/map_direction'); ?>"><span class="glyphicon glyphicon-map-marker"></span>Route
                        direction</a></li>
                <li><a href="<?php echo base_url('index.php/travelPlanning'); ?>"><span class="glyphicon glyphicon-list-alt"></span>Make a plan</a>
                </li>
                <li><a href="<?php echo base_url('index.php/Home'); ?>"><span class="glyphicon glyphicon-picture"></span>Sample VR picture</a>
                </li>
            </ul>
            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true) { ?>
                <ul class="nav navbar-nav navbar-right " id="myTabs">
                    <li class="dropdown" role="presentation">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><span
                                    class="glyphicon glyphicon-user"></span><?php echo $_SESSION['email']; ?> <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('index.php/Login/profile'); ?>"><span
                                            class="glyphicon glyphicon-folder-open"></span>Profile</a></li>
                            <li><a href="<?php echo base_url('index.php/TravelShare/MyShare'); ?>"><span
                                            class="glyphicon glyphicon-pencil"></span>My Travel Share</a></li>
                            <li>
                                <a href="<?php echo site_url('travelPlanning/getTravelPlan/' . $_SESSION['uid'] . '/'); ?>"><span
                                            class="glyphicon glyphicon-calendar"></span>My Plan</a></li>
                            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == true && $_SESSION['is_admin'] == 1) { ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="<?php echo base_url('index.php/admin/countryList/'); ?>" target="_blank"><span
                                                class="glyphicon glyphicon-wrench">Admin panel</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url('index.php/Login/logout'); ?>"><span
                                    class="glyphicon glyphicon-log-out"></span>Logout</a></li>
                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav navbar-right " id="myTabs">
                    <li><a href="<?php echo base_url('index.php/Login/loginForm') ?>"><span
                                    class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <li><a href="<?php echo base_url('index.php/Login/signUpForm') ?>"><span
                                    class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                </ul>
            <?php } ?>
        </div>

    </div>
</nav>

<div class="jumbotron">
    <div class="container text-center">
        <?php if (isset($headerText)) {
            echo $headerText;
        } ?>
    </div>
</div>
<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-12">
<?php $this->load->view($content_view); ?>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    &copy; <?php echo date("Y"); ?>
</footer>

</body>
</html>
