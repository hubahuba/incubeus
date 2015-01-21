<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{{ $title }}}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        @if(isset($style))
            @include($style)
        @else
            @include('admin.styles.global')
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
            <a href="{{{ URL::nccms('/') }}}" class="logo">
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
            </nav>
        </header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li><a href="{{ URL::nccms('media/ckeditor/image') }}"><i class="fa fa-picture-o"></i> Libraries</a></li>
                        <li><a href="{{ URL::nccms('media/ckeditor/upload') }}"><i class="fa fa-upload"></i> Upload</a></li>
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
            @include('admin.scripts.global')
        @endif
    </body>
</html>