@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Görevi Düzenle</h1>

    <!-- Hata Mesajları -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Görev Düzenleme Formu -->
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Başlık</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Açıklama</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Öncelik</label>
            <select class="form-control" id="priority" name="priority" required>
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Düşük</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Orta</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Yüksek</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Bitiş Tarihi</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}">
        </div>

        <button type="submit" class="btn btn-success">Güncelle</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection
