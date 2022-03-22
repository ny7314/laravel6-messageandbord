@inject('message_service', 'App\Services\MessageService')
@inject('image_service', 'App\Services\ImageService')
@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row justify-content-center">
    <div class="col-md-10">
      @include('layouts.flash-message')
      {{ $threads->links() }}
    </div>
  </div>
  <div class="row justify-content-center">
    @foreach ($threads as $thread)
      <div class="col-md-10 mb-5">
        <div class="card text-left">
          <div class="card-header">
            <h3><span class="badge badge-primary"><small>投稿数</small>{{ $thread->messages->count()}}</span></h3>
            <h3 class="m-0">{{ $thread->thread_title }}</h3>
          </div>
          @foreach ($thread->messages as $message)
          @if ($loop->index >= 5)
            @continue
          @endif
            <div class="card-body">
              <h5 class="card-title">{{ $loop->iteration }} {{ $message->user->name }}：{{ $message->created_at }}</h5>
              <p class="card-text">{!! $message_service->convertUrl($message->body) !!}</p>
              <div class="row mb-3">
                @if (!$message->images->isEmpty())
                  @foreach ($message->images as $image)
                    <div class="col-md-3">
                      <img src="{{ $image_service->createTemporaryUrl($image->s3_file_path) }}" class="img-thumbnail" alt="">
                    </div>
                  @endforeach
                @endif
              </div>
              @include('components.message-delete', compact('thread', 'message'))
            </div>
          @endforeach
          <div class="card-footer">
            @include('components.message-create', compact('thread'))
            @include('components.show-links', compact('thread'))
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <h5 class="card-header">新規投稿作成</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('threads.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="thread-title">投稿タイトル</label>
              <input type="text" name="thread_title" class="form-control" id="thread-title" placeholder="タイトルを入力" required>
            </div>
            <div class="form-group">
              <label for="thread-first-content">内容</label>
              <textarea name="content" id="thread-first-content" class="form-control" rows="3" required></textarea>
            </div>
            {{-- <div class="form-group">
              <label for="message-images">画像</label>
              <input type="file" class="form-control-file" id="message-images" name="images[]" multiple>
            </div> --}}
            <button type="submit" class="btn btn-primary">投稿する</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection