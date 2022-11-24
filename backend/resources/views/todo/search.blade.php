@extends("layouts.app")
@section("content")
<div class="row">
    <div class="col-10 m-auto">
        <div class="card">
            <div class="card-header "><p class="h5">検索</p></div>
			<div class="card-body">
				<table class="table">
                    <thead>
                        <tr>
                            <th>
                                <a href="/todos/create" class="btn btn-outline-success">新規タスク作成</a>
                                <a href="/todos/category" class="btn btn-outline-primary">カテゴリー</a>
                                <a href="/todos/search" class="btn btn-outline-info">検索</a>
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
                           
                            <th>担当者</th>
                            <th>画像</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="parent-body">
                    </tbody>
                </table>
			</div>
        </div>
    </div>
</div>
@endsection