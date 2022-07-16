<div class="btn-group dropleft btn_setting">
    <button class="btn btn-link dropdown-toggle dropdown-toggle-split m-0 p-0" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="iconsetting uil uil-ellipsis-v "></i>
    </button>
    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
        {{-- detail --}}
        @can('post_detail')
            @if (($post->title != null && $post->description != null) || $cateOld != null)
                <a href="{{ route('posts.show', ['slug' => $post->slug]) }}#posts"
                    class="dropdown-item d-flex align-items-center">
                    <i class="uil uil-eye text-info"></i>
                    <span class="ml-2">Lihat postingan</span>
                </a>
            @endif
        @endcan

        @if ($post->user_id == Auth::user()->id)
            {{-- edit --}}
            @can('post_update')
                <a href="{{ route('posts.edit', ['slug' => $post->slug]) }}#posts"
                    class="dropdown-item d-flex align-items-center">
                    <i class="uil uil-pen text-warning"></i>
                    <span class="ml-2">Edit postingan</span>
                </a>
            @endcan

            @can('post_delete')
                {{-- delete --}}
                <form action="{{ route('posts.destroy', ['post' => $post]) }}#posts" method="POST" class="d-inline"
                    role="alertDelete"
                    alert-text='Hmm.. apakah kamu yakin? postingan kamu dengan judul @if ($post->title == null) "{{ $post->slug }}" @else "{{ $post->title }}" @endif akan dihapus permanen?'>
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="dropdown-item d-flex align-items-center">
                        <i class="uil uil-trash text-danger"></i>
                        <span class="ml-2">Hapus postingan</span>
                    </button>
                </form>
            @endcan

            @if (($post->title != null && $post->description != null) || $cateOld != null)
                <div class="dropdown-divider"></div>
            @endif

            @if ($post->status == 'publish')
                {{-- RECOMMENDED --}}
                @if (($post->title != null && $post->description != null) || $cateOld != null)
                    <form action="{{ route('posts.recommend', ['id' => $post->id]) }}#posts" method="POST"
                        class="d-inline">
                        @csrf
                        @method('POST')

                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="{{ $post->recommendedPost ? 'fas fa-star' : 'far fa-star' }} text-warning"></i>
                            <span
                                class="ml-2">{{ $post->recommendedPost ? 'Rekomendasi' : 'Rekomendasikan' }}</span>
                        </button>
                    </form>
                @endif

                {{-- DRAFT --}}
                @if (($post->title != null && $post->description != null) || $cateOld != null)
                    <form action="{{ route('posts.draft', ['post' => $post]) }}#posts" method="POST"
                        class="d-inline">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="uil uil-archive text-secondary"></i>
                            <span class="ml-2">Draft postingan</span>
                        </button>
                    </form>
                @endif
            @elseif ($post->status == 'draft')
                @if (($post->title != null && $post->description != null) || $cateOld != null)
                    <form action="{{ route('posts.recommend', ['id' => $post->id]) }}#posts" method="POST"
                        class="d-inline">
                        @csrf
                        @method('POST')

                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="{{ $post->recommendedPost ? 'fas fa-star' : 'far fa-star' }} text-warning"></i>
                            <span
                                class="ml-2">{{ $post->recommendedPost ? 'Rekomendasi' : 'Rekomendasikan' }}</span>
                        </button>
                    </form>
                @endif

                {{-- PUBLISH --}}
                @if (($post->title != null && $post->description != null) || $cateOld != null)
                    <form action="{{ route('posts.publish', ['post' => $post]) }}#posts" method="POST"
                        class="d-inline">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="uil uil-upload-alt text-primary"></i>
                            <span class="ml-2">Tampilkan postingan</span>
                        </button>
                    </form>
                @endif
            @endif
        @endif

        @if ($post->status == 'approve')
            @if (!Auth::user()->editorRole())
                <form action="{{ route('posts.approval', ['post' => $post]) }}#posts" method="POST" class="d-inline"
                    role="alertPublish" alert-button="Ya Setuju"
                    alert-text="Apakah kamu ingin mensetujui postingan {{ $post->title }}?">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="dropdown-item d-flex align-items-center">
                        <i class="uil uil-check text-success"></i>
                        <span class="ml-2">Setujui postingan</span>
                    </button>
                </form>
            @endif
        @endif
    </div>
</div>
