@props(['course'])
<a href="{{ route('courses.show', $course->slug) }}" class="block rounded overflow-hidden bg-primary/50 border border-white/10 hover:border-accent-blue transition-all focus:ring-2 focus:ring-accent-blue outline-none">
    @if($course->image_path)
        <img src="{{ asset('storage/'.$course->image_path) }}" alt="{{ $course->title }}" class="w-full h-40 object-cover">
    @endif
    <div class="p-3 text-light-gray">
        <h3 class="font-semibold line-clamp-2">{{ $course->title }}</h3>
        <div class="text-sm text-light-gray/80 mt-1">{{ optional($course->category)->name }}</div>
        @if(!is_null($course->price))
            <div class="mt-2 font-bold text-accent-blue">{{ 'ARS ' . number_format($course->price, 2, ',', '.') }}</div>
        @endif
    </div>
</a>
