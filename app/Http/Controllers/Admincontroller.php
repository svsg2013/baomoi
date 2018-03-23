<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Datatables;
use Illuminate\Support\Facades\Crypt;

class Admincontroller extends Controller
{
    public function getList()
    {
    	return view('admin.author.list');
    }

    public function postAdd(Request $request)
    {
    	if($request->ajax()){
	    	$author = new Admin();
	    	$author->name = $request->input('authorname');
	    	$author->password =bcrypt($request->input('password'));
	    	$author->email = $request->input('email');
	    	$author->save();
	        return 'ok';
	    }
    }

    public function dataTable()
    { 
    	$model = Admin::where('role','!=','admin');
    	return DataTables::eloquent($model)
                ->addColumn('post_count', function(Admin $author) {
                    return $author->posts->count().' bài viết';
                })
                ->addColumn('action', '
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#show-delete">
                    	<i class="fa fa-trash" aria-hidden="true"></i> Xoá
                    </button>')
                ->make(true);
    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$author = Admin::find($request->input('id'));
    		if($author->delete()){
    			return 'ok';
    		} else return 'Không thể xóa.';
    	} else return 'err';
    }
}
