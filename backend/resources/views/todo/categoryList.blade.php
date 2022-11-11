@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header">カテゴリー一覧</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                {{-- <form method="POST" action="/todos/category/del" enctype="multipart/form-data"> --}}
                   
                    @foreach($categories as $category)
                    <div class="form-group col-8">
                        @if($category->id === 1)
                        @else
                        <form method="POST" action="/todos/category/del/{{$category->id}}" enctype="multipart/form-data">
                            @csrf
                            <label for="category" class="control-label">{{$category->category}}</label><br>
                            {{-- <input type="hidden" value="{{$category->id}}"> --}}
                            <button type="submit" name="delCategory">削除</button>
                        @endif
                    </div>
                    @endforeach
                    <hr>

                    <a href="{{ route('todo.index') }}" class="btn btn-info">戻る</a>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
@endsection