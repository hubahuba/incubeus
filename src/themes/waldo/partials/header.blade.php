<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['title'] }} - {{ \Nccms::getTitle() }}</title>
    <meta name="description" content="{{ \Nccms::getTitle() }}">
    <meta name="author" content="{{ \Nccms::getTagline() }}">
    {{ HTML::style(asset('themes/waldo/builds/a008bb88d6e2d35f79b603e619c09f454263928188.css')) }}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ \Config::get('app.url') }}" />
    <meta property="og:url" content="{{ \URL::current() }}" />
    <meta property="og:image" itemprop="image" name="twitter:image" content="{{ isset($data['feature_image']) ? \Config::get('app.url') . $data['feature_image']:asset('img/og_img.jpg') }}" />
    <meta property="og:description" itemprop="description" name="twitter:description" content="{{ isset($data['excerpt']) ? $data['excerpt']:\Nccms::getTagline() }}"/>
    <meta property="og:title" itemprop="name" name="twitter:title" content="{{ isset($data['title']) ? $data['title']:\Nccms::getTitle() }}"/>
    @if(\Nccms::getGA())
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', {{ \Nccms::getGA() }}, 'auto');
        ga('send', 'pageview');
    </script>
    @endif
</head>
<body>
    <header>
        <div class="clearfix header-top">
            {{ \Nccms::menu('socmed-top') }}
        </div>
        <hr class="no-margin">
        <!-- end header-top-->
        <div class="clearfix header-middle">
            <div class="inheader-middle">
                <div class="logo replacement">
                    <span>{{ \Nccms::getTitle() }}</span>
                </div>
                <!-- end logo-->
            </div>
            {{ \Nccms::menu('top-menu') }}
        <div>
        <!-- end header-middle-->
        <div class="visible-xs">
            {{ \Nccms::menu('top-mobile-menu') }}
        </div>
        <!-- end mobile navigation-->
        <hr class="no-margin">
    </header>
    <section class="contents">
        <div class="inner-container">
            <div class="container-fluid mt-25">
                <div class="row">