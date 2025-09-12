<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Curso') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('courses.update', $course) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium">Título</label>
                            <input name="title" value="{{ old('title', $course->title) }}"
                                class="mt-1 w-full border rounded p-2" required>
                            @error('title')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Descripción</label>
                            <textarea name="description" class="mt-1 w-full border rounded p-2" rows="4" required>{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium">Categoría</label>
                                <select name="category_id" class="mt-1 w-full border rounded p-2" required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('category_id', $course->category_id) == $cat->id)>
                                            {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Subcategoría</label>
                                <select name="sub_category_id" class="mt-1 w-full border rounded p-2">
                                    <option value="">-- Opcional --</option>
                                    @foreach ($subCategories as $sc)
                                        <option value="{{ $sc->id }}" @selected(old('sub_category_id', $course->sub_category_id) == $sc->id)>
                                            {{ $sc->category->name }} — {{ $sc->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_category_id')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium">Precio</label>
                                <input name="price" type="number" step="0.01" min="0"
                                    value="{{ old('price', $course->price) }}" class="mt-1 w-full border rounded p-2"
                                    required>
                                @error('price')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Nivel</label>
                                <select name="level" class="mt-1 w-full border rounded p-2">
                                    <option value="">-- Opcional --</option>
                                    @foreach ($levels as $lvl)
                                        <option value="{{ $lvl }}" @selected(old('level', $course->level) == $lvl)>
                                            {{ $lvl }}</option>
                                    @endforeach
                                </select>
                                @error('level')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Resumen</label>
                            <textarea name="summary" class="mt-1 w-full border rounded p-2" rows="3">{{ old('summary', $course->summary) }}</textarea>
                            @error('summary')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-between gap-2">
                            <a href="{{ route('courses.index') }}" class="px-4 py-2 bg-gray-100 rounded">Volver</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
