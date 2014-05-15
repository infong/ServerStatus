<!DOCTYPE html>
<html>
    <head>
        <title>ServerStatus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo $base_url . THEMESDIR . $theme; ?>/css/custom.css" rel="stylesheet">
        <style>
            body { padding-top: 60px; }
            @media (max-width: 979px) {
                body { padding-top: 0px; }
            }
        </style>
    </head>
<body>
    <div class="navbar navbar-fixed-top<?php echo $theme == 'dark' ? ' navbar-inverse':'' ?>">
      <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="#">ServerStatus</a>
        </div>
      </div>
    </div>

    <div class="container content">
        <table class="table table-striped table-condensed">
            <thead>
            <tr>
                <th id="status" style="text-align: center;">Status</th>
                <th id="name">Name</th>
                <th id="type">Type</th>
                <th id="host">Host</th>
                <th id="location">Location</th>
                <th id="uptime">Uptime</th>
                <th id="load">Load</th>
                <th id="ram">RAM</th>
                <th id="hdd">HDD</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $sTable; ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <p style="text-align: center; font-size: 10px;"><a href="https://github.com/mojeda/ServerStatus">ServerStatus</a> by <a href="http://www.mojeda.com">Michael Ojeda</a></p>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="<?php echo $base_url . THEMESDIR ?>common/test.js"></script>
    <script type="text/javascript">
    $(function(){
      var servers = <?php echo json_encode($servers) ?>;
      var server, tagId;
      for (var key in servers) {
        server = key;
        tagId = servers[key];
        test(server, tagId);
        (function loop(server, tagId) {
          setTimeout(function () {
            test(server, tagId);
            loop(server, tagId);
          }, <?php echo $refresh ?>);
        })(server, tagId);
      }
    });
    </script>
</body>
</html>
