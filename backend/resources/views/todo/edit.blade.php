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
                    {{-- <div class="form-group">
                        <label for="id" class="control-lavel">ID</label>
                        <div>{{$todo->id}}</div>
                    </div> --}}
                    {{-- <hr> --}}
                    <div class="form-group">
                        <label for="title" class="control-label">タスク名<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                        <input class="form-control" name="title" type="text" value="{{ $todo->title }}">
                    </div>
                    
                    <hr>
                    <div class="form-group">
                        <label for="category" class="control-label">カテゴリー<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                        <select name="category" id="" class="form-control" required>
                            <option value="" disabled selected style="display: none">--選択してください--</option>
                            @foreach($category as $category)
                                <option value="{{$category->category}}">{{$category->category}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <hr>
                    <div class="form-group">
                        <label for="due_date" class="control-label">期日<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                        <input class="form-control" name="due_date" type="date" value="{{ $todo->due_date }}">
                    </div>
                    
                    <hr>
                    <div class="form-group">
                        <label for="assign" class="control-label">担当者<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                        <select name="assign" id="" class="form-control" required >
                            <option value="" disabled selected style="display: none">--選択してください--</option>
                            @foreach($users as $user)
                                <option value="{{$user->name}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <hr>
                    <div class="form-group">
                        <label for="image" class="control-label">画像<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
                        <input class="form-control" name="image" type="file" value="">
                        <input type="hidden" name="old_image" type="text" value="{{ Storage::url($todo->sample_path) }}">
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