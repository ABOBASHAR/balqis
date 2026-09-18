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
                تعديل المنتج
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('dashboard.pages.products._form')
                <button type="submit" class="btn btn-primary">حفظ المنتج</button>
            </form>
        </div>
    </div>
@endsection
