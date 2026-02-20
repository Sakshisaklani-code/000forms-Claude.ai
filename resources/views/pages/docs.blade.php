@extends('layouts.app')

@section('title', 'Documentation - 000form')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .docs-wrap { padding: 8rem 0 5rem; }

    .docs-layout {
        display: grid;
        grid-template-columns: 230px 1fr;
        gap: 3rem;
        align-items: start;
    }

    /* ── Sidebar ── */
    .docs-nav {
        position: sticky; top: 6rem;
        border: 1px solid #1e1e1e; border-radius: 10px;
        padding: 1.25rem 0; background: #0d0d0d;
    }
    .docs-nav-label {
        font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #3a3a3a;
        padding: 0 1.25rem; margin-bottom: 0.4rem; margin-top: 1.1rem;
    }
    .docs-nav-label:first-child { margin-top: 0; }
    .docs-nav a {
        display: flex; align-items: center; gap: 0.55rem;
        padding: 0.38rem 1.25rem; font-size: 18px; color: #666;
        text-decoration: none; transition: color 0.15s;
        border-left: 2px solid transparent; margin-left: -1px;
    }
    .docs-nav a i { font-size: 13px; flex-shrink: 0; }
    .docs-nav a:hover { color: #ccc; }
    .docs-nav a.active { color: #00ff88; border-left-color: #00ff88; }

    /* ── Section cards ── */
    .docs-section {
        margin-bottom: 2rem; border: 1px solid #1e1e1e;
        border-radius: 12px; overflow: hidden; background: #0d0d0d;
    }
    .docs-section-header { padding: 1.6rem 1.75rem 0; }
    .docs-section-header h2 {
        font-size: 1.2rem; font-weight: 600; color: #f0f0f0;
        margin: 0 0 0.4rem; display: flex; align-items: center; gap: 0.6rem;
    }
    .docs-section-header h2 .sec-icon {
        width: 30px; height: 30px; border-radius: 7px;
        background: #131313; border: 1px solid #222;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 15px; color: #00ff88; flex-shrink: 0;
    }
    .docs-section-header p { font-size: 14.5px; color: #666; margin: 0 0 1.35rem; line-height: 1.65; }
    .docs-section-body { padding: 0 1.75rem 1.75rem; }

    /* ── Code blocks ── */
    .code-block {
        border-radius: 8px; overflow: hidden;
        border: 1px solid #1e1e1e; margin-bottom: 1rem;
    }
    .code-block:last-child { margin-bottom: 0; }
    .code-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.5rem 1rem; background: #111; border-bottom: 1px solid #1e1e1e;
    }
    .code-lang {
        font-size: 11px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; color: #00ff88; font-family: 'Courier New', monospace;
    }
    .code-copy {
        display: flex; align-items: center; gap: 4px;
        font-size: 11px; color: #555; background: none;
        border: 1px solid #2a2a2a; border-radius: 4px;
        padding: 2px 9px; cursor: pointer; transition: all 0.15s;
    }
    .code-copy:hover { color: #00ff88; border-color: #00ff88; }
    .code-content { padding: 1.1rem 1.25rem; background: #080808; overflow-x: auto; }
    .code-content pre {
        margin: 0; font-family: 'Courier New', monospace;
        font-size: 13.5px; line-height: 1.75; color: #c9c9c9;
    }
    .tag    { color: #7dd3a8; }
    .attr   { color: #9ecbff; }
    .string { color: #f8c77e; }
    .comment{ color: #4a4a4a; font-style: italic; }
    .kw     { color: #c792ea; }
    .fn     { color: #82aaff; }
    .str2   { color: #c3e88d; }

    /* ── Tables ── */
    .sf-table {
        width: 100%; border-collapse: collapse; font-size: 14px;
        border-radius: 8px; overflow: hidden; border: 1px solid #1a1a1a;
    }
    .sf-table th {
        text-align: left; font-size: 11px; font-weight: 700;
        letter-spacing: 1px; text-transform: uppercase; color: #444;
        padding: 0.65rem 1rem; border-bottom: 1px solid #1a1a1a; background: #0a0a0a;
    }
    .sf-table td { padding: 0.8rem 1rem; border-bottom: 1px solid #141414; vertical-align: top; }
    .sf-table tr:last-child td { border-bottom: none; }
    .sf-table tr:hover td { background: #0f0f0f; }
    .sf-table td:first-child { width: 150px; white-space: nowrap; }
    .sf-table td code {
        font-family: 'Courier New', monospace; font-size: 12.5px;
        background: #141414; border: 1px solid #222; border-radius: 4px;
        padding: 2px 7px; color: #00ff88;
    }
    .sf-table td:last-child { color: #777; line-height: 1.65; }
    .sf-table td:last-child .note { display: block; font-size: 12px; color: #444; margin-top: 3px; }

    /* ── Inline code ── */
    .ic {
        font-family: 'Courier New', monospace; font-size: 12.5px;
        background: #141414; border: 1px solid #222; border-radius: 4px;
        padding: 2px 7px; color: #00ff88;
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 10.5px; font-weight: 700; letter-spacing: 0.4px;
        text-transform: uppercase; padding: 2px 8px; border-radius: 4px;
        vertical-align: middle; margin-left: 4px;
    }
    .badge-green  { background: #00ff8818; color: #00ff88; border: 1px solid #00ff8835; }
    .badge-yellow { background: #f8c77e18; color: #f8c77e; border: 1px solid #f8c77e35; }
    .badge-blue   { background: #9ecbff18; color: #9ecbff; border: 1px solid #9ecbff35; }

    /* ── Note boxes ── */
    .note-box {
        background: #0f0f0f; border: 1px solid #1e1e1e;
        border-left: 3px solid #00ff88; border-radius: 6px;
        padding: 0.85rem 1.1rem; font-size: 14px; color: #666;
        margin-top: 1rem; line-height: 1.65;
        display: flex; gap: 0.6rem; align-items: flex-start;
    }
    .note-box i { color: #00ff88; font-size: 15px; margin-top: 1px; flex-shrink: 0; }
    .note-box strong { color: #999; }

    /* ── Quick Start grid ── */
    .qs-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 1rem; margin-bottom: 1.5rem;
    }
    .qs-card {
        background: #0a0a0a; border: 1px solid #1e1e1e;
        border-radius: 10px; padding: 1.25rem;
        display: flex; gap: 0.9rem; align-items: flex-start;
        transition: border-color 0.2s;
    }
    .qs-card:hover { border-color: #2a2a2a; }
    .qs-card-icon {
        width: 38px; height: 38px; border-radius: 9px;
        background: #111; border: 1px solid #1e1e1e;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: #00ff88; flex-shrink: 0;
    }
    .qs-num {
        font-size: 10px; font-weight: 700; color: #00ff88;
        letter-spacing: 1px; text-transform: uppercase; margin-bottom: 3px;
    }
    .qs-card-body h4 { font-size: 14.5px; font-weight: 600; color: #e0e0e0; margin: 0 0 0.3rem; }
    .qs-card-body p  { font-size: 13.5px; color: #666; margin: 0; line-height: 1.55; }
    .qs-card-body a  { color: #00ff88; text-decoration: none; }
    .qs-card-body a:hover { text-decoration: underline; }

    /* ── Limits ── */
    .limits-list { list-style: none; padding: 0; margin: 0; }
    .limits-list li {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.75rem 0; border-bottom: 1px solid #141414;
        font-size: 14.5px; color: #777;
    }
    .limits-list li:last-child { border-bottom: none; }
    .limits-list li i { color: #00ff88; font-size: 15px; flex-shrink: 0; }

    /* ── Group labels ── */
    .section-group-label {
        margin: 2.5rem 0 0.75rem;
        display: flex; align-items: center; gap: 0.6rem;
    }
    .section-group-label span {
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #333; white-space: nowrap;
    }
    .section-group-label::after {
        content: ''; flex: 1; height: 1px; background: #1a1a1a;
    }

    /* ── CTA ── */
    .docs-cta { text-align: center;}
    .docs-cta p { color: #555; font-size: 14.5px; margin-bottom: 1rem; }

    @media (max-width: 860px) {
        .docs-layout { grid-template-columns: 1fr; }
        .docs-nav { display: none; }
        .qs-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="docs-wrap">
    <div class="container">

        <div style="margin-bottom: 2.5rem;">
            <h1>Documentation</h1>
            <p>
                Everything you need to add 000form to your website.
                <a href="{{ route('playground.index') }}" style="color:#00ff88;text-decoration:none;margin-left:0.5rem;">
                    <i class="bi bi-play-circle"></i> Try it in the Playground &rarr;
                </a>
            </p>
        </div>

        <div class="docs-layout">

            {{-- ── SIDEBAR ── --}}
            <nav class="docs-nav">
                <div class="docs-nav-label">Getting Started</div>
                <a href="#quickstart"><i class="bi bi-lightning-charge"></i> Quick Start</a>
                <a href="#basic-form"><i class="bi bi-code-slash"></i> Basic HTML Form</a>

                <div class="docs-nav-label">Special Fields</div>
                <a href="#subject"><i class="bi bi-chat-left-text"></i> _subject</a>
                <a href="#replyto"><i class="bi bi-reply"></i> _replyto</a>
                <a href="#cc"><i class="bi bi-people"></i> _cc</a>
                <a href="#next"><i class="bi bi-arrow-right-circle"></i> _next</a>
                <a href="#template"><i class="bi bi-palette"></i> _template</a>
                <a href="#auto-response"><i class="bi bi-robot"></i> _auto-response</a>
                <a href="#blacklist"><i class="bi bi-slash-circle"></i> _blacklist</a>

                <div class="docs-nav-label">Features</div>
                <a href="#spam"><i class="bi bi-shield-check"></i> Spam Protection</a>
                <a href="#uploads"><i class="bi bi-paperclip"></i> File Uploads</a>
                <a href="#ajax"><i class="bi bi-braces"></i> AJAX / JavaScript</a>

                <div class="docs-nav-label">Reference</div>
                <a href="#limits"><i class="bi bi-bar-chart"></i> Limits</a>
            </nav>

            {{-- ── MAIN CONTENT ── --}}
            <div>

                {{-- Quick Start --}}
                <div class="docs-section" id="quickstart">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-lightning-charge-fill"></i></span>
                            Quick Start
                        </h2>
                        <p>Get a working contact form in under 2 minutes. No backend code needed &mdash; just HTML.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="qs-grid">
                            <div class="qs-card">
                                <div class="qs-card-icon"><i class="bi bi-person-plus"></i></div>
                                <div class="qs-card-body">
                                    <div class="qs-num">Step 1</div>
                                    <h4>Create a free account</h4>
                                    <p>Sign up at <a href="{{ route('signup') }}">000form.com</a>
                                </div>
                            </div>
                            <div class="qs-card">
                                <div class="qs-card-icon"><i class="bi bi-plus-square"></i></div>
                                <div class="qs-card-body">
                                    <div class="qs-num">Step 2</div>
                                    <h4>Create a form</h4>
                                    <p>create form & copy your unique endpoint.</p>
                                </div>
                            </div>
                            <div class="qs-card">
                                <div class="qs-card-icon"><i class="bi bi-link-45deg"></i></div>
                                <div class="qs-card-body">
                                    <div class="qs-num">Step 3</div>
                                    <h4>Point your form to it</h4>
                                    <p>Set your HTML form's <span class="ic">action</span> to your endpoint URL and <span class="ic">method</span> to <span class="ic">POST</span>.</p>
                                </div>
                            </div>
                            <div class="qs-card">
                                <div class="qs-card-icon"><i class="bi bi-check2-circle"></i></div>
                                <div class="qs-card-body">
                                    <div class="qs-num">Step 4</div>
                                    <h4>You're done!</h4>
                                    <p>Every submission goes straight to your email and shows up in your dashboard.</p>
                                </div>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-play-circle-fill"></i>
                            <span>Not ready to sign up yet? <a href="{{ route('playground.index') }}" style="color:#00ff88;text-decoration:none;font-weight:600;">Try the Playground</a> &mdash; test everything right now with no account needed.</span>
                        </div>
                    </div>
                </div>

                {{-- Basic HTML Form --}}
                <div class="docs-section" id="basic-form">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-code-slash"></i></span>
                            Basic HTML Form
                        </h2>
                        <p>The simplest setup &mdash; just point your form's <span class="ic">action</span> to your endpoint URL and you're ready to go.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">HTML</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre><span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"https://000form.com/f/YOUR_FORM_ID"</span> <span class="attr">method</span>=<span class="string">"POST"</span><span class="tag">&gt;</span>

  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>    <span class="attr">placeholder</span>=<span class="string">"Your name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>   <span class="attr">placeholder</span>=<span class="string">"Your email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span>           <span class="attr">name</span>=<span class="string">"message"</span> <span class="attr">placeholder</span>=<span class="string">"Your message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>

  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send<span class="tag">&lt;/button&gt;</span>

<span class="tag">&lt;/form&gt;</span></pre>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>Name your email field <strong>email</strong> and we'll automatically set it as the reply-to address &mdash; so you can reply directly to the person from your inbox.</span>
                        </div>
                    </div>
                </div>

                {{-- Special Fields group label --}}
                <div class="section-group-label"><span>Special Fields</span></div>
                <p style="font-size:14px;color:#555;margin:-0.25rem 0 1.5rem;">Add these as hidden inputs to your form to turn on extra features. All of them are optional &mdash; only use the ones you need.</p>

                {{-- _subject --}}
                <div class="docs-section" id="subject">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-chat-left-text"></i></span>
                            _subject
                            <span class="badge badge-green"><i class="bi bi-circle"></i> Optional</span>
                        </h2>
                        <p>Set a custom subject line on the email you receive. If you don't add this, the subject will be <span class="ic">New Form Submission from 000form</span>.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_subject"</span> <span class="attr">value</span>=<span class="string">"New contact from website"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- _replyto --}}
                <div class="docs-section" id="replyto">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-reply"></i></span>
                            _replyto
                            <span class="badge badge-green"><i class="bi bi-circle"></i> Optional</span>
                        </h2>
                        <p>Name your email field <span class="ic">email</span> and we'll automatically set it as the reply-to address — so you can reply directly to the person from your inbox.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span> <span class="attr">placeholder</span>=<span class="string">"Your email"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- _cc --}}
                <div class="docs-section" id="cc">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-people"></i></span>
                            _cc
                            <span class="badge badge-green"><i class="bi bi-circle"></i> Optional</span>
                        </h2>
                        <p>Send a copy of the notification email to one or more extra addresses. Good for when more than one person needs to see each submission.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="comment">&lt;!-- One address --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_cc"</span> <span class="attr">value</span>=<span class="string">"team@yourcompany.com"</span><span class="tag">&gt;</span>

<span class="comment">&lt;!-- Multiple addresses — separate with commas --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_cc"</span> <span class="attr">value</span>=<span class="string">"sales@co.com, support@co.com"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- _next --}}
                <div class="docs-section" id="next">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-arrow-right-circle"></i></span>
                            _next
                            <span class="badge badge-green"><i class="bi bi-circle"></i> Optional</span>
                        </h2>
                        <p>Send the user to your own thank-you page after they submit. Without this, they'll land on the default 000form confirmation page.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_next"</span> <span class="attr">value</span>=<span class="string">"https://yoursite.com/thank-you"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>When using AJAX, <span class="ic">_next</span> comes back in the JSON response as <span class="ic">redirect</span>. Your JavaScript can then send the user there.</span>
                        </div>
                    </div>
                </div>

                {{-- _template --}}
                <div class="docs-section" id="template">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-palette"></i></span>
                            _template
                            <span class="badge badge-blue"><i class="bi bi-grid"></i> 3 options</span>
                        </h2>
                        <p>Choose how your notification email looks. If you don't pick one, <span class="ic">basic</span> is used by default.</p>
                    </div>
                    <div class="docs-section-body">
                        <table class="sf-table" style="margin-bottom:1.1rem;">
                            <thead><tr><th>Value</th><th>What it looks like</th></tr></thead>
                            <tbody>
                                <tr>
                                    <td><code>basic</code></td>
                                    <td>Simple list &mdash; one field per row. Clean and easy to read. <span class="note">Used by default.</span></td>
                                </tr>
                                <tr>
                                    <td><code>box</code></td>
                                    <td>Each field gets its own bordered box. Images show as previews inside the email.</td>
                                </tr>
                                <tr>
                                    <td><code>table</code></td>
                                    <td>Two-column table &mdash; field name on the left, value on the right.</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_template"</span> <span class="attr">value</span>=<span class="string">"basic"</span><span class="tag">&gt;</span>   <span class="comment">&lt;!-- default --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_template"</span> <span class="attr">value</span>=<span class="string">"box"</span><span class="tag">&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_template"</span> <span class="attr">value</span>=<span class="string">"table"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- _auto-response --}}
                <div class="docs-section" id="auto-response">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-robot"></i></span>
                            _auto-response
                            <span class="badge badge-green"><i class="bi bi-circle"></i> Optional</span>
                        </h2>
                        <p>Send an automatic reply to the person who filled in your form. Your form needs an <span class="ic">email</span> field for this to work.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML &mdash; message only</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="comment">&lt;!-- A default subject line is added for you --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_auto-response"</span>
       <span class="attr">value</span>=<span class="string">"Thanks for getting in touch! We'll get back to you shortly."</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML &mdash; with your own subject line (use a pipe | to separate)</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_auto-response"</span>
       <span class="attr">value</span>=<span class="string">"Hi {name}, we got your message on {date}.|We received your message!"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                        <table class="sf-table" style="margin-top:1.1rem;">
                            <thead><tr><th>Placeholder</th><th>Gets replaced with</th></tr></thead>
                            <tbody>
                                <tr><td><code>{name}</code></td><td>What the user typed in the <code>name</code> field</td></tr>
                                <tr><td><code>{email}</code></td><td>What the user typed in the <code>email</code> field</td></tr>
                                <tr><td><code>{date}</code></td><td>Today's date (YYYY-MM-DD)</td></tr>
                            </tbody>
                        </table>
                        <div class="note-box" style="margin-top:1rem;">
                            <i class="bi bi-shield-check"></i>
                            <span>If a submission gets blocked by <span class="ic">_blacklist</span>, the auto-response is still sent &mdash; so the user always gets a confirmation.</span>
                        </div>
                    </div>
                </div>

                {{-- _blacklist --}}
                <div class="docs-section" id="blacklist">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-slash-circle"></i></span>
                            _blacklist
                            <span class="badge badge-yellow"><i class="bi bi-funnel"></i> Spam filter</span>
                        </h2>
                        <p>Block submissions that contain certain words. If any field in the form has a banned word, the email is dropped before it reaches your inbox. The person still sees a success message, so they won't know it was blocked.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="comment">&lt;!-- Separate banned words or phrases with commas --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"hidden"</span> <span class="attr">name</span>=<span class="string">"_blacklist"</span>
       <span class="attr">value</span>=<span class="string">"buy now, click here, casino, free money"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>Upper and lower case don't matter &mdash; <strong>BUY NOW</strong>, <strong>buy now</strong>, and <strong>Buy Now</strong> are all caught.</span>
                        </div>
                    </div>
                </div>

                {{-- Features group label --}}
                <div class="section-group-label"><span>Features</span></div>

                {{-- Spam Protection --}}
                <div class="docs-section" id="spam">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-shield-check"></i></span>
                            Spam Protection (Honeypot)
                        </h2>
                        <p>Add a hidden field that spam bots fill in on their own. Real people never see it, so only bots trigger it. Any submission with this field filled in gets dropped.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="comment">&lt;!-- Hidden from people — bots fill it in, which triggers the block --&gt;</span>
<span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span> <span class="attr">name</span>=<span class="string">"_gotcha"</span>
       <span class="attr">style</span>=<span class="string">"display:none;"></span></pre>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-lightbulb-fill"></i>
                            <span>Using both <span class="ic">_gotcha</span> and <span class="ic">_blacklist</span> together stops most spam before it reaches you.</span>
                        </div>
                    </div>
                </div>

                {{-- File Uploads --}}
                <div class="docs-section" id="uploads">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-paperclip"></i></span>
                            File Uploads
                        </h2>
                        <p>Let people attach files when they submit. Files are sent as email attachments. With the <span class="ic">box</span> template, images also show up as previews inside the email.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML &mdash; one file</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> <span class="attr">name</span>=<span class="string">"upload"</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML &mdash; multiple files</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span> <span class="attr">name</span>=<span class="string">"uploads[]"</span> <span class="attr">multiple</span><span class="tag">&gt;</span></pre>
                            </div>
                        </div>
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">HTML &mdash; full form with file upload</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="comment">&lt;!-- Add enctype="multipart/form-data" whenever you use file inputs --&gt;</span>
<span class="tag">&lt;form</span> <span class="attr">action</span>=<span class="string">"https://000form.com/f/YOUR_FORM_ID"</span>
      <span class="attr">method</span>=<span class="string">"POST"</span>
      <span class="attr">enctype</span>=<span class="string">"multipart/form-data"</span><span class="tag">&gt;</span>

  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"text"</span>  <span class="attr">name</span>=<span class="string">"name"</span>      <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"email"</span> <span class="attr">name</span>=<span class="string">"email"</span>     <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="string">"file"</span>  <span class="attr">name</span>=<span class="string">"uploads[]"</span> <span class="attr">multiple</span><span class="tag">&gt;</span>

  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="string">"submit"</span><span class="tag">&gt;</span>Send<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span></pre>
                            </div>
                        </div>
                        <table class="sf-table" style="margin-top:1rem;">
                            <thead><tr><th>Limit</th><th>Value</th></tr></thead>
                            <tbody>
                                <tr><td><code>Per file</code></td><td>10 MB max</td></tr>
                                <tr><td><code>Per submission</code></td><td>Up to 5 files</td></tr>
                                <tr><td><code>enctype</code></td><td>Must be <code>multipart/form-data</code> &mdash; required for file inputs to work</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- AJAX --}}
                <div class="docs-section" id="ajax">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-braces"></i></span>
                            AJAX / JavaScript
                        </h2>
                        <p>Submit the form without reloading the page. Add <span class="ic">Accept: application/json</span> to your request and you'll get a JSON response back instead of a page redirect.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header"><span class="code-lang">JavaScript</span><button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button></div>
                            <div class="code-content">
<pre><span class="kw">const</span> form = document.<span class="fn">getElementById</span>(<span class="str2">'YOUR-FORM-ID'</span>);
<span class="kw">const</span> responseBox = document.<span class="fn">getElementById</span>(<span class="str2">'form-response'</span>);

form.<span class="fn">addEventListener</span>(<span class="str2">'submit'</span>, <span class="kw">async</span> (e) => {
  e.<span class="fn">preventDefault</span>();

  <span class="kw">const</span> btn = form.<span class="fn">querySelector</span>(<span class="str2">'button[type="submit"]'</span>);
  btn.disabled = <span class="kw">true</span>;
  btn.textContent = <span class="str2">'Sending...'</span>;

  <span class="kw">try</span> {
    <span class="kw">const</span> res  = <span class="kw">await</span> <span class="fn">fetch</span>(form.action, {
      method:  <span class="str2">'POST'</span>,
      body:    <span class="kw">new</span> <span class="fn">FormData</span>(form),
      headers: { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> }
    });
    <span class="kw">const</span> data = <span class="kw">await</span> res.<span class="fn">json</span>();

    <span class="kw">if</span> (res.ok && data.success) {
      responseBox.innerHTML = <span class="str2">'&lt;span style="color:#00ff88"&gt;&#10003; Message sent!&lt;/span&gt;'</span>;
      form.<span class="fn">reset</span>();
      <span class="comment">// If _next is set, send the user there</span>
      <span class="kw">if</span> (data.redirect) location.href = data.redirect;
    } <span class="kw">else</span> {
      <span class="kw">throw new</span> <span class="fn">Error</span>(data.message || <span class="str2">'Something went wrong'</span>);
    }
  } <span class="kw">catch</span> (err) {
    responseBox.innerHTML = <span class="str2">`&lt;span style="color:#ef4444"&gt;&#10007; ${err.message}&lt;/span&gt;`</span>;
  } <span class="kw">finally</span> {
    btn.disabled = <span class="kw">false</span>;
    btn.textContent = <span class="str2">'Send Message'</span>;
  }
});</pre>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>Add <span class="ic">&lt;div id="form-response"&gt;&lt;/div&gt;</span> inside your form HTML &mdash; that's where the success or error message will show. The JSON response always has <span class="ic">success</span> (true/false) and <span class="ic">message</span> (text).</span>
                        </div>
                    </div>
                </div>

                {{-- Limits --}}
                <div class="docs-section" id="limits">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-bar-chart"></i></span>
                            Limits
                        </h2>
                        <p>Everything included on the free plan.</p>
                    </div>
                    <div class="docs-section-body">
                        <ul class="limits-list">
                            <li><i class="bi bi-envelope-check"></i> Email notification on every submission</li>
                            <li><i class="bi bi-database"></i> Submission history stored in your dashboard</li>
                            <li><i class="bi bi-download"></i> Export submissions as CSV</li>
                            <li><i class="bi bi-paperclip"></i> Up to 5 file attachments per submission (10 MB each)</li>
                        </ul>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="docs-cta">
                    <p>Ready to get started?</p>
                    <a href="{{ route('playground.index') }}" class="btn btn-secondary" style="margin-right:0.75rem;">
                        <i class="bi bi-play-circle"></i> Try Playground
                    </a>
                    <a href="{{ route('signup') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Create Free Account
                    </a>
                </div>

            </div>{{-- end main --}}
        </div>{{-- end docs-layout --}}
    </div>
</div>

<script>
document.querySelectorAll('.code-copy').forEach(btn => {
    btn.addEventListener('click', function() {
        const pre = this.closest('.code-block').querySelector('pre');
        navigator.clipboard.writeText(pre.innerText).then(() => {
            this.innerHTML = '<i class="bi bi-check2"></i> Copied!';
            this.style.color = '#00ff88';
            this.style.borderColor = '#00ff88';
            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
                this.style.color = '';
                this.style.borderColor = '';
            }, 2000);
        });
    });
});

const sections = document.querySelectorAll('.docs-section');
const navLinks  = document.querySelectorAll('.docs-nav a');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            navLinks.forEach(l => l.classList.remove('active'));
            const active = document.querySelector(`.docs-nav a[href="#${entry.target.id}"]`);
            if (active) active.classList.add('active');
        }
    });
}, { rootMargin: '-20% 0px -70% 0px' });
sections.forEach(s => observer.observe(s));
</script>

@endsection
