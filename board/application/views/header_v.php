<?php $rootURL = "/board/index.php/board"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <title>Dani</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link type="text/css" rel='stylesheet' href="/board/include/css/bootstrap.css" />
        <link rel="stylesheet" href="/board/include/css/bootstrap.min.css">
        <style>
            body {
                background: black;
            }
            .container, .container-fluid {
            background: #eaeaed;
            }
            .fixed, .fluid {
            background: #2db34a;
            height: 100px;
            line-height: 100px;
            text-align: center;
            color: white;
            font-weight: 700;
            }
        </style>
  
    </head>

    <body>
        <div class="container" id="main">
            <header id="header" data-role="header" data-position="fixed">
                <blockquote style="text-align:center;">
                <p><h1>Dani Board</h1></p>
                <p>
<?php
    if ( @$this->session->userdata('logged_in') == TRUE) {
?>
<?php echo $this->session->userdata('user_id');?> 님 환영합니다. <a href="/board/index.php/auth/logout" class="btn">로그아웃</a>
<?php
    } else {
?>
<a href="/board/index.php/auth/login" class="btn btn-primary"> 로그인 </a>
<?php
    }
?>
                </p>


            </blockquote>
            </header>
            <nav id="gnb" style="text-align:left; font-size:28px;">
            <a rel="external" href="<?php echo $rootURL.'/lists/'.$this->uri->segment(3); ?>">home</a>
            </nav>
