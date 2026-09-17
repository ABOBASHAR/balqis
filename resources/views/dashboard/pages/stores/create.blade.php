@extends('layouts.dashboard.index')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-plus ml-2"></i>
                إضافة متجر جديد
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.stores.store') }}" method="POST">
                @csrf
                @include('dashboard.pages.stores._form')
                <button type="submit" class="btn btn-primary">حفظ المتجر</button>
            </form>
        </div>
    </div>
@endsection
