
<!doctype html>
<html lang="en">
<head>

    <link href="{{{URL::to('/')}}}/css/footable.core.css" rel="stylesheet " type="text/css">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="{{{URL::to('/')}}}/css/materialize.min.css"  media="screen,projection"/>
    <link href="{{{URL::to('/')}}}/css/custom.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="{{{URL::to('/')}}}/js/jquery-1.9.0.js"></script>
    <script src="{{{URL::to('/')}}}/js/bootstrap.min.js"></script>
    <script src="{{{URL::to('/')}}}/js/footable.min.js"></script>
    <script type="text/javascript" src="{{{URL::to('/')}}}/js/materialize.min.js"></script>
    <script src="{{{URL::to('/')}}}/js/uservoice.js"></script>
    <script src="{{{URL::to('/')}}}/js/edScript.js"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable({
                breakpoints: {

                }
            });
        });

        $(function() {
          $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html, body').animate({
                  scrollTop: target.offset().top - 220
                }, 2000);
                return false;
              }
            }
          });
        });
    </script>
    <title>Ed Support Assessment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

</head>
<body>
<div class="navbar-fixed">
  <nav>

    </div>
  </nav>
</div>
  <div class="container">
      <h1 class='title' style="text-align:center">Import CSV</h1>
      @yield('content')
  </div>

  <div class="form-group">
    <form name="import-file" method="post" action="./importcsv" enctype="multipart/form-data">
      <input type="file" name="file_upload[]" multiple/>
      <input type="submit" value="Submit"/>
    </form>
  </div>

  @yield('body')

</body>
</html>
