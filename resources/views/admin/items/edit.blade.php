@extends('admin::index')
@section('title', '商品編集')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/items/edit.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>商品<small>編集</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">編集</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.adminUsers.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ route('admin.items.edit', ['id' => $item->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="asterisk">商品名</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $item->name) }}" 
                                class="form-control"
                                required>
                            @error('name')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="main_image">メイン画像</label>
                            <div class="file-preview-thumbnails">
                                <div class="file-preview-frame krajee-default  kv-preview-thumb">
                                    <div class="kv-file-content">
                                        <img id="preview" src="{{ asset($mainImage->path) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div>
                                <input 
                                    type="file" 
                                    id="main_image"
                                    accept="image/*" 
                                    name="mainImage">
                            </div>
                            @error('mainImage')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="short_description" class="asterisk">省略説明</label>
                            <textarea 
                                type="text" 
                                id="short_description" 
                                name="shortDescription" 
                                class="form-control" 
                                rows="5"
                                required>{{ old('shortDescription', $item->short_description) }}</textarea>
                            @error('shortDescription')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-three-form-box">
                            <label for="price" class="asterisk">金額（円）</label>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                value="{{ old('price', $item->price) }}" 
                                class="form-control"
                                required>
                            @error('price')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-three-form-box">
                            <label for="discount_percent" class="asterisk">割引率（%）</label>
                            <input 
                                type="number" 
                                id="discount_percent" 
                                name="discountPercent" 
                                value="{{ old('discountPercent', $item->discount_percent) }}" 
                                class="form-control"
                                required>
                            @error('discountPercent')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand_id" class="asterisk">ブランド</label>
                            <select class="form-control" id="brand_id" name="brandId">
                                @foreach ($brands as $brand)
                                    <option
                                        value="{{ $brand->id }}"
                                        {{ ((int)old('brandId') === $brand->id || $item->brand->id === $brand->id) ? 'selected' : '' }}
                                    >{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brandId')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category" class="asterisk">カテゴリー</label>
                            <div class="form-check parent-category">
                                @foreach ($categories->get('parents') as $parent)
                                    <label class="form-check-label">{{ $parent->name }}</label>
                                    <div class="form-check child-category">
                                        @foreach ($categories->get('children') as $child)
                                            @if ($child->parent_category_id == $parent->id)
                                                <label class="form-check-label">{{ $child->name }}</label>
                                                <div class="form-check child-category">
                                                    @foreach ($categories->get('grandChildren') as $grandChild)
                                                        @if ($grandChild->parent_category_id == $child->id)
                                                            <input 
                                                                class="form-check-input" 
                                                                type="checkbox" 
                                                                name="categories[]"
                                                                value="{{ $grandChild->id }}"
                                                                @if ($errors->any())
                                                                    {{ is_array(old("categories")) && in_array($grandChild->id, old('categories')) ? 'checked' : '' }}
                                                                @else
                                                                    {{ $item->itemCategories->contains('category_id', $grandChild->id) ? 'checked' : '' }}
                                                                @endif
                                                                >
                                                            <label class="form-check-label">{{ $grandChild->name }}</label>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-four-form-box">
                            <label for="length" class="asterisk">長辺（mm）</label>
                            <input 
                                type="number" 
                                id="length"
                                name="length" 
                                value="{{ $item->itemDetail->length }}" 
                                class="form-control"
                                step="0.1"
                                required>
                            @error('length')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-four-form-box">
                            <label for="width" class="asterisk">短辺（mm）</label>
                            <input 
                                type="number" 
                                id="width" 
                                name="width" 
                                value="{{ $item->itemDetail->width }}" 
                                class="form-control"
                                step="0.1"
                                required>
                            @error('width')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-four-form-box">
                            <label for="height" class="asterisk">高さ（mm）</label>
                            <input 
                                type="number" 
                                id="height" 
                                name="height" 
                                value="{{ $item->itemDetail->height }}" 
                                class="form-control"
                                step="0.1"
                                required>
                            @error('height')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-four-form-box">
                            <label for="weight" class="asterisk">重量（kg）</label>
                            <input 
                                type="number" 
                                id="weight" 
                                name="weight" 
                                value="{{ $item->itemDetail->weight }}" 
                                class="form-control"
                                step="0.1"
                                required>
                            @error('weight')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="full_description" class="asterisk">完全説明</label>
                            <textarea 
                                type="text" 
                                id="full_description" 
                                name="fullDescription" 
                                class="form-control" 
                                rows="10"
                                required>{{ $item->itemDetail->full_description }}</textarea>
                            @error('fullDescription')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="button" class="btn btn-light" onClick="history.back()">戻る</button>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary">編集</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('admin/js/items/create.js') }}"></script>
@endsection
