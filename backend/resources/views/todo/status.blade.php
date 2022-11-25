@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header">タスク完了画面</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                <div>
                    <h5 style="color: red;">タスクは完了しましたか？</h5>
                </div>
                <form method="POST" action="/todos/status/{{$todo->id}}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <hr>
                    <td><a href="{{ route('todo.index') }}" class="btn btn-success">一覧に戻る</a></td>
                    <button class="btn btn-danger" type="submit">完了</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection