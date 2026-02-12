@extends('layouts.app')

@section('title', 'Test Forms - 000form')

@section('content')

<!-- HTML Form -->
<form action="https://formsubmit.co/tsaklani2drish@gmail.com" method="POST">
     <input type="text" name="name" required>
     <input type="email" name="email" required>
     <input type="hidden" name="_next" value="http://127.0.0.1:8000/thank-you">
     <input type="hidden" name="_subject" value="New submission from Formsubmit!">
     <button type="submit">Send</button>
</form>

@endsection
