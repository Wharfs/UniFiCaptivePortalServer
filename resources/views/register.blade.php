@extends('layouts.main')

<div class="main-block">
    <div class="left-part">
        <i class="fa-icon fas fa-wifi"></i>
        <h1>Register to our network</h1>
        <p>To use our network you must provide the information requested, please ask our staff if you have any questions.</p>
        <!--
            <div class="btn-group">
                <a class="btn-item" href="https://www.w3docs.com/learn-html.html">Learn HTML</a>
                <a class="btn-item" href="https://www.w3docs.com/quiz/#">Select Quiz</a>
            </div>
        -->
    </div>
    <form action="{{ route('hotspot-store') }}" method="POST">
        <div class="title">
            <i class="fas fa-pencil-alt"></i>
            <h2>Register here</h2>
        </div>
        <div class="info">
            @csrf
            <input type="text" id="name" name="name" placeholder="Full name" />
            <input type="text" id="email" name="email" placeholder="Email" />
            <input type="text" id="postcode" name="postcode" placeholder="PostCode" />
        </div>
        <!--
            <div class="checkbox ">
                <input type="checkbox " name="checkbox " /><span>I agree to the <a href="https://www.google.co.uk/ ">Privacy Policy.</a></span>
            </div>
        -->
        <div class="control-group">
            <div class="">
                <input type="hidden" name="create" value="create" />
                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
            </div>
        </div>
        <div class="messages">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>    
    </form>
</div>
