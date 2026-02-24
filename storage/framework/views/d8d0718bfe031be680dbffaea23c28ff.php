

<?php $__env->startSection('title', 'AJAX - 000forms'); ?>

<?php $__env->startSection('content'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .ajax-docs-wrap { padding: 8rem 0 5rem; }

    .ajax-docs-layout {
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
    .docs-nav-label.live-label { color: #00ff8866; }

    .docs-nav a {
        display: flex; align-items: center; gap: 0.55rem;
        padding: 0.38rem 1.25rem; font-size: 13px; color: #666;
        text-decoration: none; transition: color 0.15s;
        border-left: 2px solid transparent; margin-left: -1px;
    }
    .docs-nav a i { font-size: 13px; flex-shrink: 0; }
    .docs-nav a:hover { color: #ccc; }
    .docs-nav a.active { color: #00ff88; border-left-color: #00ff88; }

    /* ── Page heading ── */
    .ajax-page-head {
        margin-bottom: 2.5rem;
    }
    .ajax-page-head h1 {
        font-size: 1.9rem; font-weight: 700; color: #f0f0f0;
        margin-bottom: 0.5rem; letter-spacing: -0.02em;
    }
    .ajax-page-head p { color: #666; font-size: 14.5px; margin-bottom: 1rem; }

    .endpoint-pill {
        display: inline-flex; align-items: center; gap: 0.6rem;
        background: #0a0a0a; border: 1px solid #1e1e1e; border-radius: 8px;
        padding: 0.5rem 1rem; font-family: 'Courier New', monospace; font-size: 13px;
    }
    .ep-method {
        background: #00ff88; color: #000; font-size: 9px; font-weight: 800;
        letter-spacing: 1px; padding: 2px 8px; border-radius: 4px;
    }
    .ep-url { color: #888; }
    .ep-url em { color: #00ff88; font-style: normal; }

    /* ── Section cards ── */
    .docs-section {
        margin-bottom: 1.5rem; border: 1px solid #1e1e1e;
        border-radius: 12px; overflow: hidden; background: #0d0d0d;
        scroll-margin-top: 6rem;
    }
    .docs-section-header { padding: 1.6rem 1.75rem 0; }
    .docs-section-header h2 {
        font-size: 1.1rem; font-weight: 600; color: #f0f0f0;
        margin: 0 0 0.4rem; display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;
    }
    .sec-icon {
        width: 30px; height: 30px; border-radius: 7px;
        background: #131313; border: 1px solid #222;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 15px; color: #00ff88; flex-shrink: 0;
    }
    .h2-sub { font-size: 12px; font-weight: 400; color: #555; }
    .docs-section-header p { font-size: 14px; color: #666; margin: 0 0 1.35rem; line-height: 1.65; }
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
        font-size: 13px; line-height: 1.8; color: #c9c9c9;
    }

    /* Syntax colours */
    .tag    { color: #7dd3a8; }
    .attr   { color: #9ecbff; }
    .str    { color: #f8c77e; }
    .comment{ color: #4a4a4a; font-style: italic; }
    .kw     { color: #c792ea; }
    .fn     { color: #82aaff; }
    .str2   { color: #c3e88d; }
    .hl     { color: #00ff88; font-weight: 600; }
    .nm     { color: #fb923c; }

    /* ── Inline code ── */
    .ic {
        font-family: 'Courier New', monospace; font-size: 12.5px;
        background: #141414; border: 1px solid #222; border-radius: 4px;
        padding: 2px 7px; color: #00ff88;
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 10px; font-weight: 700; letter-spacing: 0.5px;
        text-transform: uppercase; padding: 2px 8px; border-radius: 4px;
        vertical-align: middle;
    }
    .badge-green  { background: #00ff8818; color: #00ff88; border: 1px solid #00ff8835; }
    .badge-blue   { background: #9ecbff18; color: #9ecbff; border: 1px solid #9ecbff35; }
    .badge-yellow { background: #f8c77e18; color: #f8c77e; border: 1px solid #f8c77e35; }

    /* ── Note boxes ── */
    .note-box {
        background: #0f0f0f; border: 1px solid #1e1e1e;
        border-left: 3px solid #00ff88; border-radius: 6px;
        padding: 0.85rem 1.1rem; font-size: 13.5px; color: #666;
        margin-top: 1rem; line-height: 1.65;
        display: flex; gap: 0.6rem; align-items: flex-start;
    }
    .note-box i { color: #00ff88; font-size: 15px; margin-top: 1px; flex-shrink: 0; }
    .note-box.warn { border-left-color: #f8c77e; }
    .note-box.warn i { color: #f8c77e; }
    .note-box.info { border-left-color: #9ecbff; }
    .note-box.info i { color: #9ecbff; }
    .note-box strong { color: #999; }

    /* ── Tables ── */
    .sf-table {
        width: 100%; border-collapse: collapse; font-size: 13.5px;
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
    .sf-table td code {
        font-family: 'Courier New', monospace; font-size: 12px;
        background: #141414; border: 1px solid #222; border-radius: 4px;
        padding: 2px 7px; color: #00ff88;
    }
    .sf-table td:first-child { width: 150px; white-space: nowrap; }
    .sf-table td:last-child { color: #666; line-height: 1.65; }

    /* ── Response grid ── */
    .res-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem; }
    .res-card { background: #080808; border: 1px solid #1e1e1e; border-radius: 10px; overflow: hidden; }
    .res-card-head {
        display: flex; align-items: center; gap: 0.5rem;
        padding: 0.55rem 1rem; border-bottom: 1px solid #1e1e1e;
        font-family: 'Courier New', monospace; font-size: 12px; font-weight: 600;
    }
    .rdot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .res-card.ok  .res-card-head { color: #00ff88; }
    .res-card.ok  .rdot           { background: #00ff88; }
    .res-card.err .res-card-head  { color: #ef4444; }
    .res-card.err .rdot           { background: #ef4444; }
    .res-card .code-content pre   { font-size: 12px; }

    /* ── Section group label ── */
    .section-group-label {
        margin: 2.5rem 0 0.75rem;
        display: flex; align-items: center; gap: 0.6rem;
    }
    .section-group-label span {
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #333; white-space: nowrap;
    }
    .section-group-label::after { content: ''; flex: 1; height: 1px; background: #1a1a1a; }

    /* ════════════════════════════════
       TEST AJAX SECTION
    ════════════════════════════════ */
    .test-section {
        margin-bottom: 1.5rem;
        border: 1px solid #00ff8828;
        border-radius: 12px; overflow: hidden; background: #0d0d0d;
        scroll-margin-top: 6rem;
    }
    .test-section-header { padding: 1.6rem 1.75rem 0; }
    .test-section-header h2 {
        font-size: 1.1rem; font-weight: 600; color: #f0f0f0;
        margin: 0 0 0.4rem; display: flex; align-items: center; gap: 0.6rem;
    }
    .test-badge {
        font-size: 9px; font-weight: 800; letter-spacing: 1px;
        text-transform: uppercase; background: #00ff88; color: #000;
        padding: 2px 8px; border-radius: 4px;
    }
    .test-section-header > p { font-size: 14px; color: #666; margin: 0 0 1.35rem; line-height: 1.65; }
    .test-section-body { padding: 0 1.75rem 1.75rem; }

    /* Endpoint bar */
    .test-endpoint {
        display: flex; align-items: center; gap: 0.75rem;
        background: #0a0a0a; border: 1px solid #1e1e1e; border-radius: 8px;
        padding: 0.65rem 1rem; margin-bottom: 1rem;
    }
    .test-endpoint label {
        font-size: 10px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; color: #444; white-space: nowrap;
        font-family: 'Courier New', monospace;
    }
    .test-endpoint input {
        flex: 1; background: transparent; border: none; outline: none;
        font-family: 'Courier New', monospace; font-size: 13px; color: #00ff88;
    }
    .test-endpoint input::placeholder { color: #333; }

    /* Method tabs */
    .test-tabs {
        display: flex; gap: 4px;
        background: #0a0a0a; border: 1px solid #1e1e1e;
        border-radius: 8px; padding: 4px; margin-bottom: 1.25rem;
    }
    .test-tab {
        flex: 1; background: none; border: 1px solid transparent;
        border-radius: 6px; padding: 7px 10px;
        font-size: 12.5px; font-weight: 500;
        color: #555; cursor: pointer; transition: all 0.15s; text-align: center;
    }
    .test-tab:hover { color: #ccc; }
    .test-tab.active {
        background: #00ff8812; border-color: #00ff8830; color: #00ff88;
    }

    .test-panel { display: none; }
    .test-panel.active { display: block; }

    /* Two-col layout */
    .test-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    /* Form card */
    .t-card {
        background: #0a0a0a; border: 1px solid #1e1e1e;
        border-radius: 10px; padding: 1.25rem;
    }
    .t-card-label {
        font-size: 10px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; color: #444; margin-bottom: 1rem;
    }
    .t-field { margin-bottom: 0.75rem; }
    .t-field label { display: block; font-size: 11px; color: #555; margin-bottom: 4px; }
    .t-field input,
    .t-field textarea {
        width: 100%; background: #0d0d0d; border: 1px solid #1e1e1e;
        border-radius: 7px; padding: 0.5rem 0.75rem;
        color: #d0d0d0; font-size: 13px; outline: none;
        transition: border-color 0.15s; font-family: inherit;
    }
    .t-field input:focus,
    .t-field textarea:focus { border-color: #00ff8840; }
    .t-field input::placeholder,
    .t-field textarea::placeholder { color: #333; }
    .t-field textarea { resize: vertical; min-height: 60px; }

    .t-send-btn {
        width: 100%; background: #00ff88; color: #000;
        border: none; border-radius: 7px; padding: 0.6rem;
        font-size: 13px; font-weight: 700; cursor: pointer;
        transition: opacity 0.15s; margin-top: 0.25rem;
        display: flex; align-items: center; justify-content: center; gap: 0.4rem;
    }
    .t-send-btn:hover    { opacity: 0.85; }
    .t-send-btn:disabled { opacity: 0.35; cursor: not-allowed; }

    /* Response + code column */
    .t-response-col { display: flex; flex-direction: column; gap: 0.75rem; }

    .t-response {
        background: #080808; border: 1px solid #1e1e1e;
        border-radius: 10px; overflow: hidden; flex: 1;
    }
    .t-res-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.55rem 1rem; border-bottom: 1px solid #1e1e1e;
    }
    .t-res-label {
        font-size: 10px; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; color: #444; font-family: 'Courier New', monospace;
    }
    .t-status { display: flex; align-items: center; gap: 6px; font-family: 'Courier New', monospace; font-size: 11px; }
    .t-dot { width: 7px; height: 7px; border-radius: 50%; background: #333; }
    .t-dot.ok   { background: #00ff88; }
    .t-dot.err  { background: #ef4444; }
    .t-dot.wait { background: #f8c77e; animation: blink 1s infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .t-res-body {
        padding: 1rem; font-family: 'Courier New', monospace;
        font-size: 12px; line-height: 1.75; color: #444;
        min-height: 60px; white-space: pre-wrap; word-break: break-all;
    }
    .t-res-body.ok  { color: #00ff88; }
    .t-res-body.err { color: #ef4444; }

    /* Snippet inside test */
    .t-code {
        background: #080808; border: 1px solid #1e1e1e;
        border-radius: 10px; overflow: hidden;
    }
    .t-code-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.5rem 1rem; border-bottom: 1px solid #1e1e1e;
        background: #111;
    }
    .t-code .code-content pre { font-size: 11.5px; }

    @media (max-width: 860px) {
        .ajax-docs-layout { grid-template-columns: 1fr; }
        .docs-nav { display: none; }
        .res-grid { grid-template-columns: 1fr; }
        .test-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="ajax-docs-wrap">
    <div class="container">

        
        <div class="ajax-page-head">
            <h1>AJAX Form Submission</h1>
            <p>Submit forms without a page reload. Add one header and you're done.</p>
            <div class="endpoint-pill">
                <span class="ep-method">POST</span>
                <span class="ep-url">https://000forms.com/f/<em>YOUR_TOKEN</em></span>
            </div>
        </div>

        <div class="ajax-docs-layout">

            
            <nav class="docs-nav">
                <div class="docs-nav-label">Methods</div>
                <a href="#overview"><i class="bi bi-grid-1x2"></i> Overview</a>
                <a href="#fetch"><i class="bi bi-lightning-charge"></i> Fetch API</a>
                <a href="#jquery"><i class="bi bi-code-slash"></i> jQuery</a>
                <a href="#axios"><i class="bi bi-bezier2"></i> Axios</a>

                <div class="docs-nav-label">Reference</div>
                <a href="#attributes"><i class="bi bi-list-ul"></i> Attributes</a>
                <a href="#responses"><i class="bi bi-arrow-return-left"></i> Responses</a>
                <a href="#tips"><i class="bi bi-star"></i> Tips</a>

                <div class="docs-nav-label live-label">Live</div>
                <a href="#test-ajax"><i class="bi bi-play-circle"></i> Test AJAX</a>
            </nav>

            
            <div>

                
                <div class="docs-section" id="overview">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                            Overview
                        </h2>
                        <p>Point your request at your 000forms endpoint and include the <span class="ic">Accept: application/json</span> header. That's all — 000forms returns JSON instead of redirecting the page.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="note-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <span><strong>Your token —</strong> Replace <span class="ic">YOUR_TOKEN</span> with the token from your dashboard (e.g. <span class="ic">f_l63kxxnb</span>).</span>
                        </div>
                    </div>
                </div>

                <div class="section-group-label"><span>Methods</span></div>

                
                <div class="docs-section" id="fetch">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-lightning-charge-fill"></i></span>
                            Fetch API
                            <span class="badge badge-green">Recommended</span>
                        </h2>
                        <p>Modern and promise-based. Works natively in all current browsers — no library needed.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">HTML</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre><span class="tag">&lt;form</span> <span class="attr">id</span>=<span class="str">"myForm"</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="str">"text"</span>  <span class="attr">name</span>=<span class="str">"name"</span>    <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;input</span> <span class="attr">type</span>=<span class="str">"email"</span> <span class="attr">name</span>=<span class="str">"email"</span>   <span class="attr">required</span><span class="tag">&gt;</span>
  <span class="tag">&lt;textarea</span>            <span class="attr">name</span>=<span class="str">"message"</span><span class="tag">&gt;&lt;/textarea&gt;</span>
  <span class="tag">&lt;button</span> <span class="attr">type</span>=<span class="str">"submit"</span><span class="tag">&gt;</span>Send<span class="tag">&lt;/button&gt;</span>
<span class="tag">&lt;/form&gt;</span>
<span class="tag">&lt;div</span> <span class="attr">id</span>=<span class="str">"status"</span><span class="tag">&gt;&lt;/div&gt;</span></pre>
                            </div>
                        </div>
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">JavaScript</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre><span class="kw">const</span> form = document.<span class="fn">getElementById</span>(<span class="str2">'myForm'</span>);

form.<span class="fn">addEventListener</span>(<span class="str2">'submit'</span>, <span class="kw">async</span> (e) => {
  e.<span class="fn">preventDefault</span>();

  <span class="kw">const</span> res  = <span class="kw">await</span> <span class="fn">fetch</span>(<span class="str2">'https://000forms.com/f/<span class="hl">YOUR_TOKEN</span>'</span>, {
    method:  <span class="str2">'POST'</span>,
    headers: { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> },
    body:    <span class="kw">new</span> <span class="fn">FormData</span>(form)
  });
  <span class="kw">const</span> data = <span class="kw">await</span> res.<span class="fn">json</span>();

  document.<span class="fn">getElementById</span>(<span class="str2">'status'</span>).textContent =
    res.ok ? <span class="str2">'✓ '</span> + data.message : <span class="str2">'✗ '</span> + data.message;

  <span class="kw">if</span> (res.ok) form.<span class="fn">reset</span>();
});</pre>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="docs-section" id="jquery">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-code-slash"></i></span>
                            jQuery AJAX
                        </h2>
                        <p>If jQuery is already loaded in your project, you can use <span class="ic">$.ajax()</span> with a few key options.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">JavaScript</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre>$(<span class="str2">'#myForm'</span>).<span class="fn">on</span>(<span class="str2">'submit'</span>, <span class="kw">function</span>(e) {
  e.<span class="fn">preventDefault</span>();

  $.<span class="fn">ajax</span>({
    url:         <span class="str2">'https://000forms.com/f/<span class="hl">YOUR_TOKEN</span>'</span>,
    method:      <span class="str2">'POST'</span>,
    data:        <span class="kw">new</span> <span class="fn">FormData</span>(<span class="kw">this</span>),
    dataType:    <span class="str2">'json'</span>,
    processData: <span class="kw">false</span>,
    contentType: <span class="kw">false</span>,
    headers:     { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> },
    success: (data) => $(<span class="str2">'#status'</span>).<span class="fn">text</span>(<span class="str2">'✓ '</span> + data.message),
    error:   (xhr)  => $(<span class="str2">'#status'</span>).<span class="fn">text</span>(<span class="str2">'✗ '</span> + JSON.<span class="fn">parse</span>(xhr.responseText).message)
  });
});</pre>
                            </div>
                        </div>
                        <div class="note-box warn">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span>Always set <span class="ic">processData: false</span> and <span class="ic">contentType: false</span> when passing <span class="ic">FormData</span> to jQuery — otherwise it won't serialize correctly.</span>
                        </div>
                    </div>
                </div>

                
                <div class="docs-section" id="axios">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-bezier2"></i></span>
                            Axios
                        </h2>
                        <p>Common in Vue and React projects. Handles JSON automatically and has clean error handling via <span class="ic">try / catch</span>.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">JavaScript</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre>form.<span class="fn">addEventListener</span>(<span class="str2">'submit'</span>, <span class="kw">async</span> (e) => {
  e.<span class="fn">preventDefault</span>();

  <span class="kw">try</span> {
    <span class="kw">const</span> { data } = <span class="kw">await</span> axios.<span class="fn">post</span>(
      <span class="str2">'https://000forms.com/f/<span class="hl">YOUR_TOKEN</span>'</span>,
      <span class="kw">new</span> <span class="fn">FormData</span>(e.target),
      { headers: { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> } }
    );
    console.<span class="fn">log</span>(data.message);
    e.target.<span class="fn">reset</span>();
  } <span class="kw">catch</span> (err) {
    console.<span class="fn">error</span>(err.response?.data?.message);
  }
});</pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-group-label"><span>Reference</span></div>

                
                <div class="docs-section" id="attributes">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-list-ul"></i></span>
                            Special Attributes
                        </h2>
                        <p>Add these as hidden inputs inside your form to control extra behaviour. All are optional.</p>
                    </div>
                    <div class="docs-section-body">
                        <table class="sf-table">
                            <thead>
                                <tr><th>Name</th><th>Description</th><th>Example value</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>_subject</code></td>
                                    <td>Email subject line</td>
                                    <td style="color:#666">New contact</td>
                                </tr>
                                <tr>
                                    <td><code>_redirect</code></td>
                                    <td>Redirect URL (non-AJAX only)</td>
                                    <td style="color:#666">https://yoursite.com/thanks</td>
                                </tr>
                                <tr>
                                    <td><code>_cc</code></td>
                                    <td>CC to another address</td>
                                    <td style="color:#666">admin@yoursite.com</td>
                                </tr>
                                <tr>
                                    <td><code>_autoresponse</code></td>
                                    <td>Auto-reply to the submitter</td>
                                    <td style="color:#666">Thanks! We'll reply soon.</td>
                                </tr>
                                <tr>
                                    <td><code>_template</code></td>
                                    <td>Email template style</td>
                                    <td style="color:#666">table / box / basic</td>
                                </tr>
                                <tr>
                                    <td><code>_honeypot</code></td>
                                    <td>Spam trap field (hide with CSS)</td>
                                    <td style="color:#666">_honey</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                
                <div class="docs-section" id="responses">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-arrow-return-left"></i></span>
                            JSON Responses
                        </h2>
                        <p>When <span class="ic">Accept: application/json</span> is set, you always receive JSON — never a redirect.</p>
                    </div>
                    <div class="docs-section-body">
                        <div class="res-grid">
                            <div class="res-card ok">
                                <div class="res-card-head"><span class="rdot"></span> 200 — Success</div>
                                <div class="code-content">
<pre>{
  "success": true,
  "message": "Form submitted."
}</pre>
                                </div>
                            </div>
                            <div class="res-card err">
                                <div class="res-card-head"><span class="rdot"></span> 422 — Error</div>
                                <div class="code-content">
<pre>{
  "success": false,
  "message": "Validation failed",
  "errors": { "email": "Required" }
}</pre>
                                </div>
                            </div>
                        </div>
                        <div class="note-box info" style="margin-top:1rem;">
                            <i class="bi bi-info-circle-fill"></i>
                            <span><strong>Status codes —</strong> <span class="ic">200</span> sent &nbsp;·&nbsp; <span class="ic">422</span> validation failed &nbsp;·&nbsp; <span class="ic">429</span> rate limited</span>
                        </div>
                    </div>
                </div>

                
                <div class="docs-section" id="tips">
                    <div class="docs-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-star-fill"></i></span>
                            Tips
                        </h2>
                        <p>Common patterns to improve user experience when submitting forms via AJAX.</p>
                    </div>
                    <div class="docs-section-body">
                        <p style="font-size:13px;color:#555;margin-bottom:0.6rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Disable button while sending</p>
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">JavaScript</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre><span class="kw">const</span> btn = form.<span class="fn">querySelector</span>(<span class="str2">'button[type="submit"]'</span>);
btn.disabled    = <span class="kw">true</span>;
btn.textContent = <span class="str2">'Sending…'</span>;
<span class="comment">// re-enable inside a finally block</span></pre>
                            </div>
                        </div>

                        <p style="font-size:13px;color:#555;margin:1.25rem 0 0.6rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Send as JSON body</p>
                        <div class="code-block">
                            <div class="code-header">
                                <span class="code-lang">JavaScript</span>
                                <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                            </div>
                            <div class="code-content">
<pre><span class="kw">const</span> payload = Object.<span class="fn">fromEntries</span>(<span class="kw">new</span> <span class="fn">FormData</span>(form));
<span class="fn">fetch</span>(url, {
  method:  <span class="str2">'POST'</span>,
  headers: { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span>, <span class="str2">'Content-Type'</span>: <span class="str2">'application/json'</span> },
  body:    JSON.<span class="fn">stringify</span>(payload)
});</pre>
                            </div>
                        </div>
                        <div class="note-box">
                            <i class="bi bi-globe"></i>
                            <span><strong>CORS —</strong> 000forms allows cross-origin requests from any domain by default, so you won't need to set up any additional headers for that.</span>
                        </div>
                    </div>
                </div>

                
                <div class="test-section" id="test-ajax">
                    <div class="test-section-header">
                        <h2>
                            <span class="sec-icon"><i class="bi bi-play-circle-fill"></i></span>
                            Test AJAX
                            <span class="test-badge">Live</span>
                        </h2>
                        <p>Send real requests to your endpoint and see the live JSON response instantly.</p>
                    </div>
                    <div class="test-section-body">

                        
                        <div class="test-endpoint">
                            <label>Endpoint</label>
                            <input type="text" id="testEndpoint"
                                   value=""
                                   placeholder="https://000forms.com/f/YOUR_TOKEN">
                        </div>

                        
                        <div class="test-tabs">
                            <button class="test-tab active" onclick="switchTestTab('fetch')">
                                <i class="bi bi-lightning-charge"></i> Fetch
                            </button>
                            <button class="test-tab" onclick="switchTestTab('jquery')">
                                <i class="bi bi-code-slash"></i> jQuery
                            </button>
                            <button class="test-tab" onclick="switchTestTab('axios')">
                                <i class="bi bi-bezier2"></i> Axios
                            </button>
                        </div>

                        
                        <div class="test-panel active" id="tp-fetch">
                            <div class="test-grid">
                                <div class="t-card">
                                    <div class="t-card-label">Form Data</div>
                                    <div class="t-field"><label>Name</label><input type="text" id="f-name" value="John Doe"></div>
                                    <div class="t-field"><label>Email</label><input type="email" id="f-email" value="john@example.com"></div>
                                    <div class="t-field"><label>Message</label><textarea id="f-msg">Testing Fetch API</textarea></div>
                                    <button class="t-send-btn" id="f-btn" onclick="testFetch()">
                                        <i class="bi bi-send-fill"></i> Send via Fetch
                                    </button>
                                </div>
                                <div class="t-response-col">
                                    <div class="t-response">
                                        <div class="t-res-head">
                                            <span class="t-res-label">Response</span>
                                            <span class="t-status">
                                                <span class="t-dot" id="f-dot"></span>
                                                <span id="f-stat">Waiting…</span>
                                            </span>
                                        </div>
                                        <div class="t-res-body" id="f-body">Hit Send to see live response.</div>
                                    </div>
                                    <div class="t-code">
                                        <div class="t-code-head">
                                            <span class="code-lang">Fetch</span>
                                            <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                                        </div>
                                        <div class="code-content">
<pre><span class="kw">await</span> <span class="fn">fetch</span>(<span class="str2">'<span id="f-url-prev">https://000forms.com/f/YOUR_TOKEN</span>'</span>, {
  method:  <span class="str2">'POST'</span>,
  headers: { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> },
  body:    <span class="kw">new</span> <span class="fn">FormData</span>(form)
});</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="test-panel" id="tp-jquery">
                            <div class="test-grid">
                                <div class="t-card">
                                    <div class="t-card-label">Form Data</div>
                                    <div class="t-field"><label>Name</label><input type="text" id="jq-name" value="John Doe"></div>
                                    <div class="t-field"><label>Email</label><input type="email" id="jq-email" value="john@example.com"></div>
                                    <div class="t-field"><label>Message</label><textarea id="jq-msg">Testing jQuery AJAX</textarea></div>
                                    <button class="t-send-btn" id="jq-btn" onclick="testJQuery()">
                                        <i class="bi bi-send-fill"></i> Send via jQuery
                                    </button>
                                </div>
                                <div class="t-response-col">
                                    <div class="t-response">
                                        <div class="t-res-head">
                                            <span class="t-res-label">Response</span>
                                            <span class="t-status">
                                                <span class="t-dot" id="jq-dot"></span>
                                                <span id="jq-stat">Waiting…</span>
                                            </span>
                                        </div>
                                        <div class="t-res-body" id="jq-body">Hit Send to see live response.</div>
                                    </div>
                                    <div class="t-code">
                                        <div class="t-code-head">
                                            <span class="code-lang">jQuery</span>
                                            <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                                        </div>
                                        <div class="code-content">
<pre>$.<span class="fn">ajax</span>({
  url:         <span class="str2">'<span id="jq-url-prev">https://000forms.com/f/YOUR_TOKEN</span>'</span>,
  method:      <span class="str2">'POST'</span>,
  processData: <span class="kw">false</span>,
  contentType: <span class="kw">false</span>,
  headers:     { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> }
});</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="test-panel" id="tp-axios">
                            <div class="test-grid">
                                <div class="t-card">
                                    <div class="t-card-label">Form Data</div>
                                    <div class="t-field"><label>Name</label><input type="text" id="ax-name" value="John Doe"></div>
                                    <div class="t-field"><label>Email</label><input type="email" id="ax-email" value="john@example.com"></div>
                                    <div class="t-field"><label>Message</label><textarea id="ax-msg">Testing Axios</textarea></div>
                                    <button class="t-send-btn" id="ax-btn" onclick="testAxios()">
                                        <i class="bi bi-send-fill"></i> Send via Axios
                                    </button>
                                </div>
                                <div class="t-response-col">
                                    <div class="t-response">
                                        <div class="t-res-head">
                                            <span class="t-res-label">Response</span>
                                            <span class="t-status">
                                                <span class="t-dot" id="ax-dot"></span>
                                                <span id="ax-stat">Waiting…</span>
                                            </span>
                                        </div>
                                        <div class="t-res-body" id="ax-body">Hit Send to see live response.</div>
                                    </div>
                                    <div class="t-code">
                                        <div class="t-code-head">
                                            <span class="code-lang">Axios</span>
                                            <button class="code-copy"><i class="bi bi-clipboard"></i> Copy</button>
                                        </div>
                                        <div class="code-content">
<pre><span class="kw">await</span> axios.<span class="fn">post</span>(
  <span class="str2">'<span id="ax-url-prev">https://000forms.com/f/YOUR_TOKEN</span>'</span>,
  <span class="kw">new</span> <span class="fn">FormData</span>(form),
  { headers: { <span class="str2">'Accept'</span>: <span class="str2">'application/json'</span> } }
);</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
/* ── Copy buttons ── */
document.querySelectorAll('.code-copy').forEach(btn => {
    btn.addEventListener('click', function () {
        const pre = this.closest('.code-block, .t-code').querySelector('pre');
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

/* ── Scrollspy ── */
const allSections = document.querySelectorAll('.docs-section[id], .test-section[id]');
const navLinks    = document.querySelectorAll('.docs-nav a');

const spy = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            navLinks.forEach(l => l.classList.remove('active'));
            const match = document.querySelector(`.docs-nav a[href="#${entry.target.id}"]`);
            if (match) match.classList.add('active');
        }
    });
}, { rootMargin: '-20% 0px -60% 0px' });

allSections.forEach(s => spy.observe(s));

/* ── Sync endpoint to code previews ── */
document.getElementById('testEndpoint').addEventListener('input', function () {
    const url = this.value || 'https://000forms.com/f/YOUR_TOKEN';
    ['f', 'jq', 'ax'].forEach(k => {
        const el = document.getElementById(k + '-url-prev');
        if (el) el.textContent = url;
    });
});

/* ── Tab switch ── */
function switchTestTab(name) {
    document.querySelectorAll('.test-tab').forEach((b, i) => {
        b.classList.toggle('active', ['fetch', 'jquery', 'axios'][i] === name);
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
    document.getElementById(p + '-dot').className   = 't-dot ' + state;
    document.getElementById(p + '-stat').textContent = stat;
    const body = document.getElementById(p + '-body');
    body.className   = 't-res-body ' + (state === 'wait' ? '' : state);
    body.textContent = text;
}
function fmt(data) { return JSON.stringify(data, null, 2); }

/* ── Fetch test ── */
async function testFetch() {
    const btn = document.getElementById('f-btn');
    btn.disabled = true; btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Sending…';
    setRes('f', 'Sending…', 'Request in flight…', 'wait');
    try {
        const res  = await fetch(getEndpoint(), {
            method: 'POST', headers: { 'Accept': 'application/json' }, body: buildFD('f')
        });
        const data = await res.json();
        setRes('f', res.status + (res.ok ? ' OK' : ' Error'), fmt(data), res.ok ? 'ok' : 'err');
    } catch (e) {
        setRes('f', 'Network Error', e.message, 'err');
    } finally {
        btn.disabled = false; btn.innerHTML = '<i class="bi bi-send-fill"></i> Send via Fetch';
    }
}

/* ── jQuery test ── */
function testJQuery() {
    const btn = $('#jq-btn');
    btn.prop('disabled', true).html('<i class="bi bi-arrow-repeat"></i> Sending…');
    setRes('jq', 'Sending…', 'Request in flight…', 'wait');
    $.ajax({
        url: getEndpoint(), method: 'POST',
        data: buildFD('jq'), dataType: 'json',
        processData: false, contentType: false,
        headers: { 'Accept': 'application/json' },
        success: (data) => setRes('jq', '200 OK', fmt(data), 'ok'),
        error:   (xhr)  => {
            let msg = xhr.responseText;
            try { msg = fmt(JSON.parse(msg)); } catch (e) {}
            setRes('jq', xhr.status + ' Error', msg, 'err');
        },
        complete: () => btn.prop('disabled', false).html('<i class="bi bi-send-fill"></i> Send via jQuery')
    });
}

/* ── Axios test ── */
async function testAxios() {
    const btn = document.getElementById('ax-btn');
    btn.disabled = true; btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Sending…';
    setRes('ax', 'Sending…', 'Request in flight…', 'wait');
    try {
        const { data } = await axios.post(
            getEndpoint(), buildFD('ax'), { headers: { 'Accept': 'application/json' } }
        );
        setRes('ax', '200 OK', fmt(data), 'ok');
    } catch (err) {
        const data = err.response?.data;
        setRes('ax', (err.response?.status || 'Network') + ' Error',
            data ? fmt(data) : err.message, 'err');
    } finally {
        btn.disabled = false; btn.innerHTML = '<i class="bi bi-send-fill"></i> Send via Axios';
    }
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000form\resources\views/pages/ajax.blade.php ENDPATH**/ ?>