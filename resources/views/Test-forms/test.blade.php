@extends('layouts.app')

@section('title', 'Test Forms - 000form')

@section('content')

<!-- HTML Form -->
<form  action="http://127.0.0.1:8000/f/f_qychdxq8" method="POST">
  <input type="email" name="email" placeholder="Your email" required>

  <textarea name="message" placeholder="Your message"></textarea>
  
    <!-- Honeypot (spam protection) -->
  <input type="text" name="_gotcha" style="display:none">
  <input type="hidden" name="_blacklist" value="
    viagra,
    cialis,
    casino games,
    lottery winner,
    free money now,
    click here immediately,
    bitcoin investment,
    make money fast,
    work from home job,
    limited time offer">
  <input type="hidden" name="_next" value="http://127.0.0.1:8000/thank-you">
  <input type="hidden" name="_subject" value="New submission from 000forms First Form while testing _subject field">
  <button type="submit">Send Message</button>
</form>


@endsection

