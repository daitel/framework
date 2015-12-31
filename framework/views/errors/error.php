<?php
/**
 * @link https://github.com/daitel/framework
 */

/**
 * Errors View
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 * @var Exception $ex
 */
?>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unexpected Error</title></head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        font: "Courier New", Courier, monospace;
        background: #2B2B2B;
        padding-top: 10px;
        color: #A9B7C6;
    }

    hr {
        border-top: 1px solid #797979;
    }

    .panel-body {
        background: #2B2B2B;
    }
</style>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-danger">
                Unexpected error
            </h1>
            <hr>
            <h2 class="text-muted">Sorry for that. Our team already knows about it and working on a fix.</h2>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>