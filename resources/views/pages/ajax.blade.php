@extends('layouts.app')

@section('title', 'AJAX - 000forms')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap');

  :root {
    --bg:      #0d0d0d;
    --card:    #141414;
    --card2:   #1a1a1a;
    --border:  #2a2a2a;
    --text:    #e5e5e5;
    --muted:   #6b6b6b;
    --green:   #00e87a;
    --green-d: rgba(0,232,122,0.12);
    --green-b: rgba(0,232,122,0.28);
    --red:     #f04444;
    --yellow:  #fbbf24;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  .ajax-wrap {
    display: flex;
    background: var(--bg);
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    color: var(--text);
    font-size: 14px;
    line-height: 1.7;
  }

  /* ════════════════════════════════
     SIDEBAR
  ════════════════════════════════ */
  .ajax-sidebar {
    width: 240px;
    flex-shrink: 0;
    border-right: 1px solid var(--border);
    padding: 6rem 14px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
  }

  .sb-section { margin-bottom: 24px; }

  .sb-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 0 10px 8px;
    display: block;
  }

  .sb-link {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 11px;
    border-radius: 9px;
    color: var(--muted);
    text-decoration: none;
    font-size: 13px;
    font-weight: 400;
    border: 1px solid transparent;
    margin-bottom: 2px;
    transition: color 0.15s, background 0.15s;
    cursor: pointer;
  }
  .sb-link:hover { color: var(--text); background: rgba(255,255,255,0.04); }
  .sb-link.active {
    background: var(--green-d);
    border-color: var(--green-b);
    color: var(--green);
    font-weight: 500;
  }

  .sb-icon {
    width: 24px; height: 24px;
    border-radius: 6px;
    background: rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
  }
  .sb-link.active .sb-icon { background: var(--green-d); }

  .sb-divider {
    height: 1px;
    background: var(--border);
    margin: 8px 0 20px;
  }

  /* "Test" label special styling */
  .sb-label-test {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--green);
    padding: 0 10px 8px;
    display: block;
    opacity: 0.8;
  }

  /* ════════════════════════════════
     MAIN
  ════════════════════════════════ */
  .ajax-main {
    flex: 1;
    padding: 6rem 30px 20px;
    max-width: 880px;
  }

  /* ── Page header ── */
  .page-head {
    margin-bottom: 24px;
    padding-bottom: 22px;
    border-bottom: 1px solid var(--border);
  }
  .page-tag {
    display: inline-block;
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--green);
    background: var(--green-d);
    border: 1px solid var(--green-b);
    border-radius: 20px;
    padding: 3px 10px;
    margin-bottom: 10px;
  }
  .page-head h1 {
    font-size: 1.5rem;
    font-weight: 600;
    letter-spacing: -0.02em;
    margin-bottom: 6px;
    color: var(--text);
  }
  .page-head p { color: var(--muted); font-size: 13px; max-width: 480px; }

  .endpoint-row {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-top: 14px;
    background: var(--card2);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 14px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 12px;
  }
  .ep-method {
    background: var(--green);
    color: #000;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.08em;
    padding: 2px 8px;
    border-radius: 4px;
  }
  .ep-url em { color: var(--green); font-style: normal; }

  /* ── Section cards ── */
  .section-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 13px;
    padding: 20px 22px;
    margin-bottom: 14px;
    scroll-margin-top: 20px;
  }

  .section-card h2 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .h2-sub { font-size: 12px; font-weight: 400; color: var(--muted); }

  .section-card p { color: var(--muted); font-size: 13px; margin-bottom: 10px; }

  .section-card h3 {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--muted);
    margin: 18px 0 8px;
  }

  code {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px;
    background: var(--card2);
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 1px 5px;
    color: var(--green);
  }

  /* ── Code block ── */
  .code-block {
    background: var(--card2);
    border: 1px solid var(--border);
    border-radius: 9px;
    overflow: hidden;
    margin: 10px 0;
  }
  .code-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 13px;
    border-bottom: 1px solid var(--border);
  }
  .code-lang {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
  }
  .copy-btn {
    background: none;
    border: 1px solid var(--border);
    border-radius: 5px;
    padding: 2px 9px;
    font-size: 11px;
    font-family: 'JetBrains Mono', monospace;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.12s;
  }
  .copy-btn:hover  { border-color: var(--green); color: var(--green); }
  .copy-btn.copied { border-color: var(--green); color: var(--green); }

  pre {
    padding: 15px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 12px;
    line-height: 1.75;
    overflow-x: auto;
    color: #b0b8c8;
  }

  /* syntax */
  .kw   { color: #60a5fa; font-weight: 500; }
  .str  { color: #86efac; }
  .cm   { color: #4b5563; font-style: italic; }
  .fn   { color: #c084fc; }
  .nm   { color: #fb923c; }
  .htag { color: #f87171; }
  .at   { color: #60a5fa; }
  .val  { color: #86efac; }
  .hl   { color: var(--green); }

  /* ── Callout ── */
  .callout {
    border-radius: 8px;
    padding: 10px 13px;
    margin: 10px 0;
    font-size: 12.5px;
    border-left: 3px solid;
  }
  .callout.tip  { background: rgba(0,232,122,0.07);  border-color: var(--green); color: #a7f3d0; }
  .callout.warn { background: rgba(251,191,36,0.07); border-color: #fbbf24;     color: #fde68a; }
  .callout.info { background: rgba(96,165,250,0.07); border-color: #60a5fa;     color: #bfdbfe; }
  .callout strong { font-weight: 600; }

  /* ── Table ── */
  table { width: 100%; border-collapse: collapse; font-size: 12.5px; margin: 10px 0; }
  th {
    text-align: left; font-size: 10px; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--muted); font-weight: 500;
    padding: 7px 12px; border-bottom: 1px solid var(--border);
  }
  td {
    padding: 9px 12px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    color: var(--muted); vertical-align: top;
  }
  td:first-child { font-family: 'JetBrains Mono', monospace; font-size: 11px; color: var(--green); white-space: nowrap; }
  td:nth-child(2) { color: var(--text); }
  tr:hover td { background: rgba(255,255,255,0.02); }

  /* ── Response grid ── */
  .res-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 10px 0; }
  .res-card { background: #0f0f0f; border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
  .res-head {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 13px; border-bottom: 1px solid var(--border);
    font-family: 'JetBrains Mono', monospace; font-size: 11px;
  }
  .rdot { width: 7px; height: 7px; border-radius: 50%; }
  .res-card.ok  .res-head { color: var(--green); }
  .res-card.ok  .rdot     { background: var(--green); }
  .res-card.err .res-head { color: var(--red); }
  .res-card.err .rdot     { background: var(--red); }
  .res-card pre { font-size: 11px; padding: 13px; }

  /* ════════════════════════════════
     TEST AJAX SECTION
  ════════════════════════════════ */
  .test-section {
    background: var(--card);
    border: 1px solid var(--green-b);
    border-radius: 13px;
    padding: 20px 22px;
    margin-bottom: 14px;
    scroll-margin-top: 20px;
  }

  .test-section h2 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .test-badge {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #000;
    background: var(--green);
    border-radius: 4px;
    padding: 2px 7px;
  }
  .test-section > p { color: var(--muted); font-size: 13px; margin-bottom: 16px; }

  /* Endpoint input */
  .test-endpoint {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--card2);
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 9px 14px;
    margin-bottom: 16px;
  }
  .test-endpoint label {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    white-space: nowrap;
  }
  .test-endpoint input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font-family: 'JetBrains Mono', monospace;
    font-size: 12px;
    color: var(--green);
  }
  .test-endpoint input::placeholder { color: var(--muted); }

  /* Tabs */
  .test-tabs {
    display: flex;
    gap: 5px;
    background: var(--card2);
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 5px;
    margin-bottom: 16px;
  }
  .test-tab {
    flex: 1;
    background: none;
    border: 1px solid transparent;
    border-radius: 6px;
    padding: 7px 10px;
    font-size: 12px;
    font-weight: 500;
    font-family: 'Inter', sans-serif;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.15s;
    text-align: center;
  }
  .test-tab:hover { color: var(--text); }
  .test-tab.active {
    background: var(--green-d);
    border-color: var(--green-b);
    color: var(--green);
  }

  /* Panel */
  .test-panel { display: none; }
  .test-panel.active { display: block; }

  /* Two column */
  .test-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  /* Form fields */
  .t-card {
    background: var(--card2);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px;
  }
  .t-card-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 12px;
  }
  .t-field { margin-bottom: 10px; }
  .t-field label { display: block; font-size: 11px; color: var(--muted); margin-bottom: 4px; }
  .t-field input,
  .t-field textarea {
    width: 100%;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 7px;
    padding: 8px 11px;
    color: var(--text);
    font-size: 12.5px;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: border-color 0.15s;
  }
  .t-field input:focus,
  .t-field textarea:focus { border-color: var(--green-b); }
  .t-field input::placeholder,
  .t-field textarea::placeholder { color: var(--muted); }
  .t-field textarea { resize: vertical; min-height: 64px; }

  .t-send-btn {
    width: 100%;
    background: var(--green);
    color: #000;
    border: none;
    border-radius: 7px;
    padding: 10px;
    font-size: 12.5px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: opacity 0.15s;
    margin-top: 2px;
  }
  .t-send-btn:hover    { opacity: 0.85; }
  .t-send-btn:disabled { opacity: 0.4; cursor: not-allowed; }

  /* Response */
  .t-response-col { display: flex; flex-direction: column; gap: 12px; }

  .t-response {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    flex: 1;
  }
  .t-res-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 13px;
    border-bottom: 1px solid var(--border);
  }
  .t-res-label {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--muted);
  }
  .t-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px;
  }
  .t-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--muted); }
  .t-dot.ok   { background: var(--green); }
  .t-dot.err  { background: var(--red); }
  .t-dot.wait { background: var(--yellow); animation: blink 1s infinite; }
  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

  .t-res-body {
    padding: 13px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 11.5px;
    line-height: 1.7;
    color: var(--muted);
    min-height: 56px;
    white-space: pre-wrap;
    word-break: break-all;
  }
  .t-res-body.ok  { color: var(--green); }
  .t-res-body.err { color: var(--red); }

  /* Code snippet inside test */
  .t-code {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
  }
  .t-code-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 13px;
    border-bottom: 1px solid var(--border);
  }
  .t-code pre { font-size: 11px; padding: 13px; }

  @media (max-width: 800px) {
    .ajax-sidebar { display: none; }
    .ajax-main    { padding: 20px 14px 60px; }
    .res-grid     { grid-template-columns: 1fr; }
    .test-grid    { grid-template-columns: 1fr; }
  }
</style>

<div class="ajax-wrap">

  <!-- ══════════ SIDEBAR ══════════ -->
  <aside class="ajax-sidebar">

    <div class="sb-section">
      <span class="sb-label">Methods</span>
      <a href="#overview" class="sb-link active">
        <span class="sb-icon">◎</span> Overview
      </a>
      <a href="#fetch" class="sb-link">
        <span class="sb-icon">⚡</span> Fetch API
      </a>
      <a href="#jquery" class="sb-link">
        <span class="sb-icon">＄</span> jQuery
      </a>
      <a href="#axios" class="sb-link">
        <span class="sb-icon">⬡</span> Axios
      </a>
    </div>

    <div class="sb-section">
      <span class="sb-label">Reference</span>
      <a href="#attributes" class="sb-link">
        <span class="sb-icon">≡</span> Attributes
      </a>
      <a href="#responses" class="sb-link">
        <span class="sb-icon">↵</span> Responses
      </a>
      <a href="#tips" class="sb-link">
        <span class="sb-icon">★</span> Tips
      </a>
    </div>

    <div class="sb-divider"></div>

    <div class="sb-section">
      <span class="sb-label-test">Test</span>
      <a href="#test-ajax" class="sb-link">
        <span class="sb-icon">▶</span> Test AJAX
      </a>
    </div>

  </aside>

  <!-- ══════════ MAIN ══════════ -->
  <main class="ajax-main">

    <!-- Page header -->
    <div class="page-head">
      <div class="page-tag">Developer Docs</div>
      <h1>AJAX Form Submission</h1>
      <p>Submit forms without a page reload. Add one header and you're done.</p>
      <div class="endpoint-row">
        <span class="ep-method">POST</span>
        <span class="ep-url">https://000forms.com/f/<em>YOUR_TOKEN</em></span>
      </div>
    </div>

    <!-- Overview -->
    <div class="section-card" id="overview">
      <h2>Overview</h2>
      <p>Point your request at your 000forms endpoint and include the <code>Accept: application/json</code> header. That's all — 000forms returns JSON instead of redirecting the page.</p>
      <div class="callout tip">
        <strong>Your token —</strong> Replace <code>YOUR_TOKEN</code> with the token from your dashboard (e.g. <code>f_l63kxxnb</code>).
      </div>
    </div>

    <!-- Fetch -->
    <div class="section-card" id="fetch">
      <h2>Fetch API <span class="h2-sub">— Recommended</span></h2>
      <p>Modern and promise-based. Works natively in all current browsers, no library needed.</p>

      <div class="code-block">
        <div class="code-top"><span class="code-lang">HTML</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
        <pre>&lt;<span class="htag">form</span> <span class="at">id</span>=<span class="val">"myForm"</span>&gt;
  &lt;<span class="htag">input</span> <span class="at">type</span>=<span class="val">"text"</span>  <span class="at">name</span>=<span class="val">"name"</span>    <span class="at">required</span>&gt;
  &lt;<span class="htag">input</span> <span class="at">type</span>=<span class="val">"email"</span> <span class="at">name</span>=<span class="val">"email"</span>   <span class="at">required</span>&gt;
  &lt;<span class="htag">textarea</span>            <span class="at">name</span>=<span class="val">"message"</span>&gt;&lt;/<span class="htag">textarea</span>&gt;
  &lt;<span class="htag">button</span> <span class="at">type</span>=<span class="val">"submit"</span>&gt;Send&lt;/<span class="htag">button</span>&gt;
&lt;/<span class="htag">form</span>&gt;
&lt;<span class="htag">div</span> <span class="at">id</span>=<span class="val">"status"</span>&gt;&lt;/<span class="htag">div</span>&gt;</pre>
      </div>

      <div class="code-block">
        <div class="code-top"><span class="code-lang">JavaScript</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
        <pre><span class="kw">const</span> form = document.<span class="fn">getElementById</span>(<span class="str">'myForm'</span>);

form.<span class="fn">addEventListener</span>(<span class="str">'submit'</span>, <span class="kw">async</span> (e) =&gt; {
  e.<span class="fn">preventDefault</span>();

  <span class="kw">const</span> res  = <span class="kw">await</span> <span class="fn">fetch</span>(<span class="str">'https://000forms.com/f/<span class="hl">YOUR_TOKEN</span>'</span>, {
    method:  <span class="str">'POST'</span>,
    headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> },
    body:    <span class="kw">new</span> <span class="fn">FormData</span>(form)
  });
  <span class="kw">const</span> data = <span class="kw">await</span> res.<span class="fn">json</span>();

  document.<span class="fn">getElementById</span>(<span class="str">'status'</span>).textContent =
    res.ok ? <span class="str">'✓ '</span> + data.message : <span class="str">'✗ '</span> + data.message;

  <span class="kw">if</span> (res.ok) form.<span class="fn">reset</span>();
});</pre>
      </div>
    </div>

    <!-- jQuery -->
    <div class="section-card" id="jquery">
      <h2>jQuery AJAX</h2>
      <p>If jQuery is already loaded in your project.</p>

      <div class="code-block">
        <div class="code-top"><span class="code-lang">JavaScript</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
        <pre>$(<span class="str">'#myForm'</span>).<span class="fn">on</span>(<span class="str">'submit'</span>, <span class="kw">function</span>(e) {
  e.<span class="fn">preventDefault</span>();

  $.<span class="fn">ajax</span>({
    url:         <span class="str">'https://000forms.com/f/<span class="hl">YOUR_TOKEN</span>'</span>,
    method:      <span class="str">'POST'</span>,
    data:        <span class="kw">new</span> <span class="fn">FormData</span>(<span class="kw">this</span>),
    dataType:    <span class="str">'json'</span>,
    processData: <span class="kw">false</span>,
    contentType: <span class="kw">false</span>,
    headers:     { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> },
    success: (data) =&gt; $(<span class="str">'#status'</span>).<span class="fn">text</span>(<span class="str">'✓ '</span> + data.message),
    error:   (xhr)  =&gt; $(<span class="str">'#status'</span>).<span class="fn">text</span>(<span class="str">'✗ '</span> + JSON.<span class="fn">parse</span>(xhr.responseText).message)
  });
});</pre>
      </div>

      <div class="callout warn">
        <strong>Note —</strong> Always set <code>processData: false</code> and <code>contentType: false</code> when passing <code>FormData</code> to jQuery.
      </div>
    </div>

    <!-- Axios -->
    <div class="section-card" id="axios">
      <h2>Axios</h2>
      <p>Common in Vue and React projects. Handles JSON automatically.</p>

      <div class="code-block">
        <div class="code-top"><span class="code-lang">JavaScript</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
        <pre>form.<span class="fn">addEventListener</span>(<span class="str">'submit'</span>, <span class="kw">async</span> (e) =&gt; {
  e.<span class="fn">preventDefault</span>();

  <span class="kw">try</span> {
    <span class="kw">const</span> { data } = <span class="kw">await</span> axios.<span class="fn">post</span>(
      <span class="str">'https://000forms.com/f/<span class="hl">YOUR_TOKEN</span>'</span>,
      <span class="kw">new</span> <span class="fn">FormData</span>(e.target),
      { headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> } }
    );
    console.<span class="fn">log</span>(data.message);
    e.target.<span class="fn">reset</span>();
  } <span class="kw">catch</span> (err) {
    console.<span class="fn">error</span>(err.response?.data?.message);
  }
});</pre>
      </div>
    </div>

    <!-- Attributes -->
    <div class="section-card" id="attributes">
      <h2>Special Attributes</h2>
      <p>Add these as hidden inputs inside your form to control behaviour.</p>
      <table>
        <thead><tr><th>Name</th><th>Description</th><th>Example</th></tr></thead>
        <tbody>
          <tr><td>_subject</td><td>Email subject line</td><td>New contact</td></tr>
          <tr><td>_redirect</td><td>Redirect URL (non-AJAX only)</td><td>https://yoursite.com/thanks</td></tr>
          <tr><td>_cc</td><td>CC to another address</td><td>admin@yoursite.com</td></tr>
          <tr><td>_autoresponse</td><td>Auto-reply to the submitter</td><td>Thanks! We'll reply soon.</td></tr>
          <tr><td>_template</td><td>Email template style</td><td>table / box / basic</td></tr>
          <tr><td>_honeypot</td><td>Spam trap field (hide with CSS)</td><td>_honey</td></tr>
        </tbody>
      </table>
    </div>

    <!-- Responses -->
    <div class="section-card" id="responses">
      <h2>JSON Responses</h2>
      <p>When <code>Accept: application/json</code> is set, you always receive JSON — never a redirect.</p>
      <div class="res-grid">
        <div class="res-card ok">
          <div class="res-head"><span class="rdot"></span>200 — Success</div>
          <pre>{\n  "success": true,\n  "message": "Form submitted."\n}</pre>
        </div>
        <div class="res-card err">
          <div class="res-head"><span class="rdot"></span>422 — Error</div>
          <pre>{\n  "success": false,\n  "message": "Validation failed",\n  "errors": { "email": "Required" }\n}</pre>
        </div>
      </div>
      <div class="callout info">
        <strong>Status codes —</strong> <code>200</code> sent &nbsp;·&nbsp; <code>422</code> validation failed &nbsp;·&nbsp; <code>429</code> rate limited
      </div>
    </div>

    <!-- Tips -->
    <div class="section-card" id="tips">
      <h2>Tips</h2>
      <h3>Disable button while sending</h3>
      <div class="code-block">
        <div class="code-top"><span class="code-lang">JavaScript</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
        <pre><span class="kw">const</span> btn = form.<span class="fn">querySelector</span>(<span class="str">'button[type="submit"]'</span>);
