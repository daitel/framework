<?php
/**
 * Daitel Framework
 * Errors View
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 *
 * @var DfException $ex
 */
?>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php ?></title></head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
      crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.7/styles/darkula.min.css">
<style>
    body {
        font: "Courier New", Courier, monospace;
        background: #2B2B2B;
        padding-top: 10px;
        color: #A9B7C6;
    }

    .panel-body {
        background: #2B2B2B;
    }

    a a:hover a:visited {
        color: #287BDE;
    }

    .popover {
        width: 600px;
    }

    .table td {
        padding-top: 3px;
        padding-bottom: 3px;
    }

    .table-condensed td {
        padding-top: 0;
        padding-bottom: 0;
    }

    .table .progress {
        margin-bottom: inherit;
    }

    .table-borderless th, .table-borderless td {
        border: 0 !important;
    }

    .table > tbody > tr.success > td, .table > tbody > tr.success > th, .table > tbody > tr > td.success, .table > tbody > tr > th.success, .table > tfoot > tr.success > td, .table > tfoot > tr.success > th, .table > tfoot > tr > td.success, .table > tfoot > tr > th.success, .table > thead > tr.success > td, .table > thead > tr.success > th, .table > thead > tr > td.success, .table > thead > tr > th.success {
        background-color: #007F00;
        color: #FFF;
    }

    .table > tbody > tr.danger > td, .table > tbody > tr.danger > th, .table > tbody > tr > td.danger, .table > tbody > tr > th.danger, .table > tfoot > tr.danger > td, .table > tfoot > tr.danger > th, .table > tfoot > tr > td.danger, .table > tfoot > tr > th.danger, .table > thead > tr.danger > td, .table > thead > tr.danger > th, .table > thead > tr > td.danger, .table > thead > tr > th.danger {
        background-color: rgba(255, 45, 38, 0.51);
        color: #FFF;
    }

    td.codeLine {
        font-family: monospace;
        white-space: pre;
    }

    td span.comment {
        color: #6A8759;
    }

    td span.default {
        color: #A9B7C6;
    }

    td span.html {
        color: #6A8759;
    }

    td span.keyword {
        color: #FFC66D;
        font-weight: bold;
    }
</style>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-danger">
                <?php echo get_class($ex); ?>
            </h1>

            <h2 class="text-muted"><?php echo $ex->getMessage() ?></h2>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?php echo $ex->getFile(); ?>
                                    <div align="right">Line: <?php echo $ex->getLine() ?></div>
                                </h4>
                            </div>
                            <div class="panel-body">
                                <table class="table table-borderless table-condensed">
                                    <?php
                                    DfErrorHandler::showSources($ex->getFile(), false, $ex->getLine());
                                    ?>
                                </table>
                            </div>
                        </div>

                        <h3>Stack Trace</h3>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <?php foreach ($ex->getTrace() as $id => $call): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?php echo $id ?>">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#accordion<?php echo $id ?>" aria-expanded="true"
                                               aria-controls="<?php echo $id ?>">
                                                <?php echo $call['file'] ?>
                                                <div align="right">Line: <?php echo $call['line'] ?></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="accordion<?php echo $id ?>" class="panel-collapse collapse"
                                         role="tabpanel"
                                         aria-labelledby="heading<?php echo $id ?>">
                                        <div class="panel-body">
                                            <table class="table table-borderless table-condensed">
                                                <?php
                                                DfErrorHandler::showSources($call['file'], false, $call['line']);
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>