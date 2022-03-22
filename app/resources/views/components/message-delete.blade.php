@if (Auth::guard('admin')->check())
  <form action="{{ route('admin.threads.destroy', $thread->id) }}" method="POST" class="mb-4">
    @csrf
    @method('DELETE')
    <input type="submit" class="btn btn-danger" value="削除" onclick="return confirm('投稿を削除します。よろしいですか？')">
  </form>
@endif