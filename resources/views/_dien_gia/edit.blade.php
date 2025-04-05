@extends('layouts.app')
@section('title', 'Chỉnh Sửa Diễn Giả')

@section('content')
<section class="content-header"><h1>Chỉnh Sửa Diễn Giả</h1></section>
<section class="content">
    <form action="{{ route('_dien_gia.update', ['dienGia' => $dienGia->id]) }}" method="POST">

    {{-- <form action="{{ route('_dien_gia.update', $dienGia->id) }}" method="POST"> --}}
        @csrf @method('PUT')
        @include('_dien_gia.form')
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('_dien_gia.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</section>
@endsection
