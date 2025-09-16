<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ProfessorInvitationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Contadores
        $studentsCount = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'Estudiante');
        })->count();

        $professorsCount = \App\Models\User::whereHas('role', function ($q) {
            $q->where('name', 'Profesor');
        })->count();

        $secundariaCourses = Course::whereHas('category', function ($q) {
            $q->where('name', 'LIKE', '%Secundaria%');
        })->count();

        $preUniversitarioCourses = Course::whereHas('category', function ($q) {
            $q->where('name', 'LIKE', '%Pre-Universitario%');
        })->count();

        $universitarioCourses = Course::whereHas('category', function ($q) {
            $q->where('name', 'LIKE', '%Universitario%');
        })->count();

        return view('admin.dashboard', compact(
            'studentsCount',
            'professorsCount',
            'secundariaCourses',
            'preUniversitarioCourses',
            'universitarioCourses'
        ));
    }

    public function branding()
    {
        // Leer rutas guardadas (si existen)
        $heroImagePath = @file_exists(storage_path('app/branding_hero_image.txt')) ? trim(file_get_contents(storage_path('app/branding_hero_image.txt'))) : null;
        $heroVideoPath = @file_exists(storage_path('app/branding_hero_video.txt')) ? trim(file_get_contents(storage_path('app/branding_hero_video.txt'))) : null;

        return view('admin.branding', compact('heroImagePath', 'heroVideoPath'));
    }

    public function saveBranding(Request $request)
    {
        $request->validate([
            'hero_image' => ['nullable', 'image', 'max:5120'], // 5MB
            'hero_video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'], // 50MB
        ]);

        $savedImage = null;
        $savedVideo = null;

        if ($request->hasFile('hero_image')) {
            $savedImage = $request->file('hero_image')->store('branding', 'public');
            file_put_contents(storage_path('app/branding_hero_image.txt'), $savedImage);
        }

        if ($request->hasFile('hero_video')) {
            $savedVideo = $request->file('hero_video')->store('branding', 'public');
            file_put_contents(storage_path('app/branding_hero_video.txt'), $savedVideo);
        }

        return back()->with('success', 'Branding actualizado correctamente.');
    }

    // Avatar del administrador (usuario autenticado)
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
        $path = $request->file('avatar')->store('avatars', 'public');
        $user = $request->user();
        $user->avatar_path = $path;
        $user->save();
        return back()->with('success', 'Foto de administrador actualizada.');
    }

    public function deleteAvatar(Request $request)
    {
        $user = $request->user();
        if ($user->avatar_path) {
            try {
                Storage::disk('public')->delete($user->avatar_path);
            } catch (\Throwable $e) {
            }
            $user->avatar_path = null;
            $user->save();
        }
        return back()->with('success', 'Foto de administrador eliminada.');
    }

    public function tokens()
    {
        $tokens = ProfessorInvitationToken::orderByDesc('id')->paginate(10);
        return view('admin.tokens.index', compact('tokens'));
    }

    public function createToken(Request $request)
    {
        $data = $request->validate([
            'note' => ['nullable', 'string', 'max:255'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $token = ProfessorInvitationToken::create([
            'token' => Str::random(40),
            'note' => $data['note'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return redirect()->route('admin.tokens')->with('success', 'Token generado: ' . $token->token);
    }

    public function revokeToken(ProfessorInvitationToken $token)
    {
        $token->delete();
        return back()->with('success', 'Token revocado.');
    }

    public function courses()
    {
        // Filtros opcionales de estado y búsqueda
        $status = request()->get('status');
        $q = trim((string) request()->get('q', ''));

        $courses = Course::with(['professor', 'category', 'subCategory'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.courses.index', compact('courses', 'status', 'q'));
    }

    public function publishCourse(Course $course)
    {
        $course->update(['status' => 'published']);
        return back()->with('success', 'Curso publicado.');
    }

    public function unpublishCourse(Course $course)
    {
        $course->update(['status' => 'unpublished']);
        return back()->with('success', 'Curso despublicado.');
    }

    public function markUnderReview(Course $course)
    {
        $course->update(['status' => 'under_review']);
        return back()->with('success', 'Curso marcado para revisión.');
    }

    public function rejectCourse(Request $request, Course $course)
    {
        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);
        $course->update(['status' => 'rejected']);
        // TODO: notificar al profesor con la razón si se desea
        return back()->with('success', 'Curso rechazado' . (!empty($data['reason']) ? ': ' . $data['reason'] : '.'));
    }

    public function students(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $group = trim((string) $request->get('group', ''));

        $students = \App\Models\User::withCount('courses')
            ->whereHas('role', function ($qRole) {
                $qRole->where('name', 'Estudiante');
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when($group !== '', function ($query) use ($group) {
                $query->where('student_group', $group);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // Distintos grupos existentes para filtro rápido
        $groups = \App\Models\User::whereHas('role', function ($qRole) {
            $qRole->where('name', 'Estudiante');
        })
            ->whereNotNull('student_group')
            ->select('student_group')
            ->distinct()
            ->orderBy('student_group')
            ->pluck('student_group');

        return view('admin.students.index', compact('students', 'q', 'group', 'groups'));
    }

    // ---- Home Grid Media ----
    public function homeGrid()
    {
        $items = \App\Models\HomeGridItem::all()->keyBy('order');
        return view('admin.home-grid.index', compact('items'));
    }

    public function storeHomeGrid(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', 'integer', 'min:1', 'max:10'],
            'title' => ['nullable', 'string', 'max:100'],
            'media' => ['required', 'file'],
        ]);

        $file = $request->file('media');
        $mime = $file->getMimeType();
        $isVideo = str_starts_with($mime, 'video/');

        // Validaciones específicas
        if ($isVideo) {
            $request->validate(['media' => ['mimetypes:video/mp4,video/webm', 'max:51200']]); // 50MB
        } else {
            $request->validate(['media' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]); // 5MB
        }

        $path = $file->store('home-grid', 'public');

        $existing = \App\Models\HomeGridItem::where('order', $data['order'])->first();
        if ($existing) {
            // Borrar archivo previo
            try {
                Storage::disk('public')->delete($existing->media_path);
            } catch (\Throwable $e) {
            }
            $existing->update([
                'title' => $data['title'] ?? null,
                'media_path' => $path,
                'media_type' => $isVideo ? 'video' : 'image',
            ]);
        } else {
            \App\Models\HomeGridItem::create([
                'order' => $data['order'],
                'title' => $data['title'] ?? null,
                'media_path' => $path,
                'media_type' => $isVideo ? 'video' : 'image',
            ]);
        }

        return back()->with('success', 'Elemento guardado correctamente.');
    }

    public function deleteHomeGridItem(\App\Models\HomeGridItem $item)
    {
        try {
            Storage::disk('public')->delete($item->media_path);
        } catch (\Throwable $e) {
        }
        $item->delete();
        return back()->with('success', 'Elemento eliminado.');
    }

    // ---- Marquee (temas desplazables) ----
    public function marquee()
    {
        $items = \App\Models\MarqueeItem::orderBy('order')->get();
        return view('admin.marquee.index', compact('items'));
    }

    public function storeMarquee(Request $request)
    {
        $data = $request->validate([
            'text' => ['required', 'string', 'max:40'],
            'order' => ['nullable', 'integer', 'min:0', 'max:500'],
        ]);
        \App\Models\MarqueeItem::create([
            'text' => $data['text'],
            'order' => $data['order'] ?? 0,
            'active' => $request->boolean('active'), // interpreta 'on', '1', true
        ]);
        return back()->with('success', 'Elemento añadido');
    }

    public function deleteMarquee(\App\Models\MarqueeItem $item)
    {
        $item->delete();
        return back()->with('success', 'Elemento eliminado');
    }

    public function toggleMarquee(\App\Models\MarqueeItem $item)
    {
        $item->active = ! $item->active;
        $item->save();
        return back()->with('success', 'Estado actualizado');
    }
}
