@extends('layouts.app')

@section('content')
<div class="content">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @include('layouts.flash-message')
      <div class="card">
        <h5 class="card-header">新規投稿作成</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('threads.store') }}">
            @csrf
            <div class="form-group">
              <label for="thread-title">投稿タイトル</label>
              <input type="text" name="thread_title" class="form-control" id="thread-title" placeholder="タイトルを入力">
            </div>
            <div class="form-group">
              <label for="thread-first-content">内容</label>
              <textarea name="content" id="thread-first-content" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">投稿する</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection