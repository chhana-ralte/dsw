<!DOCTYPE html>
<html lang="en">
<head>
  <title>MZU IT Department</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css">
  <script src="https://cdn.ckeditor.com/4.24.0-lts/standard/ckeditor.js"></script>
</head>
<body>

<br>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">MZUIT</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link" href="/diktei">Entry</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="/dtcourse">Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/diktei/students">Students</a>
        </li>
        @auth
        <li class="nav-item">
          <a class="nav-link" href="/diktei/allotments">Allotments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/diktei/list">List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/diktei/unallotted">Unallotted</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/diktei/search">Search</a>
        </li>
        @endauth
      </ul>
<!--      <ul class="navbar-nav me-auto"> -->
      @auth
        <div class="dropdown">
          <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            {{ auth()->user()->username }}
          </button>
          <ul class="dropdown-menu">
            
            <li><button class="dropdown-item" form="logout-form">Logout</button></li>          
            <form method="post" id="logout-form" action="/logout" type="hidden">
              @csrf
            </form>
          </ul>
        </div>
      @else
        <a class="btn btn-outline-secondary" type="button" href="/login">Login</a>
      @endif
    </div>
  </div>
</nav>

<div class="container-fluid mt-5">
@if(Session::has('message'))
  <x-alert type="{{ session('message')['type'] }}">{{ session("message")['text'] }}</x-alert>
@endif
  {{ $slot }}
</div>

</body>
</html>


