@if (url()->current() == route('posts.create'))
    @foreach ($tutorials as $tutorial)
        <div class="checkbox my-2">
            <div class="custom-control custom-checkbox">
                @if ($tutoChecked == $tutorial->id)
                    <input type="radio" name="tutorial" value="{{ $tutorial->id }}" class="custom-control-input"
                        id="tutorial-{{ $tutorial->id }}" checked>
                @else
                    <input type="radio" name="tutorial" value="{{ $tutorial->id }}" class="custom-control-input"
                        id="tutorial-{{ $tutorial->id }}">
                @endif

                <label class="custom-control-label" for="tutorial-{{ $tutorial->id }}">
                    {{ $tutorial->title }}
                </label>
            </div>
        </div>
    @endforeach
@elseif (url()->current() == route('posts.edit', $post->slug))
    @foreach ($tutorials as $tutorial)
        <div class="checkbox my-2">
            <div class="custom-control custom-checkbox">
                @if (old('tutorial', $tutoChecked) && in_array($tutorial->id, old('tutorial', $tutoChecked)))
                    <input type="radio" name="tutorial" value="{{ $tutorial->id }}" class="custom-control-input"
                        id="tutorial-{{ $tutorial->id }}" checked>
                @else
                    <input type="radio" name="tutorial" value="{{ $tutorial->id }}" class="custom-control-input"
                        id="tutorial-{{ $tutorial->id }}">
                @endif

                <label class="custom-control-label" for="tutorial-{{ $tutorial->id }}">
                    {{ $tutorial->title }}
                </label>
            </div>
        </div>
    @endforeach
@endif
