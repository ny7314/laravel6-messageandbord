<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ThreadService;
use App\Http\Requests\ThreadRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ThreadRepository;
use App\Services\SlackNotificationService;
use App\Notifications\SlackNotification;


class ThreadController extends Controller
{
    protected $thread_service;

    protected $thread_repository;

    protected $slack_notification_service;

    public function __construct(
        ThreadService $thread_service,
        ThreadRepository $thread_repository,
        SlackNotificationService $slack_notification_service
    )
    {
        $this->middleware('auth')->except('index');
        $this->thread_service = $thread_service;
        $this->thread_repository = $thread_repository;
        $this->slack_notification_service = $slack_notification_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->thread_service->getThreads(3);
        $threads->load('messages.user', 'messages.images');
        return view('threads.index', compact('threads'));
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
    public function store(ThreadRequest $request)
    {
        try {
            $data = $request->only(
                ['thread_title', 'content']
            );
            $this->thread_service->createNewThread($data, Auth::id());
            $this->slack_notification_service->send(Auth::user()->name . '　が　' . $request->thread_title . '　を投稿しました！');
        } catch (Exception $error) {
            return redirect()->route('threads.index')->with('error', '新規投稿に失敗しました。');
        }
        return redirect()->route('threads.index')->with('success', '新規投稿が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = $this->thread_repository->findById($id);
        $thread->load('messages.user', 'messages.images');
        return view('threads.show', compact('thread'));
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
    public function destroy($id)
    {
        //
    }
}
