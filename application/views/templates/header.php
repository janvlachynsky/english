<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta name="author" content="Jan Vlachynský">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.6/css/uikit.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>styles/style.css" >
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css" integrity="sha256-kafcFKMcjkeyTfjBox93yP5PkCQNvf4GzAlovJyTKCs=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js" integrity="sha256-ns3awRQUDUkb4hl21sd+GTFVidJLerhtrBrFMDk+Yvo=" crossorigin="anonymous"></script>


     <!-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css"> -->
    <!-- UIkit JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.6/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.6/js/uikit-icons.min.js"></script>
    
    
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>


    <title>Vocab testing</title>
</head>
<body >
	<nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left" style="margin: 0 auto;">

            <ul class="uk-navbar-nav uk-width-xxlarge" style="margin: 0 auto;" >
                <li class="uk-active"><a href="<?php echo site_url('home');?>">Home</a></li>
                <li>
                    <a href="<?php echo site_url('about');?>">About</a>

                </li>
                <li class=""><a href="<?php echo site_url('vocabs_start');?>">Vocab testing</a></li>
                
                <li><a href="">Vocabs</a>
                    <div class="uk-navbar-dropdown">
                        <ul class="uk-nav uk-navbar-dropdown-nav">
                            <li><a href="<?php echo site_url('vocabsall');?>">Vocabs view</a></li>
                            <li><a href="<?php echo site_url('vocabs_add');?>">Vocabs add</a></li>
                            <li><a href="#">Vocabs edit</a></li>
                        </ul>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
    <br>
    <div class="uk-width-xxlarge " style="margin:0 auto;">
       <h1><?php echo $title;?></h1>
