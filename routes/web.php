<?php
Route::get('/', 'WelcomeController@index');
Route::get('/privacy-policy', function(){
    $content = DB::table('pages as p')
                ->join('pages_description as pd', function($p){
                    $p->on('p.page_id', 'pd.page_description_id');
                })
                ->where('p.slug', 'privacy-policy')
                ->where('pd.language_id', 1)
                ->first()->description;
                
    return view("privacy_policy", compact('content'));
});
Route::get('/frontend',  function () {
    return view('frontend.frontend');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/symlink', function () {
    $exitCode = Artisan::call('storage:link');
});


Route::get('/up', function() {
    $output = new \Symfony\Component\Console\Output\BufferedOutput;
    \Artisan::call('up', $output);
    dd($output->fetch());
});