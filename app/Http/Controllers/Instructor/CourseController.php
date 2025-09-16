<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $query = Course::where('user_id', $userId)->latest('id');

        // Filtro opcional por estado ?status=published|pending|under_review|rejected|unpublished
        $status = request('status');
        if ($status) {
            $allowed = ['published', 'pending', 'under_review', 'rejected', 'unpublished'];
            if (in_array($status, $allowed, true)) {
                $query->where('status', $status);
            }
        }

        $courses = $query->get();
        return view('instructor.courses.index', compact('courses', 'status'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $levels = ['Inicial', 'Intermedio', 'Avanzado'];
        return view('instructor.courses.create', compact('categories', 'levels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:courses,slug'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'level' => ['nullable', 'in:Inicial,Intermedio,Avanzado'],
        ]);

        $data['user_id'] = Auth::id();
        // Si el slug viene vacío por alguna razón, autogenerar
        if (empty($data['slug'])) {
            $base = Str::slug($data['title']);
            $slug = $base ?: Str::random(8);
            $i = 1;
            while (Course::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        $course = Course::create($data);
        return redirect()->route('instructor.courses.edit', $course);
    }

    public function edit(Course $course)
    {
        $this->authorizeOwner($course);
        $categories = Category::orderBy('name')->get();
        $levels = ['Inicial', 'Intermedio', 'Avanzado'];
        return view('instructor.courses.edit', compact('course', 'categories', 'levels'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeOwner($course);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:courses,slug,' . $course->id],
            'category_id' => ['required', 'exists:categories,id'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'description' => ['nullable', 'string'],
            'level' => ['nullable', 'in:Inicial,Intermedio,Avanzado'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            Log::info('Image file detected', ['file' => $request->file('image')->getClientOriginalName()]);
            if (!empty($course->image_path)) {
                Log::info('Deleting old image', ['path' => $course->image_path]);
                Storage::disk('public')->delete($course->image_path);
            }
            $path = $request->file('image')->store('courses/images', 'public');
            Log::info('New image stored', ['path' => $path]);
            $data['image_path'] = $path;
        }

        $course->update($data);

        session()->flash('success', 'El curso se actualizó con éxito');
        return redirect()->route('instructor.courses.edit', $course);
    }

    protected function authorizeOwner(Course $course): void
    {
        if (Auth::id() !== $course->user_id) {
            abort(403);
        }
    }
}
