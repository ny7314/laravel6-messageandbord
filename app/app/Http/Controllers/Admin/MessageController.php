<?php

namespace App\Http\Controllers\Admin;

use App\Thread;
use App\Http\Controllers\Controller;
use App\Repositories\MessageRepository;

class MessageController extends Controller
{
    protected $message_repository;

    public function __construct(
        MessageRepository $message_repository
    )
    {
        $this->middleware('auth:admin');
        $this->message_repository = $message_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $message = $this->message_service->createNewMessage($data, $id);
            $images = $request->file('images');
            if ($images){
                $this->image_service->createNewImages($images, $message->id);
            }
        } catch (Exception $error){
            return redirect()->route('threads.show', $id)->with('error', 'メッセージの投稿に失敗しました。');
        }

        return redirect()->route('threads.show', $id)->with('success', 'メッセージを投稿しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread, $id)
    {
        try {
            $this->message_repository->deleteMessage($id);
        } catch (Exception $error) {
            return redirect()->route('admin.threads.show', $thread->id)->with('error', 'コメントの削除に失敗しました。');
        }
        return redirect()->route('admin.threads.show', $thread->id)->with('success', 'コメントの削除に成功しました。');
    }
}
