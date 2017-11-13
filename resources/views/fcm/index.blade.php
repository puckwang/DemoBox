@extends('layout.main')

@section('head')

@endsection

@section('title')
    手機推播訊息
@endsection

@section('content')
    @if(isset($response))
    <div class="card">
        <div class="card-header">
            Response
        </div>
        <div class="card-body">
            <ul>
                <li>Title: {{ $title }}</li>
                <li>Body: {{ $body }}</li>
                <li>Topic: {{ $topic }}</li>
                <li>Drive token: {{ $driveToken }}</li>
                <li>Color: <span class="badge badge-pill" style="background-color: {{ $color }}">{{ $color }}</span></li>
                <hr>
                <li>Success: {{ $response->success ? 'True' : 'False' }}</li>
                <li>shouldRetry: {{ $response->shouldRetry }}</li>
                <li>error: {{ $response->error }}</li>
            </ul>
        </div>
    </div>
    @endif
    <br>
    <div class="card bg-light">
        <div class="card-header">
            Send Message
        </div>
        <div class="card-body">
            <form method="post" action="/fcm">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Enter title"
                           required>
                </div>
                <div class="form-group">
                    <label for="inputBody">Body</label>
                    <input type="text" class="form-control" id="inputBody" name="body" placeholder="body" required>
                </div>
                <div class="form-group">
                    <label for="inputTopic">Topic</label>
                    <input type="text" class="form-control" id="inputTopic" name="topic" placeholder="topic">
                </div>
                <div class="form-group">
                    <label for="inputDriveToken">Drive token</label>
                    <input type="text" class="form-control" id="inputDriveToken" name="driveToken" placeholder="token">
                </div>
                <div class="form-group">
                    <label for="inputColor">Color</label>
                    <input type="color" id="inputColor" name="color" value="#DDDDDD" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection

@section('script')

@endsection