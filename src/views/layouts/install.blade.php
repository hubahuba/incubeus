<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{{ $title }}}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{ HTML::style(asset('themes/waldo/css/bootstrap.css')) }}
        {{ HTML::style(asset('themes/waldo/css/style.css')) }}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            WebFontConfig = {
                google: { families: [ 'Raleway:700,400,300:latin' ] }
            };
            (function() {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();

        </script>
        {{ HTML::script(asset('themes/waldo/js/loader.min.js')) }}
    </head>
    <body>
        <header>
            <div class="clearfix header-middle">
                <div class="inheader-middle">
                    <div class="logo replacement"><span>NCCMS</span></div>
                    <!-- end logo-->
                </div>
            </div>
        </header>

        <section class="contents">
            <div class="inner-container">
                <div class="container-fluid mt-25">
                    <div class="col-sm-8 post-list-container">
                        @yield('content')
                    </div>

                    <div class="col-sm-4">
                        <div class="sidebar-widget">
                            <div class="sidebar-widget-title">
                                <h4>TODO Here :</h4>
                                <hr>
                            </div>
                            <div class="sidebar-widget-content">
                                <ul>
                                    <li>Set Database Configuration (Current support MySQL Only)</li>
                                    <li>Create Administrator User</li>
                                    <li>Set Website Configuration</li>
                                    <li>Set Image Media Configuration</li>
                                    <li>Set Application Configuration</li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <div class="sidebar-widget-title">
                                <h4>NCCMS Requirement :</h4>
                                <hr>
                            </div>
                            <div class="sidebar-widget-content">
                                <ul>
                                    <li>PHP 5.4+ (<i>Recomended :PHP 5.5</i>)</li>
                                    <li>PHP PDO Extension</li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <div class="sidebar-widget-title">
                                <h4>NCCMS Dependency :</h4>
                                <hr>
                            </div>
                            <div class="sidebar-widget-content">
                                <ul>
                                    <li>
                                        SCSSPHP <a target="_blank" href="http://leafo.net/scssphp/">Source</a>
                                        <ul>
                                            <li>PHP SCSS Compiler (only work for SCSS syntax, not SASS syntax)</li>
                                        </ul>
                                    </li>
                                    <li>
                                        Minify <a target="_blank" href="https://github.com/ceesvanegmond/minify">Source</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{ HTML::script(asset('themes/waldo/js/amd.min.js')) }}
        {{ HTML::script(asset('themes/waldo/js/vendor.min.js')) }}
        {{ HTML::script(asset('themes/waldo/js/plugins.min.js')) }}
        {{ HTML::script(asset('themes/waldo/js/init.min.js')) }}
    </body>
</html>