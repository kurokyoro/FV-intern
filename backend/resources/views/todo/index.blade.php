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
                                <a href="/todos/create" class="btn btn-success">作成</a>
                            </th>
                            <th>
                                <form method="GET" >
                                    <button type="submit" name="sort" value="asc" class="btn btn-success">OLD</button>
                                    <button type="submit" name="sort" value="desc" class="btn btn-primary">NEW</button>
                                </form>
                            </th>
                            <th>
                                <form method="GET">
                                    <button type="submit" name="status" value="1" class="btn btn-success">未着手</button>
                                    <button type="submit" name="status" value="2" class="btn btn-primary">完了</button>
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
                            <th>ステータス</th> 
                            <th>完了ボタン</th>
                            <th>期日</th>
                            <th>担当者</th>
                            <th>画像</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="parent-body">
                        @foreach($todos as $todo)
                            <tr id="parent-{{$todo->id}}">
                                {{-- <td class="child{{$todo->id}}">{{ $todo->id }}</td> --}}
                                <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}">{{ $todo->title}}</td>
                                <td></td>
                                <td><span class="label {{$todo->status_class}}">{{$todo->status_label}}</span></td>
                                <td>
                                    <form action="todos/status/{{$todo->id}}" method="GET">
                                        <button class="btn btn-success">完了にする</button>
                                    </form>
                                </td>
                                <td>
                                    <span class="">{{$todo -> due_date}}</span>
                                </td>
                                <td>
                                    <span>{{$todo -> assign}}</span>
                                </td>
                                <td>
                                    <img src="{{Storage::url($todo->sample_path)}}" alt="" width="" height="100px">
                                </td>
                                <td class="child{{$todo->id}}"><a class="btn btn-success" href="/todos/edit/{{$todo->id}}" id="edit-button-{{$todo->id}}">編集</a></td>
                                <td class="child{{$todo->id}}">
                                    <form action="/todos/del/{{$todo->id}}" method="GET">
                                        <button type="submit" class="btn btn-danger" name="del-btn">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>
@endsection