<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nice Apartment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="singin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"/>
    
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Latest compiled JavaScript -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    
    <script src="main.js"></script>
    <script src="accountantChart.js"></script>
    <script src='custom/TableLayouts.js'/></script>
    <link rel='stylesheet' href='custom/CustomJS.css'/>
    <script src="https://rawgit.com/Microsoft/TypeScript/master/lib/typescriptServices.js"></script>
    <script src="https://rawgit.com/basarat/typescript-script/master/transpiler.js"></script>
    <script src="custom/bs4-toast.js"></script>
    <script type="text/typescript" src="custom/bs4-toast.ts"></script>
    <link rel='stylesheet' href='custom/bs4Toast.css'/>

    <!-- ChartJS -->
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
     <script>
      window.onload = function() {
        SetTimeHeader();
      };
    </script>
    @yield('head')
</head>

<body>
<div class="header">
  <div class="header--logo">
    <div class="header--logo__icon">
    <i class="fas fa-building"></i>
    </div>
    <div class="header--logo__text">NICE APARTMENT</div>
  </div>
  <div class="headerTime">
  </div>
  <div class="header--close">
  @can('authenticated')
    <div class="user__img--container">
    <img src="{{Auth::user()->Avatar}}" alt="" class="user--img">
    </div>
  @endcan
      <div class="dropdown" style='margin-left: 10px;'>
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"></i></a>
          <ul class="dropdown-menu">
            @cannot('authenticated')
            <li><a href="{{ route('login') }}">Sign in</a></li>
            <li><a href="{{ route('register') }}">Sign up</a></li>
            @endcannot

            @can('authenticated')
            <li>
            <div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    {{ __('Đăng xuất') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            </a></li>
            @endcan  
          </ul>
      </div>
  </div>
</div>
<div class="main">
  <div class="slide_bar">

      @if (auth()->user()->Role == 'Manager')
      <nav class="navbar">
        <ul class="navbar-nav r-affect">
          <li class="nav-item" onclick="window.location.replace('?tab-selection=1')">
            <a class="nav-link">General</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=2')">
            <a class="nav-link">Contracts</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=3')">
            <a class="nav-link">Apartment Management</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=4')">
            <a class="nav-link">Individual Management</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=5')">
            <a class="nav-link">Error Report</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=6')">
            <a class="nav-link">Regulations</a>
          </li>
        </ul>
      </nav>
      @else
      <nav class="navbar">
        <ul class="navbar-nav r-affect">
          <li class="nav-item" onclick="window.location.replace('?tab-selection=1')">
            <a class="nav-link">General</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=2')">
            <a class="nav-link">Statistics</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=3')">
            <a class="nav-link">Customer Bills</a>
          </li>
          <li class="nav-item" onclick="window.location.replace('?tab-selection=4')">
            <a class="nav-link">Partner Bills</a>
          </li>
          </li>
        </ul>
      </nav>
      @endif
    <div class="clear"> 
    </div>
  </div>
  <div class="content">
      @yield('content')  
      @yield('regulation')
  </div>
</div>
<footer>
  <i class="fa-brands fa-envira"></i>
  <i class="fa-solid fa-leaf"></i>
    <span class="footer--text">NICE APARTMENT</span>
</footer>
</body>
</html>