btn.disabled    = <span class="kw">true</span>;
btn.textContent = <span class="str">'Sending…'</span>;
<span class="cm">// re-enable in finally block</span></pre>
      </div>
      <h3>Send as JSON body</h3>
      <div class="code-block">
        <div class="code-top"><span class="code-lang">JavaScript</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
        <pre><span class="kw">const</span> payload = <span class="fn">Object</span>.<span class="fn">fromEntries</span>(<span class="kw">new</span> <span class="fn">FormData</span>(form));
<span class="fn">fetch</span>(url, {
  method: <span class="str">'POST'</span>,
  headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span>, <span class="str">'Content-Type'</span>: <span class="str">'application/json'</span> },
  body: JSON.<span class="fn">stringify</span>(payload)
});</pre>
      </div>
      <div class="callout tip">
        <strong>CORS —</strong> 000forms allows cross-origin requests from any domain by default.
      </div>
    </div>

    <!-- ══════════ TEST AJAX ══════════ -->
    <div class="test-section" id="test-ajax">
      <h2><span class="test-badge">Live</span> Test AJAX</h2>
      <p>Send real requests to your endpoint and see the live JSON response instantly.</p>

      <!-- Endpoint bar -->
      <div class="test-endpoint">
        <label>Endpoint</label>
        <input type="text" id="testEndpoint"
               value=""
               placeholder="Enter Your Endpoint like - http://000forms/f/YOUR_TOKEN">
      </div>

      <!-- Method tabs -->
      <div class="test-tabs">
        <button class="test-tab active" onclick="switchTestTab('fetch')">⚡ Fetch</button>
        <button class="test-tab"       onclick="switchTestTab('jquery')">＄ jQuery</button>
        <button class="test-tab"       onclick="switchTestTab('axios')">⬡ Axios</button>
      </div>

      <!-- ── Fetch panel ── -->
      <div class="test-panel active" id="tp-fetch">
        <div class="test-grid">
          <div class="t-card">
            <div class="t-card-label">Form Data</div>
            <div class="t-field"><label>Name</label><input type="text" id="f-name" value="John Doe"></div>
            <div class="t-field"><label>Email</label><input type="email" id="f-email" value="john@example.com"></div>
            <div class="t-field"><label>Message</label><textarea id="f-msg">Testing Fetch API</textarea></div>
            <button class="t-send-btn" id="f-btn" onclick="testFetch()">▶ Send via Fetch</button>
          </div>
          <div class="t-response-col">
            <div class="t-response">
              <div class="t-res-head">
                <span class="t-res-label">Response</span>
                <span class="t-status"><span class="t-dot" id="f-dot"></span><span id="f-stat">Waiting…</span></span>
              </div>
              <div class="t-res-body" id="f-body">Hit Send to see live response.</div>
            </div>
            <div class="t-code">
              <div class="t-code-top"><span class="code-lang">Fetch</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
              <pre><span class="kw">await</span> <span class="fn">fetch</span>(<span class="str">'<span id="f-url-prev">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>, {
  method: <span class="str">'POST'</span>,
  headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> },
  body: <span class="kw">new</span> <span class="fn">FormData</span>(form)
});</pre>
            </div>
          </div>
        </div>
      </div>

      <!-- ── jQuery panel ── -->
      <div class="test-panel" id="tp-jquery">
        <div class="test-grid">
          <div class="t-card">
            <div class="t-card-label">Form Data</div>
            <div class="t-field"><label>Name</label><input type="text" id="jq-name" value="John Doe"></div>
            <div class="t-field"><label>Email</label><input type="email" id="jq-email" value="john@example.com"></div>
            <div class="t-field"><label>Message</label><textarea id="jq-msg">Testing jQuery AJAX</textarea></div>
            <button class="t-send-btn" id="jq-btn" onclick="testJQuery()">▶ Send via jQuery</button>
          </div>
          <div class="t-response-col">
            <div class="t-response">
              <div class="t-res-head">
                <span class="t-res-label">Response</span>
                <span class="t-status"><span class="t-dot" id="jq-dot"></span><span id="jq-stat">Waiting…</span></span>
              </div>
              <div class="t-res-body" id="jq-body">Hit Send to see live response.</div>
            </div>
            <div class="t-code">
              <div class="t-code-top"><span class="code-lang">jQuery</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
              <pre>$.<span class="fn">ajax</span>({
  url: <span class="str">'<span id="jq-url-prev">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>,
  method: <span class="str">'POST'</span>, processData: <span class="kw">false</span>, contentType: <span class="kw">false</span>,
  headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> }
});</pre>
            </div>
          </div>
        </div>
      </div>

      <!-- ── Axios panel ── -->
      <div class="test-panel" id="tp-axios">
        <div class="test-grid">
          <div class="t-card">
            <div class="t-card-label">Form Data</div>
            <div class="t-field"><label>Name</label><input type="text" id="ax-name" value="John Doe"></div>
            <div class="t-field"><label>Email</label><input type="email" id="ax-email" value="john@example.com"></div>
            <div class="t-field"><label>Message</label><textarea id="ax-msg">Testing Axios</textarea></div>
            <button class="t-send-btn" id="ax-btn" onclick="testAxios()">▶ Send via Axios</button>
          </div>
          <div class="t-response-col">
            <div class="t-response">
              <div class="t-res-head">
                <span class="t-res-label">Response</span>
                <span class="t-status"><span class="t-dot" id="ax-dot"></span><span id="ax-stat">Waiting…</span></span>
              </div>
              <div class="t-res-body" id="ax-body">Hit Send to see live response.</div>
            </div>
            <div class="t-code">
              <div class="t-code-top"><span class="code-lang">Axios</span><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
              <pre><span class="kw">await</span> axios.<span class="fn">post</span>(
  <span class="str">'<span id="ax-url-prev">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>,
  <span class="kw">new</span> <span class="fn">FormData</span>(form),
  { headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> } }
);</pre>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /test-section -->

  </main>
</div>

<script>
/* ── Copy code blocks ── */
function copyCode(btn) {
  const pre = btn.closest('.code-block, .t-code').querySelector('pre');
  navigator.clipboard.writeText(pre.innerText).then(() => {
    btn.textContent = 'Copied!';
    btn.classList.add('copied');
    setTimeout(() => { btn.textContent = 'Copy'; btn.classList.remove('copied'); }, 1600);
  });
}

/* ── Scrollspy ── */
const allSections = document.querySelectorAll('.section-card[id], .test-section[id]');
const allLinks    = document.querySelectorAll('.ajax-sidebar .sb-link');

const spy = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      allLinks.forEach(l => l.classList.remove('active'));
      const match = document.querySelector(`.sb-link[href="#${entry.target.id}"]`);
      if (match) match.classList.add('active');
    }
  });
}, { rootMargin: '-20% 0px -60% 0px' });

allSections.forEach(s => spy.observe(s));

/* ── Sync endpoint to code previews ── */
document.getElementById('testEndpoint').addEventListener('input', function() {
  const url = this.value;
  ['f','jq','ax'].forEach(k => {
    const el = document.getElementById(k + '-url-prev');
    if (el) el.textContent = url;
  });
});

/* ── Tab switch ── */
function switchTestTab(name) {
  document.querySelectorAll('.test-tab').forEach((b, i) => {
    b.classList.toggle('active', ['fetch','jquery','axios'][i] === name);
  });
  document.querySelectorAll('.test-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tp-' + name).classList.add('active');
}

/* ── Helpers ── */
function getEndpoint() { return document.getElementById('testEndpoint').value.trim(); }
function buildFD(prefix) {
  const fd = new FormData();
  fd.append('name',    document.getElementById(prefix + '-name').value);
  fd.append('email',   document.getElementById(prefix + '-email').value);
  fd.append('message', document.getElementById(prefix + '-msg').value);
  return fd;
}
function setRes(p, stat, text, state) {
  document.getElementById(p+'-dot').className  = 't-dot ' + state;
  document.getElementById(p+'-stat').textContent = stat;
  const body = document.getElementById(p+'-body');
  body.className   = 't-res-body ' + (state === 'wait' ? '' : state);
  body.textContent = text;
}
function fmt(data) { return JSON.stringify(data, null, 2); }

/* ── Fetch test ── */
async function testFetch() {
  const btn = document.getElementById('f-btn');
  btn.disabled = true; btn.textContent = 'Sending…';
  setRes('f', 'Sending…', 'Request in flight…', 'wait');
  try {
    const res  = await fetch(getEndpoint(), {
      method: 'POST', headers: { 'Accept': 'application/json' }, body: buildFD('f')
    });
    const data = await res.json();
    setRes('f', res.status + (res.ok ? ' OK' : ' Error'), fmt(data), res.ok ? 'ok' : 'err');
  } catch(e) {
    setRes('f', 'Network Error', e.message, 'err');
  } finally {
    btn.disabled = false; btn.textContent = '▶ Send via Fetch';
  }
}

