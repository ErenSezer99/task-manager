<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Kullanıcının kendi görevlerini filtrele
        $query = Task::where('user_id', Auth::id());

        // Arama filtresi (Başlığa göre)
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Durum filtresi (Devam Ediyor veya Tamamlandı)
        if ($request->has('status') && in_array($request->status, ['in_progress', 'completed'])) {
            $query->where('status', $request->status);
        }

        // Öncelik filtresi
        if ($request->has('priority') && in_array($request->priority, ['low', 'medium', 'high'])) {
            $query->where('priority', $request->priority);
        }

        // Sıralama işlemi
        if ($request->has('sort_by')) {
            $sortBy = $request->sort_by;

            if ($sortBy === 'priority') {
                $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
            } elseif ($sortBy === 'status') {
                $query->orderByRaw("FIELD(status, 'in_progress', 'completed')");
            } elseif ($sortBy === 'due_date') {
                $query->orderBy('due_date', 'asc');
            }
        }

        $tasks = $query->paginate(5)->appends($request->query());

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function destroy($uuid)
    {
        $task = Task::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();
        $task->delete();

        return response()->json(['success' => true, 'message' => 'Görev başarıyla silindi!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:today',
        ], [
            'due_date.after_or_equal' => 'Bitiş tarihi bugünden önce olamaz.',
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'status' => 'in_progress',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Görev başarıyla oluşturuldu.');
    }

    public function markAsCompleted($uuid)
    {
        $task = Task::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();
        $task->status = 'completed';
        $task->save();

        return response()->json(['success' => true, 'message' => 'Görev tamamlandı olarak işaretlendi.']);
    }

    public function edit($uuid)
    {
        $task = Task::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:today',
        ], [
            'due_date.after_or_equal' => 'Bitiş tarihi bugünden önce olamaz.',
        ]);

        $task = Task::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Görev başarıyla güncellendi!',
            'task' => [
                'uuid' => $task->uuid,
                'title' => e($task->title),
                'description' => e($task->description),
                'priority' => $task->priority,
                'due_date' => $task->due_date,
            ]
        ]);
    }
}
