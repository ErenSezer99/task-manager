@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Ana Sayfa</h1>
    <h5 class="mb-4">Hoş geldin, {{ auth()->user()->name }}!</h5>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Toplam Görevler</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $totalTasks }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Tamamlanan Görevler</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $completedTasks }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Devam Eden Görevler</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $inProgressTasks }}</h2>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('tasks.index') }}" class="btn btn-primary">Görevleri Listele</a>
</div>
@endsection