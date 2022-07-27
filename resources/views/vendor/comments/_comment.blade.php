@inject('markdown', 'Parsedown')
@php
// TODO: There should be a better place for this.
$markdown->setSafeMode(true);
@endphp


<div id="comment-{{ $comment->getKey() }}" class="media">



    <div class="comImg loading-cicle">
        @if ($comment->guest_name != null)
            <img class="mr-2 rounded-circle profileImg"
                src="https://www.gravatar.com/avatar/{{ md5($comment->commenter->email ?? $comment->guest_email) }}?d=wavatar&f=y.jpg"
                alt="{{ $comment->commenter->name ?? $comment->guest_name }} Avatar">
        @elseif (file_exists('vendor/dashboard/image/picture-profiles/' . $comment->commenter->user_image))
            <img class="mr-2 rounded-circle profileImg"
                src="{{ asset('vendor/dashboard/image/picture-profiles') . '/' . $comment->commenter->user_image ?? 'https://www.gravatar.com/avatar/?d=wavatar&f=y.jpg' }}"
                alt="{{ $comment->commenter->name }} Avatar">
        @else
            <img class="mr-2 rounded-circle profileImg" src="{{ asset('vendor/dashboard/image/avatar.png') }}"
                alt="{{ $comment->commenter->name }} Avatar">
        @endif

        <div class="vl"></div>
    </div>

    <div class="media-body">

        <div class="d-flex">
            <div class="d-block">
                <div class="comTitle loading">
                    <div class="comment-title guestName" style="font-family: 'Rubik', sans-serif;">
                        @if ($comment->guest_name != null)
                            {{ $comment->guest_name ?? 'kanzankazu' }}
                        @else
                            <a href="{{ route('blog.author', ['author' => $comment->commenter->slug]) }}">
                                {{ $comment->commenter->name }}
                            </a>
                            @if ($comment->commenter->id == $comment->commentable->user_id)
                                <span class="badge badge-info d-inline">
                                    Pembuat
                                </span>
                            @endif
                        @endif
                        <div class="small text-secondary">{{ $comment->created_at->longAbsoluteDiffForHumans() }}</div>
                    </div>
                </div>
            </div>

            @if (Auth::check())
                <div class="btn-group dropright btn_setting ">
                    <button class="btn btn-link dropdown-toggle dropdown-toggle-split m-0 p-0" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="iconsetting uil uil-ellipsis-v "></i>
                    </button>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-5 py-1">
                        @can('reply-to-comment', $comment)
                            <button data-toggle="modal" data-target="#reply-modal-{{ $comment->getKey() }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="uil uil-corner-up-left-alt text-primary"></i>
                                <span class="ml-2">Balas</span>
                            </button>
                        @endcan
                        @can('edit-comment', $comment)
                            <button data-toggle="modal" data-target="#comment-modal-{{ $comment->getKey() }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="uil uil-comment-alt-edit text-warning"></i>
                                <span class="ml-2">Edit</span>
                            </button>
                        @endcan
                        @can('delete-comment', $comment)
                            <a href="{{ route('comments.destroy', $comment->getKey()) }}"
                                onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->getKey() }}').submit();"
                                class="dropdown-item d-flex align-items-center">
                                <i class="uil uil-trash-alt text-danger"></i>
                                <span class="ml-2">Hapus</span>
                            </a>
                            <form id="comment-delete-form-{{ $comment->getKey() }}"
                                action="{{ route('comments.destroy', $comment->getKey()) }}" method="POST"
                                style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        @endcan
                    </div>
                </div>
            @endif
        </div>

        <div class="loading comText" style="margin-top: 1px">
            {{-- <div class="comment-text commentMsg">{!! $markdown->line($comment->comment) !!} </div> --}}
            <div class="comment-text commentMsg">{!! Markdown::convert($comment->comment)->getContent() !!} </div>
        </div>

        {{-- <small class="text-muted waktuKomen">{{ $comment->created_at->longAbsoluteDiffForHumans() }}</small> --}}

        @can('edit-comment', $comment)
            <div class="modal fade" id="comment-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-centered">
                        <form id="formCommentUpdate" method="POST" class="form-modal-comment"
                            action="{{ route('comments.update', $comment->getKey()) }}">
                            @method('PUT')
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">Edit komentar kamu</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="message">Edit komentar kamu disini.</label>
                                    <textarea class="form-control" required name="message" rows="8" autofocus>{{ $comment->comment }}</textarea>
                                    <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase"
                                    data-dismiss="modal">Batal</button>
                                <button type="submit" id="submit-comment-update"
                                    class="btn btn-sm btn-outline-success text-uppercase">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @can('reply-to-comment', $comment)
            <div class="modal fade" id="reply-modal-{{ $comment->getKey() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-centered">
                        <form id="formCommentReply" method="POST"
                            action="{{ route('comments.reply', $comment->getKey()) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Balas komentar</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="message">Masukkan komentar kamu disini</label>
                                    <textarea required class="form-control" name="message" rows="8"></textarea>
                                    <span class="invalid-feedback d-block error-text message_error"></span>
                                    <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase"
                                    data-dismiss="modal">Batal</button>
                                <button id="submit-comment-reply" type="submit"
                                    class="btn btn-sm btn-outline-success text-uppercase">Balas</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        {{-- Margin bottom --}}

        <?php
        if (!isset($indentationLevel)) {
            $indentationLevel = 1;
        } else {
            $indentationLevel++;
        }
        ?>

        {{-- Recursion for children --}}
        @if ($grouped_comments->has($comment->getKey()) && $indentationLevel <= $maxIndentationLevel)
            {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
            @foreach ($grouped_comments[$comment->getKey()] as $child)
                @include('comments::_comment', [
                    'comment' => $child,
                    'grouped_comments' => $grouped_comments,
                ])
            @endforeach
        @endif

    </div>

</div>



{{-- Recursion for children --}}
@if ($grouped_comments->has($comment->getKey()) && $indentationLevel > $maxIndentationLevel)
    {{-- TODO: Don't repeat code. Extract to a new file and include it. --}}
    @foreach ($grouped_comments[$comment->getKey()] as $child)
        @include('comments::_comment', [
            'comment' => $child,
            'grouped_comments' => $grouped_comments,
        ])
    @endforeach
@endif
