<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php

use engine\errors\ErrorCode;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Error Page</title>
        <style type="text/css">            
            #wrapper{
                margin: 5px auto;
                width: 65%;
                box-shadow: 1px 1px 1px 1px activeborder;
                
            }
            
            #header{
                padding: 1px;
                background-color: whitesmoke;
                border-radius: 5px 5px;
            }
            
            #body{
                padding: 5px;
                
            }
            
            #footer{
                background-color: whitesmoke;
                border-radius: 5px 5px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h3>Page Error</h3>
            </div>
            <div id="body">
                <?php 
                    echo ErrorCode::getMessage();
                ?>
            </div>
            <div id="footer">
                <p>Copyright&copy;2017 by me</p>
            </div>
        </div>
    </body>
</html>

