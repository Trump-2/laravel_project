<x-layout>

  <div class="container py-md-5 container--narrow">
    <form action="/post/{{ $post->id }}" method="POST">
      <p><small><strong><a href="/post/{{ $post->id }}">&laquo; Back to post</a></strong></small></p>
      @csrf
      {{-- 透過此 blade 指令來讓 form 能夠送出 put request，代表要更新現有資源 --}}
      @method('PUT')
      <div class="form-group">
        <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
        {{-- old() 的第二個參數是預設值 --}}
        <input value="{{ old('title', $post->title) }}" required name="title" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" />
        @error('title')
        <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
        <textarea required name="content" id="post-body" class="body-content tall-textarea form-control" type="text">
          {{ old('content',$post->content) }}
        </textarea>
        @error('content')
        <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
        @enderror
      </div>

      <button class="btn btn-primary">Save Changes</button>
    </form>
  </div>

</x-layout>