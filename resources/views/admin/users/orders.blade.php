@extends('admin::index')
@section('title', '注文履歴')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/users/orders.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>利用者名<small>注文履歴</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box grid-box">
                <div class="box-header with-border">
                    <div class="btn-group pull-left" style="margin-left: 5px">
                        <a href="{{ route('admin.users.detail', ['id' => 1]) }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-user"></i><span class="hidden-xs">&nbsp;利用者詳細に戻る</span></a>
                    </div>
                </div>
                <div class="box-header with-border">
                    <form method="get" action="{{ route('admin.users.orders', ['id' => $user->id]) }}">
                        <div class="form-group search-form-box">
                            <label for="order-day-from">注文日(from)</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="order-day-from" 
                                name="orderDateFrom"
                                value="{{ isset($_GET['orderDateFrom']) ? $_GET['orderDateFrom'] : '' }}"
                                placeholder="注文日"
                                autocomplete="off">
                        </div>
                        <span>~</span>
                        <div class="form-group search-form-box">
                            <label for="order-day-to">注文日(to)</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="order-day-to" 
                                name="orderDateTo"
                                value="{{ isset($_GET['orderDateTo']) ? $_GET['orderDateTo'] : '' }}"
                                placeholder="注文日"
                                autocomplete="off">
                        </div>
                        <div class="form-group search-form-box">
                            <label for="order-status">注文状況</label>
                            <div class="form-check">
                                @foreach ($statuses as $key => $status)
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="{{ "order-status-{$key}" }}"
                                        name="statuses[]"
                                        {{ isset($_GET['statuses']) && in_array($key, $_GET['statuses']) ? 'checked' : '' }}  value="{{ $key }}"
                                        >
                                    <label class="form-check-label" for="{{ "order-status-{$key}" }}">{{ $status }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="search-buttons">
                            <a class="btn btn-default" href="{{ route('admin.users.orders', ['id' => $user->id]) }}" role="button">リセット</a>
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover grid-table">
                        <thead>
                            <tr>
                                <th>注文日</th>
                                <th>注文状況</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_date->toDateString() }}</td>
                                    <td>{{ $statuses[$order->status] }}</td>
                                    <td><a href="" class="btn btn-primary btn-sm">詳細</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{ $orders->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('admin/js/users/orders.js') }}"></script>
@endsection
