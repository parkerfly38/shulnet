<?php

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" lang="en" xml:lang="en">
<head>
    <title><?php echo COMPANY; ?> | <?php echo $employee['username']; ?> | ShulNET Administration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="author" content="Castlamp (http://www.castlamp.com/)"/>
    <meta name="generator" content="ShulNET Membership Software"/>
    <link rel="stylesheet" type="text/css" media="all" href="css/reset.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="css/printer.css"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/highcharts.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('a').bind("click.myDisable", function() { return false; });
        });
        function return_to_normal() {
            history.go(-1);
        }
    </script>
</head>
<body>

<a name="pagetop"></a>