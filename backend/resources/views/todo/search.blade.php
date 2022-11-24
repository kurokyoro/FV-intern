@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header "><p class="h5">検索</p></div>
			<div class="card-body">
                <tr>
                    <th>
                        <a href="/todos" class="btn btn-outline-success">Top <i class="fa-solid fa-house"></i></a>
                    </th>
                </tr>
				<div class="card" style="margin-top: 10px;">
                    <div class="card-body">
                        <form action="{{ route('todo.result', ['id'=>Auth::id()]) }}" method="GET">
                        <label for="">キーワード</label>
                        <input type="text" class="form-control" name="keyword">
                        <label for="">ステータス</label>
                        <select name="status" id="" class="form-select">
                            <option value="">指定なし</option>
                            <option value="">未着手</option>
                            <option value="">完了</option>
                        </select>
                        <label for="">担当者</label>
                        <select name="assign" id="" class="form-select">
                            <option value="">指定なし</option>
                            <option value="">aaa</option>
                        </select>
                        <label for="due_date">期日</label>
                        <select name="" id="" class="form-select">
                            <option value="">指定なし</option>
                        </select>
                        <div style="width:100%;text-align:center;">
                            <button type="submit" class="btn btn-success" style="margin-top:10px;">検索</button>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card" style="margin-top: 10px">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
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
                                        @if($todo->created_at == $todo->updated_at)
                                        <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}"style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}</a></td>
                                        @else
                                        <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}"style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}【Edited】</a></td>
                                        @endif
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
                                        @if($todo->created_at == $todo->updated_at)
                                        <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}" style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}</a></td>
                                        @else
                                        <td class="child{{$todo->id}}" id="child-title-{{$todo->id}}"><a href="/todos/task/{{$todo->id}}" style="color: black;text-decoration:none;" onMouseOver="this.style.color='#277fff'" onMouseOut="this.style.color='black'">{{ $todo->title}}【Edited】</a></td>
                                        @endif
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
    </div>
</div>
@endsection

{{-- 
    キーワード
    ステータス
    担当者
    期日
     --}}