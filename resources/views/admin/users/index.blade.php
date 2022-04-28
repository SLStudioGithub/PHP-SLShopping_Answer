@extends('admin::index')
@section('title', '利用者一覧')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/users/index.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>利用者<small>一覧</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box grid-box">
                <div class="box-header with-border">
                    <form method="get" action="{{ route('admin.users.index') }}">
                        <div class="form-group search-form-box">
                            <label for="user-email">メールアドレス</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="user-email" 
                                name="email"
                                value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}"
                                placeholder="メールアドレス">
                        </div>
                        <div class="form-group search-form-box">
                            <label for="user-name">名前</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="user-name" 
                                name="name"
                                value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}"
                                placeholder="名前">
                        </div>
                        <div class="form-group search-form-box">
                            <label for="user-nickname">ニックネーム</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="user-nickname" 
                                name="nickname"
                                value="{{ isset($_GET['nickname']) ? $_GET['nickname'] : '' }}"
                                placeholder="ニックネーム">
                        </div>
                        <div class="form-group search-form-box">
                            <label for="user-gender">性別</label>
                            <div class="form-check">
                                @foreach ($genders as $key => $gender)
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="{{ "gender{$key}" }}"
                                        name="genders[]"
                                        value="{{ $key }}"
                                        {{ isset($_GET['genders']) && in_array($key, $_GET['genders']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ "gender{$key}" }}">{{ $gender }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group search-form-box">
                            <label for="birthday-from">誕生日(From)</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="birthday-from" 
                                name="birthdayFrom"
                                value="{{ isset($_GET['birthdayFrom']) ? $_GET['birthdayFrom'] : '' }}"
                                placeholder="誕生日(From)"
                                autocomplete="off">
                        </div>
                        <span>~</span>
                        <div class="form-group search-form-box">
                            <label for="birthday-to">誕生日(To)</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="birthday-to" 
                                name="birthdayTo"
                                value="{{ isset($_GET['birthdayTo']) ? $_GET['birthdayTo'] : '' }}"
                                placeholder="誕生日(To)"
                                autocomplete="off">
                        </div>
                        <div class="search-buttons">
                            <a class="btn btn-default" href="{{ route('admin.users.index') }}" role="button">リセット</a>
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover grid-table">
                        <thead>
                            <tr>
                                <th>名前</th>
                                <th>ニックネーム</th>
                                <th>メールアドレス</th>
                                <th>誕生日</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->detail->nickname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->detail->birthday->toDateString() }}</td>
                                    <td><a href="{{ route('admin.users.detail', ['id' => $user->id]) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{ $users->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('admin/js/users/index.js') }}"></script>
@endsection
