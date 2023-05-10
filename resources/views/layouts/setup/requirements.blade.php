<a href="{{ $nextUrl }}" class="next-url"></a>
<a href="{{ $prevUrl }}" class="prev-url"></a>

<ul>
    @foreach ($results as $key => $successful)
        <li>
            {{ $key }}
            @if ($successful)
                <i class="fas fa-check text-success"></i>
            @else
                <i class="fas fa-times text-danger"></i>
            @endif
        </li>
    @endforeach
</ul>