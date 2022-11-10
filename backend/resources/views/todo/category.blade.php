@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header">カテゴリー登録画面</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                <form method="POST" action="/todos/category" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-8">
                        <label for="category" class="control-label">カテゴリー名<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <input class="form-control" name="category" type="text" value="">
                    </div>
                    <hr>
                    <button class="btn btn-success" type="submit">登録</button>
                    <a href="{{ route('todo.index') }}" class="btn btn-info">戻る</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection