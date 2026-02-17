<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJAX Test — 000forms</title>
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
      --green-d: rgba(0,232,122,0.1);
      --green-b: rgba(0,232,122,0.25);
      --red:     #f04444;
      --red-d:   rgba(240,68,68,0.1);
      --yellow:  #fbbf24;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      line-height: 1.6;
      padding: 40px 24px 80px;
    }

    .page { max-width: 860px; margin: 0 auto; }

    /* ── Header ── */
    .header {
      margin-bottom: 36px;
      padding-bottom: 24px;
      border-bottom: 1px solid var(--border);
    }
    .header-tag {
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
      margin-bottom: 12px;
    }
    .header h1 {
      font-size: 1.5rem;
      font-weight: 600;
      letter-spacing: -0.02em;
      margin-bottom: 8px;
    }
    .header p { color: var(--muted); font-size: 13px; }

    /* Endpoint config */
    .endpoint-config {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
      background: var(--card2);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 10px 14px;
    }
    .endpoint-config label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
      white-space: nowrap;
    }
    .endpoint-config input {
      flex: 1;
      background: transparent;
      border: none;
      outline: none;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12.5px;
      color: var(--green);
    }
    .endpoint-config input::placeholder { color: var(--muted); }

    /* ── Tabs ── */
    .tabs {
      display: flex;
      gap: 6px;
      margin-bottom: 20px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 6px;
    }
    .tab-btn {
      flex: 1;
      background: none;
      border: 1px solid transparent;
      border-radius: 7px;
      padding: 8px 12px;
      font-size: 12.5px;
      font-weight: 500;
      font-family: 'Inter', sans-serif;
      color: var(--muted);
      cursor: pointer;
      transition: all 0.15s;
      text-align: center;
    }
    .tab-btn:hover { color: var(--text); }
    .tab-btn.active {
      background: var(--green-d);
      border-color: var(--green-b);
      color: var(--green);
    }

    /* ── Panel ── */
    .panel { display: none; }
    .panel.active { display: block; }

    /* ── Card ── */
    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 24px;
      margin-bottom: 16px;
    }
    .card-title {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--muted);
      margin-bottom: 16px;
    }

    /* ── Form fields ── */
    .field-group { margin-bottom: 12px; }
    .field-group label {
      display: block;
      font-size: 11.5px;
      color: var(--muted);
      margin-bottom: 5px;
    }
    .field-group input,
    .field-group textarea {
      width: 100%;
      background: var(--card2);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 9px 12px;
      color: var(--text);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: border-color 0.15s;
    }
    .field-group input:focus,
    .field-group textarea:focus { border-color: var(--green-b); }
    .field-group input::placeholder,
    .field-group textarea::placeholder { color: var(--muted); }
    .field-group textarea { resize: vertical; min-height: 72px; }

    /* Submit button */
    .submit-btn {
      width: 100%;
      background: var(--green);
      color: #000;
      border: none;
      border-radius: 8px;
      padding: 11px;
      font-size: 13px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: opacity 0.15s;
      margin-top: 4px;
    }
    .submit-btn:hover    { opacity: 0.85; }
    .submit-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    /* ── Response box ── */
    .response-box {
      background: var(--card2);
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
    }
    .response-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      border-bottom: 1px solid var(--border);
    }
    .response-label {
      font-family: 'JetBrains Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
    }
    .status-badge {
      display: flex;
      align-items: center;
      gap: 6px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      font-weight: 500;
    }
    .status-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--muted);
    }
    .status-dot.ok  { background: var(--green); }
    .status-dot.err { background: var(--red); }
    .status-dot.wait { background: var(--yellow); animation: blink 1s infinite; }

    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

    .response-body {
      padding: 14px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
      line-height: 1.7;
      color: var(--muted);
      min-height: 60px;
      white-space: pre-wrap;
      word-break: break-all;
    }
    .response-body.ok  { color: var(--green); }
    .response-body.err { color: var(--red); }

    /* ── Code preview ── */
    .code-preview {
      background: var(--card2);
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
    }
    .code-preview-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 14px;
      border-bottom: 1px solid var(--border);
    }
    .code-preview-lang {
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
      padding: 3px 10px;
      font-size: 11px;
      font-family: 'JetBrains Mono', monospace;
      color: var(--muted);
      cursor: pointer;
      transition: all 0.12s;
    }
    .copy-btn:hover  { border-color: var(--green); color: var(--green); }
    .copy-btn.copied { border-color: var(--green); color: var(--green); }
    pre {
      padding: 16px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
      line-height: 1.75;
      overflow-x: auto;
      color: #b0b8c8;
    }

    /* syntax */
    .kw  { color: #60a5fa; font-weight: 500; }
    .str { color: #86efac; }
    .cm  { color: #4b5563; font-style: italic; }
    .fn  { color: #c084fc; }
    .nm  { color: #fb923c; }
    .hl  { color: var(--green); font-weight: 500; }

    /* ── Grid layout ── */
    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }
    @media (max-width: 640px) {
      .two-col { grid-template-columns: 1fr; }
      .tabs { flex-wrap: wrap; }
    }

    /* ── Tip callout ── */
    .tip {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      background: var(--green-d);
      border: 1px solid var(--green-b);
      border-radius: 8px;
      padding: 11px 14px;
      font-size: 12.5px;
      color: #a7f3d0;
      margin-bottom: 16px;
    }
    .tip-icon { flex-shrink: 0; font-size: 14px; margin-top: 1px; }
    code {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      background: rgba(0,232,122,0.12);
      border: 1px solid var(--green-b);
      border-radius: 4px;
      padding: 1px 5px;
      color: var(--green);
    }
  </style>
</head>
<body>
<div class="page">

  <!-- Header -->
  <div class="header">
    <div class="header-tag">Live Test Playground</div>
    <h1>AJAX Test — 000forms</h1>
    <p>Submit real requests to your local endpoint and see the live response below each form.</p>

    <div class="endpoint-config">
      <label>Endpoint →</label>
      <input type="text" id="globalEndpoint"
             value="http://127.0.0.1:8000/f/f_l63kxxnb"
             placeholder="http://127.0.0.1:8000/f/YOUR_TOKEN">
    </div>
  </div>

  <!-- Tip -->
  <div class="tip">
    <span class="tip-icon">✦</span>
    <span>Change the endpoint above and all 4 forms update automatically. Every submission hits your real Laravel server — check your email or database after sending.</span>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <button class="tab-btn active" onclick="switchTab('fetch')">⚡ Fetch API</button>
    <button class="tab-btn"       onclick="switchTab('jquery')">＄ jQuery</button>
    <button class="tab-btn"       onclick="switchTab('axios')">⬡ Axios</button>
    <button class="tab-btn"       onclick="switchTab('xhr')">⧫ XHR</button>
  </div>

  <!-- ════════ FETCH ════════ -->
  <div class="panel active" id="panel-fetch">
    <div class="two-col">

      <div class="card">
        <div class="card-title">Form Fields</div>
        <div class="field-group">
          <label>Name</label>
          <input type="text" id="fetch-name" placeholder="John Doe" value="John Doe">
        </div>
        <div class="field-group">
          <label>Email</label>
          <input type="email" id="fetch-email" placeholder="john@example.com" value="john@example.com">
        </div>
        <div class="field-group">
          <label>Message</label>
          <textarea id="fetch-message" placeholder="Hello from Fetch API...">Testing Fetch API submission</textarea>
        </div>
        <button class="submit-btn" id="fetch-btn" onclick="submitFetch()">Send via Fetch</button>
      </div>

      <div style="display:flex;flex-direction:column;gap:16px">
        <div class="response-box">
          <div class="response-header">
            <span class="response-label">Response</span>
            <span class="status-badge">
              <span class="status-dot" id="fetch-dot"></span>
              <span id="fetch-status">Waiting…</span>
            </span>
          </div>
          <div class="response-body" id="fetch-response">Hit "Send" to see the live response here.</div>
        </div>

        <div class="code-preview">
          <div class="code-preview-top">
            <span class="code-preview-lang">JavaScript — Fetch</span>
            <button class="copy-btn" onclick="copyPre(this)">Copy</button>
          </div>
          <pre><span class="kw">const</span> res = <span class="kw">await</span> <span class="fn">fetch</span>(<span class="str">'<span id="fetch-url-preview">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>, {
  method:  <span class="str">'POST'</span>,
  headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> },
  body:    <span class="kw">new</span> <span class="fn">FormData</span>(form)
});
<span class="kw">const</span> data = <span class="kw">await</span> res.<span class="fn">json</span>();</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- ════════ JQUERY ════════ -->
  <div class="panel" id="panel-jquery">
    <div class="two-col">

      <div class="card">
        <div class="card-title">Form Fields</div>
        <div class="field-group">
          <label>Name</label>
          <input type="text" id="jq-name" placeholder="John Doe" value="John Doe">
        </div>
        <div class="field-group">
          <label>Email</label>
          <input type="email" id="jq-email" placeholder="john@example.com" value="john@example.com">
        </div>
        <div class="field-group">
          <label>Message</label>
          <textarea id="jq-message" placeholder="Hello from jQuery...">Testing jQuery AJAX submission</textarea>
        </div>
        <button class="submit-btn" id="jq-btn" onclick="submitJQuery()">Send via jQuery</button>
      </div>

      <div style="display:flex;flex-direction:column;gap:16px">
        <div class="response-box">
          <div class="response-header">
            <span class="response-label">Response</span>
            <span class="status-badge">
              <span class="status-dot" id="jq-dot"></span>
              <span id="jq-status">Waiting…</span>
            </span>
          </div>
          <div class="response-body" id="jq-response">Hit "Send" to see the live response here.</div>
        </div>

        <div class="code-preview">
          <div class="code-preview-top">
            <span class="code-preview-lang">JavaScript — jQuery</span>
            <button class="copy-btn" onclick="copyPre(this)">Copy</button>
          </div>
          <pre>$.<span class="fn">ajax</span>({
  url:         <span class="str">'<span id="jq-url-preview">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>,
  method:      <span class="str">'POST'</span>,
  data:        <span class="kw">new</span> <span class="fn">FormData</span>(<span class="kw">this</span>),
  dataType:    <span class="str">'json'</span>,
  processData: <span class="kw">false</span>,
  contentType: <span class="kw">false</span>,
  headers:     { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> }
});</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- ════════ AXIOS ════════ -->
  <div class="panel" id="panel-axios">
    <div class="two-col">

      <div class="card">
        <div class="card-title">Form Fields</div>
        <div class="field-group">
          <label>Name</label>
          <input type="text" id="ax-name" placeholder="John Doe" value="John Doe">
        </div>
        <div class="field-group">
          <label>Email</label>
          <input type="email" id="ax-email" placeholder="john@example.com" value="john@example.com">
        </div>
        <div class="field-group">
          <label>Message</label>
          <textarea id="ax-message" placeholder="Hello from Axios...">Testing Axios submission</textarea>
        </div>
        <button class="submit-btn" id="ax-btn" onclick="submitAxios()">Send via Axios</button>
      </div>

      <div style="display:flex;flex-direction:column;gap:16px">
        <div class="response-box">
          <div class="response-header">
            <span class="response-label">Response</span>
            <span class="status-badge">
              <span class="status-dot" id="ax-dot"></span>
              <span id="ax-status">Waiting…</span>
            </span>
          </div>
          <div class="response-body" id="ax-response">Hit "Send" to see the live response here.</div>
        </div>

        <div class="code-preview">
          <div class="code-preview-top">
            <span class="code-preview-lang">JavaScript — Axios</span>
            <button class="copy-btn" onclick="copyPre(this)">Copy</button>
          </div>
          <pre><span class="kw">await</span> axios.<span class="fn">post</span>(
  <span class="str">'<span id="ax-url-preview">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>,
  <span class="kw">new</span> <span class="fn">FormData</span>(form),
  { headers: { <span class="str">'Accept'</span>: <span class="str">'application/json'</span> } }
);</pre>
        </div>
      </div>
    </div>
  </div>

  <!-- ════════ XHR ════════ -->
  <div class="panel" id="panel-xhr">
    <div class="two-col">

      <div class="card">
        <div class="card-title">Form Fields</div>
        <div class="field-group">
          <label>Name</label>
          <input type="text" id="xhr-name" placeholder="John Doe" value="John Doe">
        </div>
        <div class="field-group">
          <label>Email</label>
          <input type="email" id="xhr-email" placeholder="john@example.com" value="john@example.com">
        </div>
        <div class="field-group">
          <label>Message</label>
          <textarea id="xhr-message" placeholder="Hello from XHR...">Testing XMLHttpRequest submission</textarea>
        </div>
        <button class="submit-btn" id="xhr-btn" onclick="submitXHR()">Send via XHR</button>
      </div>

      <div style="display:flex;flex-direction:column;gap:16px">
        <div class="response-box">
          <div class="response-header">
            <span class="response-label">Response</span>
            <span class="status-badge">
              <span class="status-dot" id="xhr-dot"></span>
              <span id="xhr-status">Waiting…</span>
            </span>
          </div>
          <div class="response-body" id="xhr-response">Hit "Send" to see the live response here.</div>
        </div>

        <div class="code-preview">
          <div class="code-preview-top">
            <span class="code-preview-lang">JavaScript — XHR</span>
            <button class="copy-btn" onclick="copyPre(this)">Copy</button>
          </div>
          <pre><span class="kw">var</span> xhr = <span class="kw">new</span> <span class="fn">XMLHttpRequest</span>();
xhr.<span class="fn">open</span>(<span class="str">'POST'</span>, <span class="str">'<span id="xhr-url-preview">http://127.0.0.1:8000/f/f_l63kxxnb</span>'</span>);
xhr.<span class="fn">setRequestHeader</span>(<span class="str">'Accept'</span>, <span class="str">'application/json'</span>);
xhr.<span class="fn">send</span>(<span class="kw">new</span> <span class="fn">FormData</span>(form));</pre>
        </div>
      </div>
    </div>
  </div>

</div><!-- /page -->

<script>
  /* ── Tab switch ── */
  function switchTab(name) {
    document.querySelectorAll('.tab-btn').forEach((b, i) => {
      b.classList.toggle('active', ['fetch','jquery','axios','xhr'][i] === name);
    });
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
  }

  /* ── Sync endpoint to code previews ── */
  document.getElementById('globalEndpoint').addEventListener('input', function() {
    const url = this.value;
    ['fetch','jq','ax','xhr'].forEach(k => {
      const el = document.getElementById(k + '-url-preview');
      if (el) el.textContent = url;
    });
  });

  /* ── Set response state ── */
  function setResponse(prefix, status, text, state) {
    const dot  = document.getElementById(prefix + '-dot');
    const stat = document.getElementById(prefix + '-status');
    const body = document.getElementById(prefix + '-response');
    dot.className  = 'status-dot ' + state;
    stat.textContent = status;
    body.className = 'response-body ' + (state === 'wait' ? '' : state);
    body.textContent = text;
  }

  function getEndpoint() {
    return document.getElementById('globalEndpoint').value.trim();
  }

  function buildFormData(prefix) {
    const fd = new FormData();
    fd.append('name',    document.getElementById(prefix + '-name').value);
    fd.append('email',   document.getElementById(prefix + '-email').value);
    fd.append('message', document.getElementById(prefix + '-message').value);
    return fd;
  }

  function formatResponse(data) {
    return JSON.stringify(data, null, 2);
  }

  /* ── FETCH ── */
  async function submitFetch() {
    const btn = document.getElementById('fetch-btn');
    btn.disabled = true; btn.textContent = 'Sending…';
    setResponse('fetch', 'Sending…', 'Request in flight…', 'wait');
    try {
      const res  = await fetch(getEndpoint(), {
        method:  'POST',
        headers: { 'Accept': 'application/json' },
        body:    buildFormData('fetch')
      });
      const data = await res.json();
      setResponse('fetch', res.status + ' ' + (res.ok ? 'OK' : 'Error'),
        formatResponse(data), res.ok ? 'ok' : 'err');
    } catch (e) {
      setResponse('fetch', 'Network Error', e.message, 'err');
    } finally {
      btn.disabled = false; btn.textContent = 'Send via Fetch';
    }
  }

  /* ── JQUERY ── */
  function submitJQuery() {
    const btn = $('#jq-btn');
    btn.prop('disabled', true).text('Sending…');
    setResponse('jq', 'Sending…', 'Request in flight…', 'wait');
    const fd = buildFormData('jq');
    $.ajax({
      url:         getEndpoint(),
      method:      'POST',
      data:        fd,
      dataType:    'json',
      processData: false,
      contentType: false,
      headers:     { 'Accept': 'application/json' },
      success: function(data) {
        setResponse('jq', '200 OK', formatResponse(data), 'ok');
      },
      error: function(xhr) {
        let msg = xhr.responseText;
        try { msg = formatResponse(JSON.parse(msg)); } catch(e) {}
        setResponse('jq', xhr.status + ' Error', msg, 'err');
      },
      complete: function() {
        btn.prop('disabled', false).text('Send via jQuery');
      }
    });
  }

  /* ── AXIOS ── */
  async function submitAxios() {
    const btn = document.getElementById('ax-btn');
    btn.disabled = true; btn.textContent = 'Sending…';
    setResponse('ax', 'Sending…', 'Request in flight…', 'wait');
    try {
      const { data } = await axios.post(
        getEndpoint(),
        buildFormData('ax'),
        { headers: { 'Accept': 'application/json' } }
      );
      setResponse('ax', '200 OK', formatResponse(data), 'ok');
    } catch (err) {
      const data = err.response?.data;
      setResponse('ax', (err.response?.status || 'Network') + ' Error',
        data ? formatResponse(data) : err.message, 'err');
    } finally {
      btn.disabled = false; btn.textContent = 'Send via Axios';
    }
  }

  /* ── XHR ── */
  function submitXHR() {
    const btn = document.getElementById('xhr-btn');
    btn.disabled = true; btn.textContent = 'Sending…';
    setResponse('xhr', 'Sending…', 'Request in flight…', 'wait');
    const req = new XMLHttpRequest();
    req.open('POST', getEndpoint());
    req.setRequestHeader('Accept', 'application/json');
    req.onload = function() {
      let data;
      try { data = JSON.parse(req.responseText); } catch(e) { data = req.responseText; }
      const ok = req.status >= 200 && req.status < 300;
      setResponse('xhr', req.status + ' ' + (ok ? 'OK' : 'Error'),
        typeof data === 'object' ? formatResponse(data) : data, ok ? 'ok' : 'err');
      btn.disabled = false; btn.textContent = 'Send via XHR';
    };
    req.onerror = function() {
      setResponse('xhr', 'Network Error', 'Could not reach server. Is Laravel running?', 'err');
      btn.disabled = false; btn.textContent = 'Send via XHR';
    };
    req.send(buildFormData('xhr'));
  }

  /* ── Copy code ── */
  function copyPre(btn) {
    const text = btn.closest('.code-preview').querySelector('pre').innerText;
    navigator.clipboard.writeText(text).then(() => {
      btn.textContent = 'Copied!';
      btn.classList.add('copied');
      setTimeout(() => { btn.textContent = 'Copy'; btn.classList.remove('copied'); }, 1600);
    });
  }
</script>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/test.blade.php ENDPATH**/ ?>