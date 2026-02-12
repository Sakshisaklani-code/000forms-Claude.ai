@extends('layouts.app')

@section('title', 'Test Forms - 000form')

@section('content')

<!-- HTML Form -->
<!-- HTML Form -->
<form id="form-f_bvxsvw88" action="http://127.0.0.1:8000/f/f_bvxsvw88" method="POST">

  <input type="text" name="name" placeholder="Your name" required>
  <input type="email" name="email" placeholder="Your email" required>
  <textarea name="message" placeholder="Your message"></textarea>
  
    <!-- Honeypot (spam protection) -->
  <input type="text" name="honeypot_iEGI7CJW" style="display:none">
    
  <button type="submit">Send Message</button>
</form>




@endsection

