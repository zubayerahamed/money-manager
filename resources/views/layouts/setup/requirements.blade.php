<input type="hidden" name="success-status" value="{{ $success }}">
<a href="{{ $nextUrl }}" class="next-url"></a>
<a href="{{ $prevUrl }}" class="prev-url"></a>

<ul style="list-style: none">
    @foreach ($results as $key => $successful)
        <li class="pb-2">
            @if ($successful)
                <i class="fas fa-check text-success"></i>
            @else
                <i class="fas fa-times text-danger"></i>
            @endif
            <span class="p-2">{{ $key }}</span>
        </li>
    @endforeach
</ul>