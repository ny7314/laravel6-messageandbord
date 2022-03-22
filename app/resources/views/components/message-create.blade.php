@if (Auth::guard('admin')->check())
  <form action="{{ route('admin.threads.destroy', $thread->id) }}" method="POST" class="mb-4">
    @csrf
    @method('DELETE')
    <input type="submit" class="btn btn-danger" value="削除" onclick="return confirm('投稿を削除します。よろしいですか？')">
  </form>
@else
  <form method="POST" action="{{ route('messages.store', $thread->id) }}" class="mb-1" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="thread-first-content">内容</label>
      <textarea name="body" class="form-control" id="thread-first-content" rows="3" required></textarea>
    </div>
    <div class="form-group">
      <label for="message-images">画像</label>
      <input type="file" class="form-control-file" id="message-images" name="images[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">書き込む</button>
  </form>
@endif

