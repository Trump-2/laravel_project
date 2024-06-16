<a href="/post/{{ $post->id }}" class="list-group-item list-group-item-action">
  <img class="avatar-tiny" src="{{ $post->user->avatar }}" />
  <strong>{{ $post->title }}</strong> 
  <span class="text-muted small">
    {{-- 根據是否有傳入 hideAuthor 這個變數給 post component 來決定是否要顯示 post 的作者名子 --}}
    @if(!isset($hideAuthor))
    by {{$post->user->username }} 
    @endif
    on {{ $post->created_at->format('n/j/Y') }}
  </span>
</a>
