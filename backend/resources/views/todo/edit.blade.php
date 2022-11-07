@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header">タスク編集画面</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                <form method="POST" action="/todos/edit/{{$todo->id}}" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="id" class="control-lavel">ID</label>
                        <div>id</div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="title" class="control-label">タスク名<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                        <input class="form-control" name="title" type="text" value="{{ $todo->title }}">
                    </div>
                    
                    <hr>
                    <td><a href="{{ route('todo.index') }}" class="btn btn-success">一覧に戻る</a></td>
                    <button class="btn btn-primary" type="submit">更新</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection