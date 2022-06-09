@foreach ($categories as $category)
    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
        <label class="mt-auto mb-auto">
            {{ str_repeat('-', $count) . ' ' . $category->title }}
        </label>

        <div>
            @can('category_update')
                {{-- edit --}}
                <a href="{{ route('categories.edit', ['category' => $category]) }}" class="btn btn-warning btn-sm"
                    data-toggle="tooltip" data-placement="bottom" title="Edit">
                    <i class="uil uil-pen"></i>
                </a>
            @endcan

            @can('category_delete')
                {{-- delete --}}
                <form action="{{ route('categories.destroy', ['category' => $category]) }}" class="d-inline"
                    role="alert" method="POST"
                    alert-text="Apakah kamu yakin? kategori {{ $category->title }} akan dihapus permanen?">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom"
                        title="Hapus">
                        <i class="uil uil-trash"></i>
                    </button>
                </form>
            @endcan
        </div>
        @if ($category->generation && !trim(request()->get('keyword')))
            @include('dashboard.manage-posts.categories.categories-list', [
                'categories' => $category->generation,
                'count' => $count + 1,
            ])
        @endif
    </li>
@endforeach
