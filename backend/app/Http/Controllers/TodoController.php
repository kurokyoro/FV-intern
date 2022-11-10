<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //　　usersからid取得 -> taskテーブルのuser_idを条件にタスクの取得
    // タスクの登録時にuser_idを格納
        
        $sort = $request -> get('sort');
        $status = $request -> get('status');

        $user_id = \Auth::id();

        $task = Todo::whereUser_id($user_id);

        $todos = $task -> get();
        if($status === "1"){
            $todos = $task -> where('status_flag', '=', '1') -> get();
        }
        if($status === "2"){
            $todos = $task -> where('status_flag', '=', '2') -> get();
        }
        if($sort === "asc"){
            $todos = $task -> orderby('created_at') -> get();
        }
        if($sort === "desc"){
            $todos = $task -> orderby('created_at','DESC') -> get();
        }
        // if ($sort) {
        //     if($sort === "asc"){
        //         $todos = Todo::whereUser_id($user_id)->orderby('created_at')->get();
        //     }
        //     elseif($sort === "desc"){
        //         $todos = Todo::whereUser_id($user_id)->orderby('created_at','DESC')->get();
        //     }
        // }elseif($status){
        //     if($sort === "1"){
        //         $todos = Todo::whereUser_id($user_id)->where('status_flag', '=', 1)->get();
        //     }
        //     elseif($sort === "2"){
        //         $todos = Todo::whereUser_id($user_id)->where('status_flag', '=', 2)->get();
        //     }
        // }else{
        //     $todos = Todo::whereUser_id($user_id)->get();
        // }
        // if($status){
        //     if($sort === "1"){
        //         $todos = Todo::whereUser_id($user_id)->where('status_flag', '=', 1)->get();
        //     }
        //     elseif($sort === "2"){
        //             $todos = Todo::whereUser_id($user_id)->where('status_flag', '=', 2)->get();
        //     }
        // }
        // dd($todos);

        return view('todo.index',['todos' => $todos]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $category = Category::all();
        // dd($category);
        return view('todo.create',['users'=>$users,'category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_path = $request -> image;
        if($image_path){
            $image_path = $image_path -> store('public/sample');
        }
        else{
            $image_path = "";
        }

        $todo = new Todo();
        $user_id = \Auth::id();
        // formのデータとuseridを入れる
        $param = [
            'title' => $request -> title,
            'user_id' => $user_id,
            'due_date' => $request -> due_date,
            'image_path' => $image_path,
            'assign' => $request -> assign,
            'category' => $request -> category,
        ];
        DB::insert('insert into todos (title,user_id,due_date,sample_path,assign,category) values (:title, :user_id, :due_date, :image_path, :assign, :category)', $param);

        return redirect('todos')->with(
            'success',
            'ID : ' . $todo->id . '「' . $todo->title . '」を登録しました！'
        );
    }


    
    public function edit($id)
    {
        $users = User::all();
        $category = Category::all();
        $todo = DB::table('todos')->find($id);
        return view('todo.edit',['todo'=>$todo,'users'=>$users,'category'=>$category]);
    }


    public function update(Request $request, int $id)
    {
        $task = Todo::find($id);

        // dd($task);

        $task -> title = $request -> title . "【Edited】";
        $task -> due_date = $request -> due_date;
        $task -> assign = $request -> assign;
        $task -> category = $request -> category;
        $image = $request -> image;
        $old_image = $request -> old_image;
        $old_image = substr($old_image,8);
        $old_image = "public" . $old_image;
        // dd($old_image);
        if($image){
            $image = $image -> store('public/sample');
        }else{
            $image = $old_image;
        }
        $task -> sample_path = $image;
        $task -> save();
    
    //   $param = [
    //     'title' => $request -> title . "【Edited】",
    //     'due_date' => $request -> due_date,
    //     'id' => $request -> id,
    //   ];

    // //   dd($param['due_date']);
    
    //   //データベースに保存
    //   DB::update('update todos set title = :title and due_date = :due_date where id = :id',$param);
    
      //リダイレクト
      return redirect('/todos');
    }

    public function check(int $id){

        $todo = DB::table('todos')->find($id);
        return view('todo.check',['todo'=>$todo]);
        
    }

    public function del(Request $request){

        $param = [
            'id' => $request -> id
        ];
        DB::delete('delete from todos where id = :id', $param);
        return redirect('/todos');
        
    }

    public function status_check(int $id){

        $todo = DB::table('todos')->find($id);
        return view('todo.status',['todo'=>$todo]);
        
    }

    public function status_change(Request $request){

        $param = [
            'id' => $request -> id
        ];
        DB::update('update todos set status_flag = 2 where id = :id', $param);
        return redirect('/todos');
        
    }

    public function category(){
        return view('todo.category');
    }

    public function create_category(Request $request){
        $category = $request -> category;
        DB::insert('insert into category (category) values (?)', [$category]);
        return redirect('/todos');
    }

}
