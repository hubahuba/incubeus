<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{{ $title }}}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        @if(isset($style))
            @include($style)
        @else
            @include('nccms::admin.styles.global')
        @endif

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="{{{ URL::to('/') }}}" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                {{ \Ngungut\Nccms\Model\Settings::getTitle() }}
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>{{{ Session::get('nickname') }}} <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="{{ asset('packages/ngungut/nccms/img/avatar.png') }}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{{ Ngungut\Nccms\Model\User::firstname(Session::get('logedin')) }}} {{{ Ngungut\Nccms\Model\User::lastname(Session::get('logedin')) }}}
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{{ URL::nccms('profile') }}}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{{ URL::nccms('logout') }}}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ URL::nccms('/') }}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-paperclip"></i>
                                <span>Post</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::nccms('post/new') }}"><i class="fa fa-angle-double-right"></i> New Post</a></li>
                                <li><a href="{{ URL::nccms('post') }}"><i class="fa fa-angle-double-right"></i> All Post</a></li>
                                <li><a href="{{ URL::nccms('post/categories') }}"><i class="fa fa-angle-double-right"></i> Categories</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-file-text-o"></i>
                                <span>Page</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::nccms('page/new') }}"><i class="fa fa-angle-double-right"></i> New Page</a></li>
                                <li><a href="{{ URL::nccms('page') }}"><i class="fa fa-angle-double-right"></i> All Page</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-picture-o"></i>
                                <span>Media</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::nccms('media/libraries') }}"><i class="fa fa-angle-double-right"></i> Libraries</a></li>
                                <li><a href="{{ URL::nccms('media/upload') }}"><i class="fa fa-angle-double-right"></i> Upload</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-desktop"></i> <span>Appearence</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ URL::nccms('themes') }}"><i class="fa fa-angle-double-right"></i> Themes</a></li>
                                <li><a href="{{ URL::nccms('assets') }}"><i class="fa fa-angle-double-right"></i> Assets</a></li>
                                <li><a href="{{ URL::nccms('partials') }}"><i class="fa fa-angle-double-right"></i> Partials</a></li>
                                <li><a href="{{ URL::nccms('menus') }}"><i class="fa fa-angle-double-right"></i> Menus</a></li>
                                <li><a href="{{ URL::nccms('templates') }}"><i class="fa fa-angle-double-right"></i> Template</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ URL::nccms('users') }}">
                                <i class="fa fa-group"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::nccms('setting') }}">
                                <i class="fa fa-cogs"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        {{ \App::make('pluginNavigation') }}
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                @yield('content')

            </aside><!-- /.right-side -->

        </div>

        @if(isset($script))
            @include($script)
        @else
            @include('nccms::admin.scripts.global')
        @endif

    </body>
</html>