<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DateTime;


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
        $datetime = new DateTime();
        $datetime = $datetime -> format('Y-m-d');
        // dd($datetime);
        $sort = $request -> get('sort');
        $status = $request -> get('status');
        $category = $request -> get('category');
        $categories = Category::all();
        $user_id = \Auth::id();

         // キーワード取得
        $keyword = $request->input('keyword', ''); // デフォルトは空文字

        //キーワード検索
        // $posts = Post::where('title', 'LIKE' , "%{$keyword}%")->get()->all();

        $task = Todo::select('todos.id','todos.title','todos.created_at','todos.updated_at','todos.status_flag','todos.user_id','todos.due_date','todos.sample_path','todos.assign_id','category.category','todos.category_id','users.name as user_name')
                    ->join('users', 'todos.assign_id', '=', 'users.id')
                    ->join('category', 'todos.category_id', '=', 'category.id')
                    ->where('title', 'LIKE', "%{$keyword}%");

        $todos = $task -> get();
        // dd($todos);
        if($status === "1"){
            $todos = $task -> where('status_flag', '=', '1') -> get();
            // $todos = Todo::whereUser_id($user_id) -> where('status_flag', '=', '1') -> get();
            
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
        if($category){
            if($category === "0"){
                $todos = $task -> get();
            }
            else{
                $todos = $task -> where('category_id', '=', $category) -> get();
            }
        }

        return view('todo.index',['todos' => $todos,'categories' => $categories,'datetime'=>$datetime,'keyword'=>$keyword]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        // dd($category);
        return view('todo.create',['users'=>$users,'categories'=>$categories]);
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
        DB::insert('insert into todos (title,user_id,due_date,sample_path,assign_id,category_id) values (:title, :user_id, :due_date, :image_path, :assign, :category)', $param);

        return redirect('todos')->with(
            'success',
            'ID : ' . $todo->id . '「' . $todo->title . '」を登録しました！'
        );
    }


    
    public function edit($id)
    {
        $users = User::all();
        $categories = Category::all();
        $todo = DB::table('todos')->find($id);
        return view('todo.edit',['todo'=>$todo,'users'=>$users,'categories'=>$categories]);
    }


    public function update(Request $request, int $id)
    {
        $task = Todo::find($id);

        // dd($task);

        $task -> title = $request -> title . "【Edited】";
        $task -> due_date = $request -> due_date;
        $task -> assign_id = $request -> assign;
        $task -> category_id = $request -> category;
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
