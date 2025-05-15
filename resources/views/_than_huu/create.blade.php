@extends('layouts.app')
@section('title', 'Thêm Thân Hữu')

@section('content')
<section class="content-header">
    <h1>Thêm Thân Hữu</h1>
</section>
<section class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('_than_huu.store') }}" method="POST">
                @csrf
                @include('_than_huu.form', ['tinHuus' => \App\Models\TinHuu::orderBy('ho_ten')->get()])
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('_than_huu.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection