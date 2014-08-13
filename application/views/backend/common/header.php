<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">


        <title>Social Campaign</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url() ?>resources/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>
            body {
                padding-top: 50px;
            }
        </style>

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="<?php echo base_url() ?>resources/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="<?php echo base_url() ?>resources/assets/js/ie-emulation-modes-warning.js"></script>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="<?php echo base_url() ?>resources/assets/js/ie10-viewport-bug-workaround.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Social Campaign</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">

                        <li><a href="<?php echo base_url() ?>admin/campaigns">Campaigns</a></li>
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo base_url() ?>admin/reports/facebook">Facebook</a></li>
								<li><a href="<?php echo base_url() ?>admin/reports/twitter">Twitter</a></li>
								<li><a href="<?php echo base_url() ?>admin/reports/instagram">Instagram</a></li>
							</ul>
						</li>
						
						<?php if ($this->basic_auth->is_logged()): ?>
							<li><a href="<?php echo base_url() ?>admin/auth/logout">Logout</a></li>
						<?php else: ?>
							<li><a href="<?php echo base_url() ?>admin/auth/login">Login</a></li>
						<?php endif; ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">