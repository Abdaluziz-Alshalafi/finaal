@extends('static.layouts.student')
@section('title')
Create Project
@endsection



@section('content')



@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif




<div class="container">

    <h2>طلباتي </h2>


    <div class="container mt-4">
















    </div>
</div>





















@endsection