<!doctype html>
<html lang="en">
<head> 
 
    <link href="{{{URL::to('/')}}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{{URL::to('/')}}}/css/footable.core.css" rel="stylesheet " type="text/css">
    <link href="{{{URL::to('/')}}}/css/custom.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="{{{URL::to('/')}}}/js/jquery-1.9.0.js"></script>
    <script src="{{{URL::to('/')}}}/js/bootstrap.min.js"></script>
    <script src="{{{URL::to('/')}}}/js/footable.min.js"></script>
<!--     <script src="{{{URL::to('/')}}}/js/footable.filter.min.js"></script> -->
    <script src="{{{URL::to('/')}}}/js/footable.paginate.min.js"></script>
<!--     <script src="{{{URL::to('/')}}}/js/footable.sort.min.js"></script> -->
    <script src="{{{URL::to('/')}}}/js/uservoice.js"></script>
    <script src="{{{URL::to('/')}}}/js/edScript.js"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable({
                breakpoints: {
                    phone: 640,
                }
            });
        });
    </script>
    <title>Ed Support Assessment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	
</head>
<body>
<body class="blue-red">
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
	      <span class="sr-only">Toggle navigation</span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	  </button>
	  <!--@section('navbar-header')-->
	  <!--<a class="navbar-brand" href="{{{URL::to('/')}}}/../../../madapp/index.php/dashboard/dashboard_view">MADApp</a>-->
	  @if(Route::currentRouteName() != "home")
            <a class="navbar-brand" href="javascript:history.back()"><span class="glyphicon glyphicon-chevron-left"></span></a>
      @endif
      <a class="navbar-brand" href="{{{URL::to('/manage')}}}">Ed Support</a>
      
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
	  <ul class="nav navbar-nav navbar-right">
	      <!--@section('navbar-links')-->
	      <!--<li><a href="{{{URL::to('/')}}}/calendar">Calendar</a></li>
	      <li><a href="{{{URL::to('/')}}}/attendance">Attendance</a></li>
	      <li><a href="{{{URL::to('/')}}}/wingman-journal">Wingman Journal</a></li>-->
	      <li class=""><a>
	      <?php
            $i = 0;
            $id = $_SESSION['user_id'];
            $name = DB::table('User')->select('name')->where('id',$id)->first();
            echo $name->name.' (';  
            $groups = DB::table('UserGroup')->join('Group','Group.id','=','UserGroup.group_id')->select('Group.name')->where('user_id',$id)->get();
            $result = array(); 
            foreach ($groups as $group){
                $result[$i]=$group->name;
                $i++;
            }
            $value = join(',',$result);
            echo $value.')';
        ?></a>
	      </li>
	      <li class=""><a href="{{{URL::to('/')}}}/../../../madapp/index.php/auth/logout">Logout</a></li>
	  </ul>
      </div>
    </div>
</nav>
  <div class="container-fluid">
      <div class='board transparent-container'>	
      <h3 class='title' style="text-align:center">Assessment Report</h3>
    
	  @yield('content')
      </div>
  </div>
</body>
</html>
