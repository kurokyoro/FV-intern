@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header">登録画面</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                <form method="POST" action="/todos/create" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-8">
                        <label for="title" class="control-label">タスク名<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <input class="form-control" name="title" type="text" value="{{ old("title")}}">
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="category" class="control-label">カテゴリー<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <select name="category" id="" class="form-select">
                            <option value="" disabled selected style="display: none">--選択してください--</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->category}}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="du_date" class="control-label">期日<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <input class="form-control" name="due_date" type="date" value="{{ old("due_date")}}">
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="charge" class="control-label">担当者<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <select name="assign" id="" class="form-select">
                            <option value="" disabled selected style="display: none">--選択してください--</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="image" class="control-label">画像</label><br>
                        <input class="form-control" name="image" type="file" value="{{ old("image")}}" accept="image/jpeg,image/png">
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