@extends('admin::index')
@section('title', '利用者詳細')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/users/detail.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>利用者<small>詳細</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">詳細</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="" class="btn btn-sm btn-primary" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;配送先情報一覧</span></a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.users.orders', ['id' => $user->id]) }}" class="btn btn-sm btn-primary" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;注文履歴</span></a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text" id="id" value="{{ $user->id }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">名前</label>
                        <input type="text" id="name" value="{{ $user->name }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nickname">ニックネーム</label>
                        <input type="text" id="nickname" value="{{ $user->detail->nickname }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="text" id="email" value="{{ $user->email }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="birthday">誕生日</label>
                        <input type="text" id="birthday" value="{{ $user->detail->birthday->toDateString() }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gender">性別</label>
                        <input type="text" id="gender" value="{{ $genders[$user->detail->gender] }}" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
