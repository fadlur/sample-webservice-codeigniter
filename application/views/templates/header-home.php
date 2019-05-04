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
    	<script src="<?php echo base_url('/assets/js/jquery-1.12.3.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/bootstrap.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/jquery-ui.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/jquery.number.min.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/date.js') ?>"></script>
    	<script src="<?php echo base_url('/assets/js/datepicker-id.js') ?>"></script>

        <!--[if lt IE 9]>
          <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body{
                margin-top:70px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar">
              <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo site_url()?>">Home</a></li>

              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#"></a></li>

              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    <div class="container-fluid">
        <div class="col-md-12 col-sm-12">
            <img src="<?php echo base_url('assets/img/header.png')?>" alt="header" width="100%"/>
        </div>
    </div>
