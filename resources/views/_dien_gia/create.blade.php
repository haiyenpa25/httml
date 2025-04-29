@extends('layouts.app')
@section('title', 'Thêm Diễn Giả')

@section('content')
<section class="content-header"><h1>Thêm Diễn Giả</h1></section>
<section class="content">
    <form action="{{ route('_dien_gia.store') }}" method="POST">
        @csrf
        @include('_dien_gia.form')
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('_dien_gia.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</section>
@endsection
