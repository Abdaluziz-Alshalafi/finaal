@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>🔔 إشعار العملية</h2>

        @if(session('success'))
            <p style="color: green;">✅ {{ session('success') }}</p>
        @elseif(session('error'))
            <p style="color: red;">❌ {{ session('error') }}</p>
        @endif

        <a href="{{ route('dashboard') }}" class="btn btn-primary">العودة إلى الرئيسية</a>
    </div>
@endsection
