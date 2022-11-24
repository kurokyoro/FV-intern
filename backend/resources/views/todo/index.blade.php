@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header "><p class="h5">{{ Auth::user()->name }}のTodo一覧</p></div>
			<div class="card-body">
				<table class="table">
                    <thead>
                        <tr>
                            <th>
                                <form action="" method="GET">
                                    <div style="display: flex; ">
                                        <input name="keyword" class="form-control" type="text" style="width: 50%" placeholder="{{$keyword}}">
                                        <button type="submit" class="btn" style="border: 1.5px #ced4da solid;background-color:#f8fafc;">タスク検索</button>
                                        <button type="submit" class="btn" style="border: 1.5px #ced4da solid;background-color:#f8fafc;">クリア</button>
                                    </div>
                                    </form>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <a href="/todos/create" class="btn btn-outline-success">新規タスク作成</a>
                            </th>
                            <th>
                                @sortablelink('created_at', '作成日')
                            </th>
                            <th>
                                @sortablelink('updated_at', '更新順')
                            </th>
                            <th>
                                {{-- <form method="GET">
                                    <select name="status" id="" class="form-select">
                                        <option value="1">未着手</option>
                                        <option value="2">完了</option>
                                    </select>
                                    <button type="submit" class="btn btn-light">絞込</button>
                                </form> --}}
                            </th>
                            <th>
                                <form action="todos/category/del" method="GET">
                                    <button type="submit" class="btn btn-outline-primary">
                                        カテゴリー
                                    </button>
                                </form>
                            </th>
                            {{-- <th>
                                <form action="/todos/category" method="GET">
                                    <button type="submit" class="btn btn-success">
                                        カテゴリー登録
                                    </button>
                                </form>
                            </th> --}}
                            <th>
                                
                                <form action="" method="GET">
                                    <div style="display: flex;">
                                        <select name="status" id="" class="form-select" style="width: 35%;">
                                            <option value="" disabled selected style="display: none">ステータス</option>
                                            <option value="1">未着手</option>
                                            <option value="2">完了</option>
                                        </select>
                                        <select name="category" id="" class="form-select" style="width:35%;">
                                            <option value="" disabled selected style="display: none">カテゴリー</option>
                                            <option value="0">すべて表示</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn" style="border: 1.5px #ced4da solid;background-color:#f8fafc;">絞り込み</button>
                                    </div>
                                </form>
                            </th>
                        </tr>
                    </thead>
                </table>
				<table class="table">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>タスク名</th>
                            <th>カテゴリー</th>
                            <th>@sortablelink('status_flag', 'ステータス')</th> 
                            <th>完了ボタン</th>
                            <th>@sortablelink('due_date', '期日')</th>
                            <th>担当者</th>
                            <th>画像</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="parent-body">
                        @foreach($todos as $todo)
                        @if($datetime > $todo->due_date)
                            <tr id="parent-{{$todo->id}}" style="background-color: #ffe3e6">
                                {{-- <td class="child{{$todo->id}}">{{ $todo->id }}</td> --}}
                                <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}"style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}</a></td>
                                <td>{{$todo->category}}</td>
                                <td><span class="label {{$todo->status_class}}">{{$todo->status_label}}</span></td>
                                <td>
                                    @if($todo->status_flag === 1)
                                    <form action="{{route ('todo.status', ['id' => $todo->id])}}" method="GET">
                                        @csrf
                                        <button class="btn btn-outline-danger">完了にする</button>
                                    </form>
                                    @else
                                    @endif
                                </td>
                                <td>
                                    <span class="">{{$todo -> due_date}}</span>
                                </td>
                                <td>
                                    <span>{{$todo->user_name}}</span>
                                </td>
                                <td>
                                    <img src="{{Storage::url($todo->sample_path)}}" alt="" width="" height="100px">
                                </td>
                                <td class="child{{$todo->id}}"><a class="btn btn-success" href="/todos/edit/{{$todo->id}}" id="edit-button-{{$todo->id}}">編集</a></td>
                                <td class="child{{$todo->id}}">
                                    <form action="{{ route('todo.delete', ['id'=>$todo->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" name="del-btn">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @else
                            <tr id="parent-{{$todo->id}}">
                                {{-- <td class="child{{$todo->id}}">{{ $todo->id }}</td> --}}
                                <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}" style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}</a></td>
                                <td>{{$todo->category}}</td>
                                <td><span class="label {{$todo->status_class}}">{{$todo->status_label}}</span></td>
                                <td>
                                    @if($todo->status_flag === 1)
                                    <form action="{{ route('todo.status', ['id'=>$todo->id]) }}" method="GET">
                                        @csrf
                                        <button class="btn btn-outline-danger" type="submit">完了にする</button>
                                    </form>
                                    @else
                                    @endif
                                </td>
                                <td>
                                    <span class="">{{$todo -> due_date}}</span>
                                </td>
                                <td>
                                    <span>{{$todo->user_name}}</span>
                                </td>
                                <td>
                                    <img src="{{Storage::url($todo->sample_path)}}" alt="" width="" height="100px">
                                </td>
                                <td class="child{{$todo->id}}"><a class="btn btn-success" href="/todos/edit/{{$todo->id}}" id="edit-button-{{$todo->id}}">編集</a></td>
                                <td class="child{{$todo->id}}">
                                    <form action="{{ route('todo.delete', ['id'=>$todo->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" name="del-btn">削除</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>
@endsection