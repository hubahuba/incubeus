<?php

Route::filter('isAdmin', function($route, $request)
{
    if (!Session::has('logedin'))
    {
        if(Config::get('nccms::nccms.group') == 'prefix') {
            if ($request->segment(2) != 'login') return Redirect::to(Config::get('nccms::nccms.route') . '/login');
        }else{
            if ($request->segment(1) != 'login') return Redirect::to('login');
        }
    }else{
        if(Config::get('nccms::nccms.group') == 'prefix') {
            if ($request->segment(2) == 'login') return Redirect::to(Config::get('nccms::nccms.route'));
        }else{
            if ($request->segment(1) == 'login') return Redirect::to('/');
        }
    }
});

Route::filter('isInstall', function($route, $request)
{
    if($request->segment(1) != 'installation') {
        if (!Config::get('nccms::nccms.installed')) {
            return Redirect::to('installation');
        }
    }
});

Route::filter('alreadyInstall', function($route, $request)
{
    if (Config::get('nccms::nccms.installed'))
    {
        return Redirect::to('/');
    }
});