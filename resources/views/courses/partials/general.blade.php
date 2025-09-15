@php($isWizard = isset($course) && $course)
<form method="POST" action="{{ $isWizard ? route('courses.general.save', $course) : route('courses.store') }}"
    class="space-y-4">
    @csrf
    @if ($isWizard)
        @method('POST')
    @endif
    <div>
        <label class="block text-sm font-medium text-base-content">Título del curso</label>
        <input name="title" class="mt-1 w-full input input-bordered"
            value="{{ $isWizard ? $course->title : old('title') }}" required>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-base-content">Categoría</label>
            <select name="category_id" class="mt-1 w-full select select-bordered" required>
                @foreach (\App\Models\Category::orderBy('name')->get() as $cat)
                    <option value="{{ $cat->id }}" @selected(($isWizard ? $course->category_id : old('category_id')) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-base-content">Subcategoría</label>
            <select name="sub_category_id" class="mt-1 w-full select select-bordered">
                <option value="">-- Opcional --</option>
                @foreach (\App\Models\SubCategory::with('category')->orderBy('name')->get() as $sc)
                    <option value="{{ $sc->id }}" @selected(($isWizard ? $course->sub_category_id : old('sub_category_id')) == $sc->id)>{{ $sc->category->name }} —
                        {{ $sc->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-base-content">Nivel</label>
            <select name="level" class="mt-1 w-full select select-bordered">
                <option value="Inicial" @selected(($isWizard ? $course->level : old('level')) === 'Inicial')>Inicial</option>
                <option value="Intermedio" @selected(($isWizard ? $course->level : old('level')) === 'Intermedio')>Intermedio</option>
                <option value="Avanzado" @selected(($isWizard ? $course->level : old('level')) === 'Avanzado')>Avanzado</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-base-content">Precio</label>
            <input name="price" type="number" step="0.01" min="0" class="mt-1 w-full input input-bordered"
                value="{{ $isWizard ? number_format($course->price, 2, '.', '') : old('price', '0.00') }}" required>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-base-content">Descripción</label>
        <textarea name="description" class="mt-1 w-full textarea textarea-bordered" rows="4" maxlength="500" required>{{ $isWizard ? $course->description : old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-base-content">Resumen</label>
        <textarea name="summary" class="mt-1 w-full textarea textarea-bordered" rows="3" maxlength="500">{{ $isWizard ? $course->summary : old('summary') }}</textarea>
        <p class="text-xs text-base-content/60 mt-1">Máximo 500 caracteres.</p>
    </div>
    <div class="flex justify-end">
        <button class="btn btn-primary">Guardar</button>
    </div>
</form>
