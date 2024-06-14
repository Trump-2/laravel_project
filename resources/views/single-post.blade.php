 <x-layout>
  <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h2>{{$post->title}}</h2>

        {{-- 這段是編輯和刪除的 icon --}}
        {{-- 使用 @can，來決定當前的使用者是否能 update 這個 post --}}
        @can('update',$post)
        <span class="pt-2">
          <a href="/post/{{ $post->id }}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
          <form class="delete-post-form d-inline" action="/post/{{ $post->id }}" method="POST">
            @csrf
            {{-- 透過此 blade 指令來讓 form 能夠送出 delete request --}}
            @method('DELETE')
            <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </span>
        @endcan
      </div>

      {{-- 使用剛剛在 Post Model 建立的 user 函數，注意 25 行使用 user 函數的方式，沒有透過 ( ) 來使用 user 函數，接著存取 username 屬性 ( 也就是資料表中 username 欄位的值 ) --}}
      {{-- 使用內建的【format ( )】來格式化日期時間； --}}
      <p class="text-muted small mb-4">
        <a href="#"><img class="avatar-tiny" src="{{ $post->user->avatar }}" /></a>
        Posted by <a href="#">{{ $post->user->username}}</a> on {{$post->created_at->format('n/j/Y')}}
      </p>

      <div class="body-content">
        {{-- 將內容中包含的 html tag 解釋為 html --}}
        {!! $post->content !!}
      </div>
    </div>
</x-layout>