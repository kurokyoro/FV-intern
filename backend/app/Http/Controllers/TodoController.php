<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todos = Todo::all();
        return view('todo.index',['todos' => $todos]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $form = $request -> all();
        unset($form['_token']);

        $todo->fill($form)->save();

        return redirect('todos')->with(
            'success',
            'ID : ' . $todo->id . '「' . $todo->title . '」を登録しました！'
        );
    }


    
    public function edit($id)
    {
        $todo = DB::table('todos')->find($id);
        return view('todo.edit',['todo'=>$todo]);
    }


    public function update(Request $request, int $id)
    {
    
      $param = [
        'title' => $request -> title,
        'id' => $request -> id
      ];

    
      //データベースに保存
      DB::update('update todos set title = :title where id = :id',$param);
    
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

}
