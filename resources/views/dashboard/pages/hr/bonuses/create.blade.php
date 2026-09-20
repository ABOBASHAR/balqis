@extends('layouts.dashboard.index')

@section('title','الموارد البشرية - إنشاء طلب مكافأة')

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
                إنشاء طلب مكافأة جديد
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.hr.bonuses.store') }}" method="POST">
                @csrf
                @method('POST')
                @include('dashboard.pages.hr.bonuses._form')
                <button type="submit" class="btn btn-primary">حفظ طلب المكافأة</button>
            </form>
        </div>
    </div>
@endsection
