<?php
/*
* Copyright 2015 Litarvan & Vavaballz
*
* This file is part of OpenAuth.

* OpenAuth is free software: you can redistribute it and/or modify
* it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* OpenAuth is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public License
* along with OpenAuth.  If not, see <http://www.gnu.org/licenses/>.
*/

$VERSION = "1.0.0-SNAPSHOT";

if(isset($_GET['request']))
    if($_GET['request'] == 'download')
        download();
    else if($_GET['request'] == 'install')
        install();
    else if($_GET['request'] == 'deleteInstaller')
        deleteInstaller();
    else
        home();
else
    home();

function download() {
    global $VERSION;
    file_put_contents("openauth-server-$VERSION.zip", fopen("http://litarvan.github.io/OpenAuth-Server/server/openauth-server-$VERSION.zip", 'r'));
    echo "success";
}

function install() {
    global $VERSION;

    $file = "openauth-server-$VERSION.zip";
    $path = pathinfo(realpath($file), PATHINFO_DIRNAME);
    $zip = new ZipArchive;

    if ($zip->open($file) === TRUE) {
        $zip->extractTo($path);
        $zip->close();
        echo "success";
    } else
        echo "Unable to close the zip. Don't forget to set the current folder permissions to 777";

    unlink($file);
}

function deleteInstaller() {
    unlink("installer.php");
    echo "success";
}

function home() {

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OpenAuth Server Installer</title>

        <!-- The OpenAuth Icon -->
        <link rel="icon" href="http://litarvan.github.io/OpenAuth-Server/icon.png" />

        <!-- Bootstrap -->
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="http://litarvan.github.io/OpenAuth-Server/style.css" rel="stylesheet">
    </head>

    <body>
    <div class='fulldiv'>
        <div class="center">
            <img src="http://litarvan.github.io/OpenAuth-Server/logo.png" />
        </div>

        <div class="progress">
            <div id="pb" class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- Offical OpenAuth script -->
    <script src="http://litarvan.github.io/OpenAuth-Server/openauth.js"></script>

    <!-- Starting Installer -->
    <script> sendRequest("installer.php", "download", startInstallation); </script>
    </body>
    </html>

    <?php

}

?>