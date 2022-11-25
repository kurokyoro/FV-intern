<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Mail\AssignMail;
use App\Mail\ChangeMail;
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
        $datetime = new DateTime();
        $datetime = $datetime -> format('Y-m-d');
        $sort = $request -> get('sort');
        $status = $request -> get('status');
        $category = $request -> get('category');
        $categories = Category::all();
        $user_id = \Auth::id();
        $keyword = $request->input('keyword', '');

        $task = Todo::select('todos.id','todos.title','todos.created_at','todos.updated_at','todos.status_flag','todos.user_id','todos.due_date','todos.sample_path','todos.assign_id','category.category','todos.category_id','users.name as user_name')
                    ->sortable()
                    ->join('users', 'todos.assign_id', '=', 'users.id')
                    ->join('category', 'todos.category_id', '=', 'category.id')
                    ->where('title', 'LIKE', "%{$keyword}%");
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

        $user_id = $request -> assign;
        $user = DB::table('users')->select('name', 'email')->find($user_id);
        $name = $user -> name;
        $email = $user -> email;
        Mail::send(new AssignMail($name, $email));

        $todo = new Todo();
        $user_id = \Auth::id();
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
        $old_category = Category::select('category')->where('id','=',$todo->category_id)->first();
        $old_assign = User::select('name')->where('id','=',$todo->assign_id)->first();
        return view('todo.edit',['todo'=>$todo,'users'=>$users,'categories'=>$categories,'old_category'=>$old_category,'old_assign'=>$old_assign]);
    }

    public function update(Request $request, int $id)
    {
        $task = Todo::find($id);
        $user_id = $task -> assign_id;
        $task -> title = $request -> title;
        $task -> due_date = $request -> due_date;
        $task -> assign_id = $request -> assign;
        $task -> category_id = $request -> category;
        $image = $request -> image;
        $old_image = $request -> old_image;
        $old_image = substr($old_image,8);
        if($old_image !== '/'){
            $old_image = "public" . $old_image;
        }
        else{
            $old_image = "";
        }
        $user_id_edited = $task -> assign_id;
        if($user_id == $user_id_edited){
            $user = DB::table('users')->select('name', 'email')->find($user_id);
            $name = $user -> name;
            $email = $user -> email;
            Mail::send(new TestMail($name, $email));
        }
        else{
            $user = DB::table('users')->select('name', 'email')->find($user_id);
            $name = $user -> name;
            $email = $user -> email;
            Mail::send(new ChangeMail($name, $email));
            $user = DB::table('users')->select('name', 'email')->find($user_id_edited);
            $name = $user -> name;
            $email = $user -> email;
            Mail::send(new AssignMail($name, $email));
        }

        if($image){
            $image = $image -> store('public/sample');
        }else{
            $image = $old_image;
        }
        $task -> sample_path = $image;
        $task -> save();
        return redirect('/todos');
    }

    public function del(int $id){
        Todo::find($id)->delete();
        return redirect()->to('/todos');
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

    public function detail($id, Request $request){
        $posts = $request -> get('posts'); 
        $task = Todo::select('todos.id','todos.title','todos.status_flag','todos.due_date','todos.sample_path','category.category','users.name as user_name')
        ->join('users', 'todos.assign_id', '=', 'users.id')
        ->join('category', 'todos.category_id', '=', 'category.id')
        ->where('todos.id', '=', $id)
        ->first();
        $comments = Comment::select('comment.comment')
        ->join('todos', 'comment.todo_id', '=', 'todos.id')
        ->get();
        return view('todo.detail',['todo'=>$task,'comments'=>$comments]);
    }

    public function insertComment($id,Request $request){
        $task_id = $id;
        $param = [
            'comment' => $request -> comment,
            'todo_id' => $task_id,
        ];
        DB::insert('insert into comment (comment, todo_id) values (:comment, :todo_id)', $param);
        return redirect('/todos');
    }

    public function categoryList(){
        $categories = Category::all();
        return view('todo.categoryList',['categories'=>$categories]);
    }

    public function delCategory($id,Request $request){
        $category_id = $id;
        DB::update('update todos set category_id = 1 where category_id = ?', [$category_id]);
        DB::delete('delete from category where id = ?', [$category_id]);
        return redirect('/todos');
    }

    public function result(Request $request){
        $id = Auth::id();
        $keyword = $request -> keyword;
        $status = $request -> status;
        $assign = $request -> assign;
        $category = $request -> category;
        $due_date = $request -> due_date;
        $datetime = new DateTime();
        $datetime = $datetime -> format('Y-m-d');
        $users = User::all();
        $categories = Category::all();
         
        $query = Todo::query()->sortable();
        $query->join('users', function ($query) use ($request) {
            $query->on('todos.assign_id', '=', 'users.id');
            });
        $query->join('category', function ($query) use ($request) {
            $query->on('todos.category_id', '=', 'category.id');
            });
        $query = $query->where('todos.user_id','=',$id);

        if ($keyword) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach($wordArraySearched as $value) {
                $query->where('title', 'like', '%'.$value.'%');
            }
        }
        if($status != 0){
            $query->where('status_flag','=',$status);
        }
        if($assign != 0){
            $query->where('assign_id','=',$assign);
        }
        if($category != 0){
            $query->where('category_id','=',$category);
        }
        if($due_date != 0){
            if($due_date == 1){
                $query->where('due_date','>=',$datetime);
            }
            else{
                $query->where('due_date','<',$datetime);
            }
        }
        $hash = $query->get();
        return view('todo.search',['todos'=>$hash,'datetime'=>$datetime,'users'=>$users,'categories'=>$categories]);
    }

    public function trash(){
        $id = Auth::id();
        $datetime = new DateTime();
        $datetime = $datetime -> format('Y-m-d');
        $todo = Todo::onlyTrashed()
            ->select('todos.id','todos.title','todos.created_at','todos.updated_at','todos.status_flag','todos.user_id','todos.due_date','todos.sample_path','todos.assign_id','category.category','todos.category_id','users.name as user_name')
            ->sortable()
            ->join('users', 'todos.assign_id', '=', 'users.id')
            ->join('category', 'todos.category_id', '=', 'category.id')
            ->get();
        return view('todo.trash',['todos'=>$todo,'datetime'=>$datetime]);
    }

    public function destroy(int $id){
        Todo::onlyTrashed()->find($id)->forceDelete();
        return redirect()->route('todo.trash');
    }

    public function restore(int $id){
        Todo::onlyTrashed()->find($id)->restore();
        return redirect()->route('todo.trash');
    }

}
