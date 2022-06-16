@foreach ($categories as $category)
    <div class="checkbox my-2">
        <div class="custom-control custom-checkbox">
            @if ($cateChecked == $category->id)
                <input type="radio" name="category" value="{{ $category->id }}" class="custom-control-input"
                    id="{{ $category->id }}" checked>
            @else
                <input type="radio" name="category" value="{{ $category->id }}" class="custom-control-input"
                    id="{{ $category->id }}">
            @endif

            <label class="custom-control-label" for="{{ $category->id }}">
                {{ $category->title }}
            </label>

            @if ($category->generation)
                @include('dashboard.manage-posts.posts.categories-check', [
                    'categories' => $category->generation,
                    'cateChecked' => $cateChecked,
                ])
            @endif
        </div>
    </div>
@endforeach
