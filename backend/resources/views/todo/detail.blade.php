@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header">タスク詳細</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                    <div class="form-group col-8">
                        <label for="title" class="control-label">タスク名</label><br>
                        <p class="" style="font-size: 18px">{{$todo->title}}</p>
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="category" class="control-label">カテゴリー<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <p class="" style="font-size: 18px">{{$todo->category}}</p>
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="du_date" class="control-label">期日<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <p class="" style="font-size: 18px">{{$todo->due_date}}</p>
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="charge" class="control-label">担当者<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                        <p class="" style="font-size: 18px">{{$todo->user_name}}</p>
                    </div>
                    <hr>
                    <div class="form-group col-8">
                        <label for="image" class="control-label">画像</label><br>
                        <img src="{{Storage::url($todo->sample_path)}}" alt="陽気なオウム" width="300px">
                    </div>
                    <hr>
                    <label for="comment" class="control-label">コメント</label><br>
                    @foreach($comments as $comment)
                    <p style="margin:0 0 0 10px;font-size:16px;">{{$comment->comment}}</p>
                    @endforeach
                    <form action="/todos/{{$todo->id}}/comment" method="POST">
                        @csrf
                        <input type="text" class="form-control" name="comment">
                        <button type="submit" class="btn btn-success" name="posts" style="margin-top: 5px;">投稿</button>
                    </form>
                    <hr>
                    <a href="{{ route('todo.index') }}" class="btn btn-info">戻る</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection