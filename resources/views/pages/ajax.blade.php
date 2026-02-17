{{-- resources/views/pages/ajax-documentation.blade.php --}}
@extends('layouts.app')

@section('title', 'AJAX Documentation - 000form')

@section('content')

{{-- Main Content --}}
<main style="padding-top: 80px;">
    <div class="container" style="max-width: 900px;">

        {{-- Introduction --}}
        <div style="margin-bottom: 3rem;">
            <h2 style="margin-bottom: 1.5rem;">Form submission with AJAX</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                Without ever making your users leave the website, you can easily send the form using AJAX. 
                We've provided a few examples of making HTTP requests from some of the most popular libraries.
            </p>
            
            {{-- Endpoint Display --}}
            <div class="endpoint-display">
                <span class="endpoint-method">POST</span>
                <span class="endpoint-url">https://your-domain.com/f/your-form-token</span>
                <button class="code-copy" onclick="copyText('https://your-domain.com/f/your-form-token')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;">Copy</button>
            </div>
        </div>

        {{-- Fetch API Example --}}
        <div style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1rem;">Example using the Fetch API</h3>
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">JavaScript (Fetch)</span>
                    <button class="code-copy" onclick="copyCode(this)">Copy</button>
                </div>
                <div class="code-content">
                    <pre><span class="comment">// https://github.com/github/fetch</span>

fetch('https://your-domain.com/f/your-form-token', @{{ 
  method: 'POST',
  headers: @{{ 
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }},
  body: JSON.stringify(@{{ 
    name: "000forms User",
    email: "user@example.com",
    message: "Hello from 000forms!"
  }})
}})
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.log(error));</pre>
                </div>
            </div>
        </div>

        {{-- Axios Example --}}
        <div style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1rem;">Example using Axios</h3>
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">JavaScript (Axios)</span>
                    <button class="code-copy" onclick="copyCode(this)">Copy</button>
                </div>
                <div class="code-content">
                    <pre><span class="comment">// https://github.com/axios/axios</span>

axios.post('https://your-domain.com/f/your-form-token', @{{ 
  name: "000forms User",
  email: "user@example.com",
  message: "Hello from 000forms!"
}}, @{{ 
  headers: @{{ 
    'Content-Type': 'application/json'
  }}
}})
  .then(response => console.log(response.data))
  .catch(error => console.log(error));</pre>
                </div>
            </div>
        </div>

        {{-- jQuery Example --}}
        <div style="margin-bottom: 3rem;">
            <h3 style="margin-bottom: 1rem;">Example using jQuery</h3>
            <div class="code-block">
                <div class="code-header">
                    <span class="code-lang">JavaScript (jQuery)</span>
                    <button class="code-copy" onclick="copyCode(this)">Copy</button>
                </div>
                <div class="code-content">
                    <pre><span class="comment">// https://api.jquery.com/jQuery.ajax</span>

$.ajax(@{{ 
  url: 'https://your-domain.com/f/your-form-token',
  method: 'POST',
  headers: @{{ 
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }},
  data: JSON.stringify(@{{ 
    name: "000forms User",
    email: "user@example.com",
    message: "Hello from 000forms!"
  }}),
  success: function(response) @{{ 
    console.log(response);
  }},
  error: function(error) @{{ 
    console.log(error);
  }}
}});</pre>
                </div>
            </div>
        </div>
</main>
@endsection

@push('scripts')
<script>
// Copy code function
function copyCode(button) {
    const pre = button.closest('.code-block').querySelector('pre');
    const code = pre.textContent;
    
    navigator.clipboard.writeText(code).then(() => {
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        setTimeout(() => {
            button.textContent = originalText;
        }, 2000);
    });
}

// Copy text function
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.querySelector('.nav-links');
    const navActions = document.querySelector('.nav-actions');
    
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navLinks.classList.toggle('open');
            navActions.classList.toggle('open');
        });
    }

    // Nav scroll effect
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
});
</script>
@endpush