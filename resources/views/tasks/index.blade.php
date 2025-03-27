@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Görevlerim</h1>

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
        <div class="row">

            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Tüm Durumlar</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="priority" class="form-control">
                    <option value="">Tüm Öncelikler</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Düşük</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Orta</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Yüksek</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="sort_by" class="form-control">
                    <option value="">Sırala</option>
                    <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>Önceliğe Göre (Çoktan Aza)</option>
                    <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Bitiş Tarihine Göre (Yakından Uzağa)</option>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtrele</button>
            </div>
        </div>
    </form>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2 w-25" placeholder="Başlığa göre ara" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Ara</button>
    </form>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Yeni Görev Oluştur</a>

    <a href="{{ route('tasks.index') }}" class="btn btn-primary mb-3 ms-2">Yenile</a>

    <table class="table">
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>Öncelik</th>
                <th>Bitiş Tarihi</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr id="task-{{ $task->uuid }}">
                <td class="task-title">{{ $task->title }}</td>
                <td class="task-description">{{ $task->description }}</td>
                <td class="task-priority">
                    @if ($task->priority == 'low')
                    Düşük
                    @elseif ($task->priority == 'medium')
                    Orta
                    @elseif ($task->priority == 'high')
                    Yüksek
                    @endif
                </td>

                <td class="task-due_date">{{ $task->due_date }}</td>
                <td class="task-status" id="status-{{ $task->uuid }}">
                    {{ $task->status === 'in_progress' ? 'Devam Ediyor' : 'Tamamlandı' }}
                </td>
                <td>
                    <button class="btn btn-warning btn-sm edit-task" data-uuid="{{ $task->uuid }}" data-title="{{ $task->title }}" data-description="{{ $task->description }}" data-priority="{{ $task->priority }}" data-due_date="{{ $task->due_date }}">Düzenle</button>

                    @if ($task->status === 'in_progress')
                    <button class="btn btn-success btn-sm complete-task" data-uuid="{{ $task->uuid }}">Tamamlandı</button>
                    @endif

                    <button class="btn btn-danger btn-sm delete-task" data-uuid="{{ $task->uuid }}">Sil</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tasks->appends(request()->query())->links() }}
</div>

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Görevi Düzenle</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <input type="hidden" id="edit-task-uuid">
                    <div class="form-group">
                        <label class="mb-1" for="edit-title">Başlık</label>
                        <input type="text" id="edit-title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="edit-description">Açıklama</label>
                        <textarea id="edit-description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="edit-priority">Öncelik</label>
                        <select id="edit-priority" class="form-control">
                            <option value="low">Düşük</option>
                            <option value="medium">Orta</option>
                            <option value="high">Yüksek</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="edit-due_date">Bitiş Tarihi</label>
                        <input type="date" id="edit-due_date" class="form-control" min="{{ date('Y-m-d') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection