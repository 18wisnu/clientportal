<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    if (!session()->has('logged_in')) {
        return redirect('/login');
    }
    return view('dashboard');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', function (Request $request) {
    // Dummy auth
    if ($request->username === '085712345678' && $request->password === 'password123') {
        session(['logged_in' => true]);
        return redirect('/');
    } else {
        return back()->with('error', 'Nomor HP atau password salah!');
    }
});

Route::get('/logout', function () {
    session()->forget('logged_in');
    return view('auth.logout');
});