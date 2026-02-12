@extends('layouts.app')

@section('title', 'Test Forms - 000form')

@section('content')

<!-- modify this form HTML and place wherever you want your form -->
<form
  action="https://formspree.io/f/xvzbpnwy"
  method="POST">
  <label>
    Your email:
    <input type="email" name="email">
  </label>
  <label>
    Your message:
    <textarea name="message"></textarea>
  </label>
  <!-- your other form fields go here -->
  <button type="submit">Send</button>
</form>

@endsection