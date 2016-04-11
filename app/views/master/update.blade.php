<!doctype html>
<html lang="en">
<head> 
 
    <!--<link href="{{{URL::to('/')}}}/css/bootstrap.min.css" rel="stylesheet">-->
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
<!--     <script src="{{{URL::to('/')}}}/js/footable.filter.min.js"></script> -->
<!--     <script src="{{{URL::to('/')}}}/js/footable.paginate.min.js"></script> 
<!--     <script src="{{{URL::to('/')}}}/js/footable.sort.min.js"><//script> -->
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
                }, 2);
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
    <div class="container-fluid">
      @if(Route::currentRouteName() != "home")
        <a class="brand-logo" href="javascript:history.back()"><span class="glyphicon glyphicon-chevron-left"></span></a>
      @endif
      <a class="brand-logo" href="{{{URL::to('/manage')}}}">&nbsp; &nbsp;Ed Support</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li>
          @if($_SESSION['group_id']=='1')
          <form class="form-nav" method="post" action="{{{URL::to('/selectCity')}}}">  
          <?php
            $all_cities = DB::table('City')->select('id','name')->orderBy('name','ASC')->get();
            $years = array();
            for($y = date('Y'); $y >=2011 ; $y--) $years[$y] = $y;
            echo '<div class="input-field col 3"><div class="row"><div class="col 6"><select id="selectCity" name="select_city">';
            foreach ($all_cities as $city) {
              echo '<option value="'.
              $city->id.'" '.($city->id==$_SESSION['city_id']?'selected>':'>').
              $city->name.'</option>';
            }
            echo '</select></div><div class="col 6"><button class="waves-effect waves-light btn submit" type="submit" name="action">Submit</button></div></div> ';
          ?>
        </form>
        @endif
      </li>
      <li>
            <a>
             <?php
              $i = 0;
              $id = $_SESSION['user_id'];
              $home = new HomeController;
              $name = DB::table('User')->select('name')->where('id',$id)->first();
              echo $name->name.' (';  
              $groups = DB::table('UserGroup')->join('Group','Group.id','=','UserGroup.group_id')->select ('Group.name')->where('user_id',$id)->where('year',$home->get_year())->get();
              $result = array(); 
              foreach ($groups as $group){
                  $result[$i]=$group->name;
                  $i++;
              }
              $value = join(',',$result);
              echo $value.')';
            ?></a>
          </li>
          <li><a href="{{{URL::to('/manage')}}}/../../../madapp/index.php/auth/logout">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>
  <div class="container">
      <h1 class='title' style="text-align:center">Update Scores</h1>
      @yield('content')
  </div>

  @if(Session::has('success'))
      <div class="center-block alert alert-success" role="alert" style="width:20%;">{{ Session::get('success') }}</div>
  @endif

  @if(Session::has('error'))
  <div class="center-block alert alert-danger" role="alert" style="width:20%;">{{ Session::get('error') }}</div>
  @endif

  @yield('body')

</body>
</html>
