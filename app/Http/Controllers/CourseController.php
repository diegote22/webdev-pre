<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CourseGoal;
use App\Models\CourseRequirement;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\LessonAttachment;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $courses = Course::with(['category', 'subCategory'])
            ->where('user_id', $user->id)
            ->latest('id')
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('name')->get();
        $levels = ['Inicial', 'Intermedio', 'Avanzado'];
        return view('courses.create', compact('categories', 'subCategories', 'levels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'level' => ['nullable', 'in:Inicial,Intermedio,Avanzado'],
            'summary' => ['nullable', 'string', 'max:500'],
        ]);

        $data['user_id'] = $request->user()->id;
        if (empty($data['slug'])) {
            $base = Str::slug($data['title']);
            $slug = $base ?: Str::random(8);
            $i = 1;
            while (Course::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }
        Course::create($data);

        return redirect()->route('courses.index')->with('status', 'Curso creado correctamente.');
    }

    public function edit(Course $course): View
    {
        $this->authorizeOwner($course);
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('name')->get();
        $levels = ['Inicial', 'Intermedio', 'Avanzado'];
        return view('courses.edit', compact('course', 'categories', 'subCategories', 'levels'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'level' => ['nullable', 'in:Inicial,Intermedio,Avanzado'],
            'summary' => ['nullable', 'string', 'max:500'],
        ]);

        $course->update($data);

        return redirect()->route('courses.index')->with('status', 'Curso actualizado.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $course->delete();
        return redirect()->route('courses.index')->with('status', 'Curso eliminado.');
    }

    protected function authorizeOwner(Course $course): void
    {
        if (auth()->id() !== $course->user_id) {
            abort(403);
        }
    }

    public function wizard(Course $course): View
    {
        $this->authorizeOwner($course);
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('name')->get();
        $levels = ['Inicial', 'Intermedio', 'Avanzado'];
        return view('courses.wizard', compact('course', 'categories', 'subCategories', 'levels'));
    }

    public function saveGeneral(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'level' => ['nullable', 'in:Inicial,Intermedio,Avanzado'],
            'summary' => ['nullable', 'string', 'max:500'],
        ]);
        $course->update($data);
        return back()->with(['status' => 'Datos generales guardados', 'activeTab' => 'general']);
    }

    // ---------- Persistencia por pestaña ----------
    public function saveCustomize(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate([
            'slug' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // slug auto si viene vacío
        if (empty($data['slug'])) {
            $base = Str::slug($course->title ?: Str::random(6));
            $slug = $base;
            $i = 1;
            while (Course::where('slug', $slug)->where('id', '!=', $course->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $data['image_path'] = $path;
        }

        $course->update(array_filter([
            'slug' => $data['slug'] ?? null,
            'image_path' => $data['image_path'] ?? null,
        ], fn($v) => !is_null($v)));

        return back()->with(['status' => 'Personalización guardada', 'activeTab' => 'customize']);
    }

    public function savePromo(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate([
            'video_type' => ['required', 'in:youtube,local'],
            'youtube_url' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:204800'],
        ]);

        $promo = null;
        if ($data['video_type'] === 'youtube' && !empty($data['youtube_url'])) {
            // normalizar: aceptar URL completa o ID
            try {
                $u = new \Illuminate\Support\Str($data['youtube_url']);
            } catch (\Throwable $e) {
            }
            $promo = $data['youtube_url'];
        } elseif ($data['video_type'] === 'local' && $request->hasFile('video_file')) {
            $promo = $request->file('video_file')->store('courses/promo', 'public');
            $promo = Storage::url($promo);
        }

        $course->update(['promo_video_url' => $promo]);
        return back()->with(['status' => 'Video promocional guardado', 'activeTab' => 'promo']);
    }

    // Goals
    public function storeGoal(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate(['text' => ['required', 'string', 'max:255']]);
        $pos = ($course->goals()->max('position') ?? 0) + 1;
        $course->goals()->create(['text' => $data['text'], 'position' => $pos]);
        return back()->with(['status' => 'Meta agregada', 'activeTab' => 'goals']);
    }

    public function updateGoal(Request $request, Course $course, CourseGoal $goal): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($goal->course_id !== $course->id) abort(404);
        $data = $request->validate(['text' => ['required', 'string', 'max:255']]);
        $goal->update($data);
        return back()->with(['status' => 'Meta actualizada', 'activeTab' => 'goals']);
    }

    public function destroyGoal(Request $request, Course $course, CourseGoal $goal): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($goal->course_id !== $course->id) abort(404);
        $goal->delete();
        return back()->with(['status' => 'Meta eliminada', 'activeTab' => 'goals']);
    }

    // Requirements
    public function storeRequirement(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate(['text' => ['required', 'string', 'max:255']]);
        $pos = ($course->requirements()->max('position') ?? 0) + 1;
        $course->requirements()->create(['text' => $data['text'], 'position' => $pos]);
        return back()->with(['status' => 'Requisito agregado', 'activeTab' => 'requirements']);
    }

    public function updateRequirement(Request $request, Course $course, CourseRequirement $requirement): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($requirement->course_id !== $course->id) abort(404);
        $data = $request->validate(['text' => ['required', 'string', 'max:255']]);
        $requirement->update($data);
        return back()->with(['status' => 'Requisito actualizado', 'activeTab' => 'requirements']);
    }

    public function destroyRequirement(Request $request, Course $course, CourseRequirement $requirement): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($requirement->course_id !== $course->id) abort(404);
        $requirement->delete();
        return back()->with(['status' => 'Requisito eliminado', 'activeTab' => 'requirements']);
    }

    // Reordenamiento de metas y requisitos
    public function reorderGoals(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $validated = $request->validate([
            'order' => ['required'], // puede venir como JSON string o array
        ]);
        $order = is_string($validated['order']) ? json_decode($validated['order'], true) : $validated['order'];
        if (!is_array($order)) $order = [];
        foreach ($order as $idx => $goalId) {
            CourseGoal::where('id', $goalId)->where('course_id', $course->id)->update(['position' => $idx + 1]);
        }
        return back()->with(['status' => 'Orden de metas actualizado', 'activeTab' => 'goals']);
    }

    public function reorderRequirements(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $validated = $request->validate([
            'order' => ['required'],
        ]);
        $order = is_string($validated['order']) ? json_decode($validated['order'], true) : $validated['order'];
        if (!is_array($order)) $order = [];
        foreach ($order as $idx => $reqId) {
            CourseRequirement::where('id', $reqId)->where('course_id', $course->id)->update(['position' => $idx + 1]);
        }
        return back()->with(['status' => 'Orden de requisitos actualizado', 'activeTab' => 'requirements']);
    }

    // Sections
    public function storeSection(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeOwner($course);
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $pos = ($course->sections()->max('position') ?? 0) + 1;
        $course->sections()->create(['name' => $data['name'], 'position' => $pos]);
        return back()->with(['status' => 'Sección agregada', 'activeTab' => 'sections']);
    }

    public function updateSection(Request $request, Course $course, Section $section): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id) abort(404);
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $section->update($data);
        return back()->with(['status' => 'Sección actualizada', 'activeTab' => 'sections']);
    }

    public function destroySection(Request $request, Course $course, Section $section): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id) abort(404);
        $section->delete();
        return back()->with(['status' => 'Sección eliminada', 'activeTab' => 'sections']);
    }

    // Lessons
    public function storeLesson(Request $request, Course $course, Section $section): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id) abort(404);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video_type' => ['nullable', 'in:youtube,local'],
            'youtube_url' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:512000'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
            'is_preview' => ['nullable', 'boolean'],
        ]);

        $video_url = null;
        if (($data['video_type'] ?? null) === 'youtube' && !empty($data['youtube_url'])) {
            $video_url = $data['youtube_url'];
        } elseif (($data['video_type'] ?? null) === 'local' && $request->hasFile('video_file')) {
            $v = $request->file('video_file')->store('courses/lessons', 'public');
            $video_url = Storage::url($v);
        }

        $thumb = null;
        if ($request->hasFile('thumbnail')) {
            $t = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $thumb = $t;
        }

        $pos = ($section->lessons()->max('position') ?? 0) + 1;
        $section->lessons()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'video_type' => $data['video_type'] ?? null,
            'video_url' => $video_url,
            'thumbnail_path' => $thumb,
            'is_published' => (bool)($data['is_published'] ?? false),
            'is_preview' => (bool)($data['is_preview'] ?? false),
            'position' => $pos,
        ]);

        return back()->with(['status' => 'Lección agregada', 'activeTab' => 'sections']);
    }

    public function updateLesson(Request $request, Course $course, Section $section, Lesson $lesson): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id || $lesson->section_id !== $section->id) abort(404);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'video_type' => ['nullable', 'in:youtube,local'],
            'youtube_url' => ['nullable', 'url'],
            'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:512000'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_published' => ['nullable', 'boolean'],
            'is_preview' => ['nullable', 'boolean'],
        ]);

        $update = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'video_type' => $data['video_type'] ?? null,
            'is_published' => (bool)($data['is_published'] ?? false),
            'is_preview' => (bool)($data['is_preview'] ?? false),
        ];

        if (($data['video_type'] ?? null) === 'youtube' && !empty($data['youtube_url'])) {
            $update['video_url'] = $data['youtube_url'];
        } elseif (($data['video_type'] ?? null) === 'local' && $request->hasFile('video_file')) {
            $v = $request->file('video_file')->store('courses/lessons', 'public');
            $update['video_url'] = Storage::url($v);
        }

        if ($request->hasFile('thumbnail')) {
            $t = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $update['thumbnail_path'] = $t;
        }

        $lesson->update($update);
        return back()->with(['status' => 'Lección actualizada', 'activeTab' => 'sections']);
    }

    public function destroyLesson(Request $request, Course $course, Section $section, Lesson $lesson): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id || $lesson->section_id !== $section->id) abort(404);
        $lesson->delete();
        return back()->with(['status' => 'Lección eliminada', 'activeTab' => 'sections']);
    }

    // Lesson Attachments (PDFs, imágenes)
    public function storeLessonAttachment(Request $request, Course $course, Section $section, Lesson $lesson): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id || $lesson->section_id !== $section->id) abort(404);
        $validated = $request->validate([
            'attachments' => ['required', 'array'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:51200'], // hasta 50MB c/u
        ]);

        foreach ($request->file('attachments', []) as $file) {
            $stored = $file->store('courses/attachments', 'public');
            $lesson->attachments()->create([
                'path' => $stored,
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);
        }

        return back()->with(['status' => 'Material(es) agregado(s)', 'activeTab' => 'sections']);
    }

    public function destroyLessonAttachment(Request $request, Course $course, Section $section, Lesson $lesson, LessonAttachment $attachment): RedirectResponse
    {
        $this->authorizeOwner($course);
        if ($section->course_id !== $course->id || $lesson->section_id !== $section->id || $attachment->lesson_id !== $lesson->id) abort(404);
        try {
            if ($attachment->path) {
                Storage::disk('public')->delete($attachment->path);
            }
        } catch (\Throwable $e) {
        }
        $attachment->delete();
        return back()->with(['status' => 'Material eliminado', 'activeTab' => 'sections']);
    }
}
