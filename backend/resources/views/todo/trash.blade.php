@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header "><p class="h5">ゴミ箱</p></div>
			<div class="card-body">
				<table class="table">
                    <thead>
                        <tr>
                            <th>
                                <a href="/todos" class="btn btn-outline-success">Top <i class="fa-solid fa-house"></i></a>
                            </th>
                            <th>
                                @sortablelink('created_at', '作成日')
                                @sortablelink('updated_at', '更新順')
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
                                <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}" style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}</a></td>
                                <td>{{$todo->category}}</td>
                                <td><span class="label {{$todo->status_class}}">{{$todo->status_label}}</span></td>
                                <td>
                                    <span class="">{{$todo -> due_date}}</span>
                                </td>
                                <td>
                                    <span>{{$todo->user_name}}</span>
                                </td>
                                <td>
                                    <img src="{{Storage::url($todo->sample_path)}}" alt="" width="" height="100px">
                                </td>
                                <td class="child{{$todo->id}}">
                                    <form action="{{ route('todo.restore', ['id'=>$todo->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success" name="del-btn">復元</button>
                                    </form>
                                </td>
                                <td class="child{{$todo->id}}">
                                    <form action="{{ route('todo.destroy', ['id'=>$todo->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" name="del-btn" onclick='return confirm("削除しますか？");'>削除</button>
                                    </form>
                                </td>
                            </tr>
                        @else
                        <tr id="parent-{{$todo->id}}">
                            <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}" style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}</a></td>
                            <td>{{$todo->category}}</td>
                            <td><span class="label {{$todo->status_class}}">{{$todo->status_label}}</span></td>
                            <td>
                                <span class="">{{$todo -> due_date}}</span>
                            </td>
                            <td>
                                <span>{{$todo->user_name}}</span>
                            </td>
                            <td>
                                <img src="{{Storage::url($todo->sample_path)}}" alt="" width="" height="100px">
                            </td>
                            <td class="child{{$todo->id}}">
                                <form action="{{ route('todo.restore', ['id'=>$todo->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success" name="del-btn">復元</button>
                                </form>
                            </td>
                            <td class="child{{$todo->id}}">
                                <form action="{{ route('todo.destroy', ['id'=>$todo->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" name="del-btn" onclick='return confirm("削除しますか？");'>削除</button>
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