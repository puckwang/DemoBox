<?php

namespace App\Http\Controllers;

use App\Services\FCMServices;
use Illuminate\Http\Request;

class FCMController extends Controller
{
    private $FCMServices;

    public function __construct(FCMServices $FCMServices)
    {
        $this->FCMServices = $FCMServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fcm.index');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('topic') != '') {
            $response = $this->FCMServices->sendToTopic(
                $request->input('title'),
                $request->input('body'),
                $request->input('color'),
                $request->input('topic')
            );
        } else {
            $response = $this->FCMServices->sendTo(
                $request->input('title'),
                $request->input('body'),
                $request->input('color'),
                $request->input('driveToken')
            );
        }


        return view('fcm.index', [
            'response'   => $response,
            'title'      => $request->input('title'),
            'body'       => $request->input('body'),
            'color'      => $request->input('color'),
            'topic'      => $request->input('topic', ''),
            'driveToken' => $request->input('driveToken', ''),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
