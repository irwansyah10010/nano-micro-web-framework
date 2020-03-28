<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome N A N O</title>
        <style>
            body{
                margin: 150px auto;
            }
            
            #badan{
                
                color: #444;
                margin: 150px auto;
                width: 80%;
            }
            
            #badan h1{
                letter-spacing: 5px;
            }

            .konten{
                width: 80%;
                background-color : lightgreen;
                height: auto;
                padding: 15px 10px;
                
            }
        </style>
    </head>
    <body>
        <div id="badan">
            <h1>Welcome To Framework NANO</h1>
            <div class="konten">
                <h3>Started using framework</h3>
                <ul>
                    <li>Set App and Database in file environment.json
                        <ul> 
                            <li>App
                                <ul>
                                    <li>App_name : Name from web. Example -> Web design application</li>
                                    <li>App_server : homepage web or project name. Example -> /FrameworkNano/</li>
                                    <li>App_import : place for web asset like css dan js. Example -> /FrameworkNano/asset/</li>
                                    <li>App_files : place for web file like photos, videos etc -> /FrameworkNano/files/</li>
                                </ul>
                            </li><br>
                            <li>Database
                                <ul>
                                    <li>DB_driver: driver RDBMS, RDBMS available -> MySQL(mysql) and PostGre(pgsql)</li>
                                    <li>DB_name : name database, example -> Lat_Base</li>
                                    <li>DB_port : port number, example -> 3306</li>
                                    <li>DB_host : host domain, example -> localhost</li>
                                    <li>DB_user : user from database, example -> root</li>
                                    <li>DB_password : password user, example -> root</li>
                                </ul>
                            </li><br>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>
