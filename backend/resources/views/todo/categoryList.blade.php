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
                   <h5>カテゴリーリスト</h5>
                   <table class="table table-striped" style="max-width:400px;">
                        @foreach($categories as $category)
                        @if($category->id === 1)
                        @else
                        <tr>
                            <div class="form-group col-8">
                                <form method="POST" action="/todos/category/del/{{$category->id}}" enctype="multipart/form-data">
                                    @csrf
                                    <td style="vertical-align: middle">
                                        <p class="lead" style="margin-bottom:0;">{{$category->category}}</p>
                                    </td>
                                    {{-- <input type="hidden" value="{{$category->id}}"> --}}
                                    <td style="text-align: right">
                                        <button type="submit" name="delCategory" class="btn btn-danger">削除</button>
                                    </td>
                                </form>
                            </div>
                        </tr>
                        @endif
                        @endforeach
                    </table>
                    <hr>
                    <form method="POST" action="/todos/category" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-8">
                            <h5>カテゴリー登録</h5>
                            <label for="category" class="control-label">カテゴリー名<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label><br>
                            <input class="form-control" name="category" type="text" value="" style="max-width:400px;">
                            <button class="btn btn-success" type="submit" style="margin-top: 10px">登録</button>
                        </div>
                        <hr>
                    </form>

                    <a href="{{ route('todo.index') }}" class="btn btn-info">戻る</a>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
@endsection