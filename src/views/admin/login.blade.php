<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>{{ (\Ngungut\Nccms\Model\Settings::getTitle()) ? \Ngungut\Nccms\Model\Settings::getTitle():'NCCMS' }} | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {{ HTML::style(asset('packages/ngungut/nccms/css/bootstrap.min.css')) }}
        {{ HTML::style(asset('packages/ngungut/nccms/css/font-awesome.min.css')) }}
        {{ HTML::style(asset('packages/ngungut/nccms/css/AdminLTE.css')) }}
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            {{ Form::open([
                'url' => URL::current()
            ]) }}

                <div class="body bg-gray">
                    <div class="form-group{{ $errors->first('userid') ? ' has-error':'' }}">
                        @if($errors->first('userid')) <label class="control-label" for="inputError">{{{ $errors->first('userid') }}}</label> @endif
                        <input type="text" name="userid" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group{{ $errors->first('userid') ? ' has-error':'' }}">
                        @if($errors->first('password')) <label class="control-label" for="inputError">{{{ $errors->first('password') }}}</label> @endif
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>
                </div>

            {{ Form::close() }}
        </div>

        {{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
        {{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}

    </body>
</html>