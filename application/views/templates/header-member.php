<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php if(isset($title)){echo $title." | Iot Challenge Smart Farm"; }else{ echo "Iot Challenge Smart Farm";} ?></title>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/bootstrap.min.css') ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery-ui.theme.min.css') ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery-ui.structure.min.css') ?>">
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery-ui.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/prism.css') ?>">
    	<script src="<?php echo base_url('/assets/js/jquery-1.12.3.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/jquery-ui.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/jquery.number.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/date.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/datepicker-id.js') ?>"></script>
        <script src="<?php echo base_url('/assets/js/prism.js') ?>"></script>

        <!--[if lt IE 9]>
          <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body{
                margin-top: 70px;
            }
            @media print{
        		.print{
        			display: none;
        		}
        	}
        </style>
    </head>
    <body>
        <nav class="navbar navbar navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('member'); ?>"><span class="glyphicon glyphicon-home"></span> Dashboard</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class="glyphicon glyphicon-user"></span>  Welcome, <?php echo $itemuser->first_name;?><b class='caret'></b></a>
                    		<ul class='dropdown-menu'>
                                <li><a href="<?php echo site_url('logout')?>">Logout</a></li>
                            </ul>
                        </li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
