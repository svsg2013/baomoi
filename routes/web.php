<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Route for user */
Route::get('', 'PagesController@getindex');
/* Display front */
Route::get('/{slug}',function ($slug){
    $baiviet= App\Post::where('slug',$slug)->exists();
    $danhmuc= App\Category::where('slug',$slug)->exists();
    if ($baiviet==1){
        $post = App\Post::where('status',1)->where('slug', $slug)->first();
        if(count($post)==0){
            return view('news.pages.singlepost',['key'=>$slug]);
        } else
        {
            $post->view = $post->view + 1;
            $post_lq = App\Post::where('status',1)->where('slug','!=', $slug)->where('category_id','=',$post->category_id)->take(5)->get();
            $post->save();
            return view('news.pages.singlepost',['post'=>$post,'lq'=>$post_lq]);
        }
    }elseif($danhmuc==1){
        $cate = App\Category::where('slug', $slug)->first();
        if(count($cate)==0 || count($cate->posts)==0){
            return view('news.pages.category',['key'=>$slug]);
        } else {
            $list = App\Post::where('category_id',$cate->id)->where('status',1)->orderBy('created_at','des')->paginate(2);
            return view('news.pages.category',['posts'=>$list,'cate'=>$cate->name]);
        }
    }
});

Route::get('tag/{tag}','PagesController@getTag');
Route::get('author/{name}','PagesController@getAuthor');
Route::get('search','PagesController@getSearch')->name('search');
Route::get('contact.html','PagesController@getContact');
Route::get('admin/login', 'LoginController@getLogin');
Route::post('admin/login', 'LoginController@postLogin')->name('login');
Route::get('logout', 'LoginController@getLogout');

/*Group router for author and admin */
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

	Route::get('/dashboard', 'HomeController@getdashbroad')->name('dashbroad');
	/* Group for profile */
    Route::get('profile', 'ProfileController@getProfile');
    Route::post('profile/update', 'ProfileController@profileUpdate');

    /* Group post*/
    Route::prefix('post')->group(function () {
        Route::get('/', 'PostController@getList')->name('list-post');
        Route::get('add', 'PostController@getAdd');
        Route::put('updateStatus', 'PostController@updateStatus');
        Route::put('updateHot', 'PostController@updateHot');
        Route::post('add', 'PostController@postAdd');
        Route::get('update/{id}', 'PostController@getUpdate');
        Route::post('update/{id}', 'PostController@postUpdate');
        Route::get('delete/{id}', 'PostController@getDelete');
    });
    
    /* Group for admin */
    Route::middleware(['role'])->group(function () {
        /* Group category */
        Route::prefix('category')->group(function () {
            Route::get('/', 'CategoryController@getList');
            Route::get('add', 'CategoryController@getAdd');
            Route::post('add', 'CategoryController@postAdd');
            Route::get('data', 'CategoryController@dataTable')->name('data');
            Route::post('update', 'CategoryController@postUpdate');
            Route::delete('delete', 'CategoryController@delete');
        });
        /* Group file */
        Route::prefix('tag')->group(function () {
            Route::get('/', 'TagController@getList')->name('list-tag');
            Route::get('data', 'TagController@dataTable')->name('data-tag');
            Route::post('add', 'TagController@postAdd');
            Route::put('update', 'TagController@putUpdate');
            Route::delete('delete', 'TagController@delete');
        });
        /* Group author */
        Route::prefix('author')->group(function () {
            Route::get('/', 'AdminController@getList')->name('list-author');
            Route::get('data', 'AdminController@dataTable')->name('data-author');
            Route::post('add', 'AdminController@postAdd');
            Route::delete('delete', 'AdminController@delete');
        });
    });
});