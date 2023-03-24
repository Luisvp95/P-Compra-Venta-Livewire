<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
    @foreach ($courses as $course)
        <x-course-card :course="$course" />
    @endforeach
</div>
