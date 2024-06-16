<x-layout>
      <div class="container py-md-5 container--narrow">

        @unless($posts->isEmpty())
        <h2 class="text-center mb-4">The Latest From Those You Follow</h2>
        <div class="list-group">
          @foreach($posts as $post)

          {{-- 只有開始標籤代表裡面沒有任何客製化內容 --}}
          <x-post :post="$post"/>

          @endforeach
        </div>
        
        <div class="mt-4">
          {{ $posts->links() }}
        </div>

        @else
        <div class="text-center">
          {{-- auth ( ) -> user ( ) -> username】來取得登入者的使用者名稱； 注意：username 不是固定的，而是根據資料表中定義的欄位名稱有所不同 --}}
        <h2>Hello <strong>{{ auth()->user()->username }}</strong>, your feed is empty.</h2>
        <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
      </div>

        @endunless
        
      </div>
</x-layout>