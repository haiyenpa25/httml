@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <!-- Content Header (Page header) -->
  <div class="row">
    <div class="col-md-6">
    <div class="card card-outline card-primary">
      <div class="card-header">
      <h3 class="card-title">Primary Outline</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-minus"></i>
        </button>
      </div>
      <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
      The body of the card
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
    <div class="card card-outline card-success">
      <div class="card-header">
      <h3 class="card-title">Success Outline</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
        </button>
      </div>
      <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
      The body of the card
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
  </div>

@endsection