/* ── jQuery test ── */
function testJQuery() {
  const btn = $('#jq-btn');
  btn.prop('disabled', true).text('Sending…');
  setRes('jq', 'Sending…', 'Request in flight…', 'wait');
  $.ajax({
    url: getEndpoint(), method: 'POST',
    data: buildFD('jq'), dataType: 'json',
    processData: false, contentType: false,
    headers: { 'Accept': 'application/json' },
    success: (data) => setRes('jq', '200 OK', fmt(data), 'ok'),
    error:   (xhr)  => {
      let msg = xhr.responseText;
      try { msg = fmt(JSON.parse(msg)); } catch(e) {}
      setRes('jq', xhr.status + ' Error', msg, 'err');
    },
    complete: () => btn.prop('disabled', false).text('▶ Send via jQuery')
  });
}

/* ── Axios test ── */
async function testAxios() {
  const btn = document.getElementById('ax-btn');
  btn.disabled = true; btn.textContent = 'Sending…';
  setRes('ax', 'Sending…', 'Request in flight…', 'wait');
  try {
    const { data } = await axios.post(
      getEndpoint(), buildFD('ax'), { headers: { 'Accept': 'application/json' } }
    );
    setRes('ax', '200 OK', fmt(data), 'ok');
  } catch(err) {
    const data = err.response?.data;
    setRes('ax', (err.response?.status || 'Network') + ' Error',
      data ? fmt(data) : err.message, 'err');
  } finally {
    btn.disabled = false; btn.textContent = '▶ Send via Axios';
  }
}
</script>

@endsection