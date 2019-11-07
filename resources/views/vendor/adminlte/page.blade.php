@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ secure_asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ route('misc.home', [], false) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ route('misc.home', [], false) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle fa5" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ __('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                      <li><a>{{ Auth::user()->name }}</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-power-off"></i> {{ __('adminlte::adminlte.log_out') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout', [], false) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        @if(config('adminlte.right_sidebar') and (config('adminlte.layout') != 'top-nav'))
                        <!-- Control Sidebar Toggle Button -->
                            <li>
                              <a href="#" data-toggle="control-sidebar" @if(!config('adminlte.right_sidebar_slide')) data-controlsidebar-slide="false" @endif>
                                @if(session()->has('notifycount'))
                                <i class="{{config('adminlte.right_sidebar_icon')}}"></i>
                                <span class="pull-right-container">
                                    <span class="label label-warning pull-right">{{ session()->get('notifycount')}}</span>
                                </span>
                                @else
                                <i class="fas fa-bullhorn"></i>
                                @endif
                              </a>
                            </li>
                        @endif
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        @hasSection('footer')
        <footer class="main-footer">
            @yield('footer')
        </footer>
        @endif

        @if(config('adminlte.right_sidebar') and (config('adminlte.layout') != 'top-nav'))
            <aside class="control-sidebar control-sidebar-{{config('adminlte.right_sidebar_theme')}}">
                <!-- yield('right-sidebar') -->
                <ul class="control-sidebar-menu">
                  @if(session()->has('notifycount') && session()->get('notifycount') > 0)
                  @foreach(session()->get('notifylist') as $onutifi)
                  <li>
                    <a href="{{ $onutifi['href'] }}">
                      <i class="{{ $onutifi['icon'] }}"></i>
                      <span>{{ $onutifi['text'] }}</span>
                    </a>
                  </li>
                  @endforeach
                  @else
                  <li style="text-align:center">Nothing to show here</li>
                  @endif
                </ul>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        @endif

    </div>
    <!-- ./wrapper -->
    
<div id="applyOT" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New OT Claim</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('ot.create')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="inputname">Select Date:</label>
                        <input type="date" class="form-control" id="inputdates" name="inputdates" value="" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">CREATE</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('adminlte_js')
    <script src="{{ secure_asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
    
    <script type="text/javascript">
        $('#applyOT').on('show.bs.modal', function() {
        var dt = new Date();
        var m = dt.getMonth()+1;
        if(m < 10){
            m = "0"+m;
        }
        d = dt.getDate().toString();
        while(d.length<2){
            d = "0"+d;
        }
        $("#inputdates").val(dt.getFullYear()+"-"+m+"-"+d);
        $("#inputdates").attr("max", dt.getFullYear()+"-"+m+"-"+d);
        
        });
    </script>
@stop
