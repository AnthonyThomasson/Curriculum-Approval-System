<?php 

function createHeader($title)
{
  
   $header = '<!DOCTYPE html>
              <html lang="en">
                  <head>
                    <!-- Latest compiled and minified Bootstrap Core CSS -->
                    <link rel="stylesheet" href="'.BOOTSTRAP.'">

                    <!-- Jquery -->
                    <script src="'.JQUERY.'"></script>

                    <!-- Plugin CSS -->
                    <link rel="stylesheet" type="text/css" href="'.PLUGINS_PATH.'slick/slick.css"/>
                    <link rel="stylesheet" type="text/css" href="'.PLUGINS_PATH.'TableSort/style.css"/>
                    <link rel="stylesheet" type="text/css" media="screen" href="'.PLUGINS_PATH.'validetta/validetta.css" >

                    <!-- Custom CSS -->
                    <link href="'.CSS_PATH.'custom.css" rel="stylesheet">

                    <!-- Plugin JS -->
                    <script type="text/javascript" src="'.PLUGINS_PATH.'TableSort/tsort.min.js"></script>
                    <script type="text/javascript" src="'.PLUGINS_PATH.'slick/slick.min.js"></script>
                    <script type="text/javascript" src="'.PLUGINS_PATH.'validetta/validetta.js"></script>

                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">

                    <title>'.$title.'</title>
                  </head>';
    return $header;
}
?>
