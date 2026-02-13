@extends('layouts.app')

@section('title', 'Job Application Form - 000form Library')

@push('styles')
<link href="{{ asset('css/library.css') }}" rel="stylesheet">
<link href="{{ asset('css/category.css') }}" rel="stylesheet">
<link href="{{ asset('css/tenant-form.css') }}" rel="stylesheet">
<style>
    .form-preview-code {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: stretch;
        margin-bottom: 2rem;
    }

    .form-preview-card,
    .code-tabs-container {
        height: auto;
        display: flex;
        flex-direction: column;
    }

    .live-form-preview {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .preview-frame {
        flex: 1;
        overflow-y: auto;
        max-height: 600px;
    }

    .code-tabs-container {
        display: flex;
        flex-direction: column;
    }

    .code-tab-panel.active {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .code-block-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .code-block-content {
        flex: 1;
        overflow-y: auto;
        max-height: 500px;
        min-height: 400px;
    }

    @media (max-width: 992px) {
        .form-preview-code {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .preview-frame {
            max-height: 500px;
        }
        
        .code-block-content {
            max-height: 400px;
            min-height: 300px;
        }
    }

    @media (max-width: 576px) {
        .form-preview-card {
            padding: 1rem;
        }
        
        .preview-frame {
            padding: 0.75rem;
        }
        
        .code-tabs {
            flex-direction: column;
        }
        
        .code-tab {
            width: 100%;
            text-align: center;
        }
        
        .code-block-header {
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }
        
        .code-block-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .related-forms-grid {
            grid-template-columns: 1fr;
        }
        
        .instruction-card {
            flex-direction: column;
            gap: 1rem;
        }
    }

    .job-form-preview {
        max-width: 100%;
        padding: 1.5rem;
        background: #0d0d0d;
        border: 1px solid #1a1a1a;
        border-radius: 12px;
    }

    .job-form-preview h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #fafafa;
        margin-bottom: 0.5rem;
    }

    .job-form-preview .form-description {
        font-size: 0.9rem;
        color: #888888;
        margin-bottom: 1.5rem;
    }

    .job-form-preview .form-group {
        margin-bottom: 1.25rem;
    }

    .job-form-preview label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #e6edf3;
        margin-bottom: 0.5rem;
    }

    .job-form-preview .form-input,
    .job-form-preview .form-select,
    .job-form-preview .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: #111111;
        border: 1px solid #1a1a1a;
        border-radius: 8px;
        color: #fafafa;
        font-size: 0.95rem;
    }

    .job-form-preview .checkbox-group {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.5rem;
    }

    .job-form-preview .checkbox-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #888888;
        font-size: 0.85rem;
    }

    .job-form-preview .form-submit {
        width: 100%;
        padding: 0.75rem 1.5rem;
        background: var(--accent);
        border: none;
        border-radius: 8px;
        color: var(--bg-primary);
        font-size: 1rem;
        font-weight: 500;
        margin-top: 0.5rem;
        cursor: not-allowed;
        opacity: 0.9;
    }
</style>
@endpush

@section('content')

<section class="form-detail-section">
    <div class="container">
        
        <div class="form-breadcrumb">
            <a href="{{ route('Home.library') }}">Library</a>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
            <a href="{{ route('Home.library.ApplicationForm') }}">Application Forms</a>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
            <span>Job Application Form</span>
        </div>

        <div class="form-preview-code">
            
            <div class="form-preview-card">
                <div class="form-preview-header">
                    <div>
                        <h2>Job Application Form</h2>
                        <p class="form-preview-subtitle">Apply for an open position at our company. Please fill in all required information.</p>
                    </div>
                </div>
                
                <div class="live-form-preview">
                    <h3 class="preview-title">Form Preview</h3>
                    <div class="preview-frame">
                        
                        <div class="job-form-preview">
                            <div class="form-group">
                                <label>Full Name:</label>
                                <input type="text" class="form-input" placeholder="Enter your name" disabled>
                            </div>

                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" class="form-input" placeholder="Enter your email" disabled>
                            </div>

                            <div class="form-group">
                                <label>Position:</label>
                                <select class="form-select" disabled>
                                    <option>Select a position</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Availability:</label>
                                <div class="checkbox-group">
                                    <div class="checkbox-item">
                                        <input type="checkbox" disabled> Full-Time
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" disabled> Part-Time
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Why do you want this job?</label>
                                <textarea class="form-textarea" rows="3" placeholder="Write your motivation" disabled></textarea>
                            </div>

                            <button class="form-submit" disabled>Submit Application</button>
                            
                            <div class="form-note">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="12" x2="12" y2="16"/>
                                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                                </svg>
                                This is a preview. The actual form will be fully interactive.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="code-tabs-container">
                <div class="code-tabs-header">
                    <h3 class="code-tabs-title">Get the code</h3>
                    <p class="code-tabs-subtitle">Copy and paste this code into your website. Don't forget to replace <span class="code-highlight">your-endpoint</span> with your actual 000form endpoint URL.</p>
                </div>
                
                <div class="code-tabs">
                    <button class="code-tab active" onclick="switchTab(event, 'html-tab')">HTML</button>
                    <button class="code-tab" onclick="switchTab(event, 'css-tab')">CSS</button>
                    <button class="code-tab" onclick="switchTab(event, 'tailwind-tab')">Tailwind</button>
                </div>
                
                <div id="html-tab" class="code-tab-panel active">
                    <div class="code-block-wrapper">
                        <div class="code-block-header">
                            <div class="code-block-info">
                                <span class="code-block-language">HTML</span>
                                <span class="code-block-desc">Complete HTML form with 000form endpoint</span>
                            </div>
                            <button class="code-copy-btn" onclick="copyCode(this, 'html-code-content')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                Copy HTML
                            </button>
                        </div>
                        <div class="code-block-content">
                            <pre id="html-code-content"><span class="hljs-tag">&lt;form</span> <span class="hljs-attr">action=</span><span class="hljs-string">"https://000form.com/f/your-endpoint"</span> <span class="hljs-attr">method=</span><span class="hljs-string">"POST"</span> <span class="hljs-attr">class=</span><span class="hljs-string">"job-form"</span><span class="hljs-tag">&gt;</span>
  <span class="hljs-tag">&lt;h3&gt;</span>Job Application Form<span class="hljs-tag">&lt;/h3&gt;</span>
  <span class="hljs-tag">&lt;p</span> <span class="hljs-attr">class=</span><span class="hljs-string">"form-description"</span><span class="hljs-tag">&gt;</span>
    Apply for an open position at our company. Please fill in all required information.
  <span class="hljs-tag">&lt;/p&gt;</span>

  <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"form-group"</span><span class="hljs-tag">&gt;</span>
    <span class="hljs-tag">&lt;label</span> <span class="hljs-attr">for=</span><span class="hljs-string">"full_name"</span><span class="hljs-tag">&gt;</span>Full Name:<span class="hljs-tag">&lt;/label&gt;</span>
    <span class="hljs-tag">&lt;input</span> <span class="hljs-attr">type=</span><span class="hljs-string">"text"</span> <span class="hljs-attr">id=</span><span class="hljs-string">"full_name"</span> <span class="hljs-attr">name=</span><span class="hljs-string">"full_name"</span> 
           <span class="hljs-attr">placeholder=</span><span class="hljs-string">"Enter your name"</span> <span class="hljs-attr">required</span><span class="hljs-tag">&gt;</span>
  <span class="hljs-tag">&lt;/div&gt;</span>

  <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"form-group"</span><span class="hljs-tag">&gt;</span>
    <span class="hljs-tag">&lt;label</span> <span class="hljs-attr">for=</span><span class="hljs-string">"email"</span><span class="hljs-tag">&gt;</span>Email:<span class="hljs-tag">&lt;/label&gt;</span>
    <span class="hljs-tag">&lt;input</span> <span class="hljs-attr">type=</span><span class="hljs-string">"email"</span> <span class="hljs-attr">id=</span><span class="hljs-string">"email"</span> <span class="hljs-attr">name=</span><span class="hljs-string">"email"</span> 
           <span class="hljs-attr">placeholder=</span><span class="hljs-string">"Enter your email"</span> <span class="hljs-attr">required</span><span class="hljs-tag">&gt;</span>
  <span class="hljs-tag">&lt;/div&gt;</span>

  <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"form-group"</span><span class="hljs-tag">&gt;</span>
    <span class="hljs-tag">&lt;label</span> <span class="hljs-attr">for=</span><span class="hljs-string">"position"</span><span class="hljs-tag">&gt;</span>Position:<span class="hljs-tag">&lt;/label&gt;</span>
    <span class="hljs-tag">&lt;select</span> <span class="hljs-attr">id=</span><span class="hljs-string">"position"</span> <span class="hljs-attr">name=</span><span class="hljs-string">"position"</span> <span class="hljs-attr">required</span><span class="hljs-tag">&gt;</span>
      <span class="hljs-tag">&lt;option</span> <span class="hljs-attr">value=</span><span class="hljs-string">""</span><span class="hljs-tag">&gt;</span>Select a position<span class="hljs-tag">&lt;/option&gt;</span>
      <span class="hljs-tag">&lt;option</span> <span class="hljs-attr">value=</span><span class="hljs-string">"software-engineer"</span><span class="hljs-tag">&gt;</span>Software Engineer<span class="hljs-tag">&lt;/option&gt;</span>
      <span class="hljs-tag">&lt;option</span> <span class="hljs-attr">value=</span><span class="hljs-string">"product-manager"</span><span class="hljs-tag">&gt;</span>Product Manager<span class="hljs-tag">&lt;/option&gt;</span>
      <span class="hljs-tag">&lt;option</span> <span class="hljs-attr">value=</span><span class="hljs-string">"designer"</span><span class="hljs-tag">&gt;</span>Designer<span class="hljs-tag">&lt;/option&gt;</span>
    <span class="hljs-tag">&lt;/select&gt;</span>
  <span class="hljs-tag">&lt;/div&gt;</span>

  <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"form-group"</span><span class="hljs-tag">&gt;</span>
    <span class="hljs-tag">&lt;label&gt;</span>Availability:<span class="hljs-tag">&lt;/label&gt;</span>
    <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"checkbox-group"</span><span class="hljs-tag">&gt;</span>
      <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"checkbox-item"</span><span class="hljs-tag">&gt;</span>
        <span class="hljs-tag">&lt;input</span> <span class="hljs-attr">type=</span><span class="hljs-string">"checkbox"</span> <span class="hljs-attr">id=</span><span class="hljs-string">"fulltime"</span> <span class="hljs-attr">name=</span><span class="hljs-string">"availability[]"</span> <span class="hljs-attr">value=</span><span class="hljs-string">"full-time"</span><span class="hljs-tag">&gt;</span>
        <span class="hljs-tag">&lt;label</span> <span class="hljs-attr">for=</span><span class="hljs-string">"fulltime"</span><span class="hljs-tag">&gt;</span>Full-Time<span class="hljs-tag">&lt;/label&gt;</span>
      <span class="hljs-tag">&lt;/div&gt;</span>
      <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"checkbox-item"</span><span class="hljs-tag">&gt;</span>
        <span class="hljs-tag">&lt;input</span> <span class="hljs-attr">type=</span><span class="hljs-string">"checkbox"</span> <span class="hljs-attr">id=</span><span class="hljs-string">"parttime"</span> <span class="hljs-attr">name=</span><span class="hljs-string">"availability[]"</span> <span class="hljs-attr">value=</span><span class="hljs-string">"part-time"</span><span class="hljs-tag">&gt;</span>
        <span class="hljs-tag">&lt;label</span> <span class="hljs-attr">for=</span><span class="hljs-string">"parttime"</span><span class="hljs-tag">&gt;</span>Part-Time<span class="hljs-tag">&lt;/label&gt;</span>
      <span class="hljs-tag">&lt;/div&gt;</span>
    <span class="hljs-tag">&lt;/div&gt;</span>
  <span class="hljs-tag">&lt;/div&gt;</span>

  <span class="hljs-tag">&lt;div</span> <span class="hljs-attr">class=</span><span class="hljs-string">"form-group"</span><span class="hljs-tag">&gt;</span>
    <span class="hljs-tag">&lt;label</span> <span class="hljs-attr">for=</span><span class="hljs-string">"motivation"</span><span class="hljs-tag">&gt;</span>Why do you want this job?<span class="hljs-tag">&lt;/label&gt;</span>
    <span class="hljs-tag">&lt;textarea</span> <span class="hljs-attr">id=</span><span class="hljs-string">"motivation"</span> <span class="hljs-attr">name=</span><span class="hljs-string">"motivation"</span> 
              <span class="hljs-attr">placeholder=</span><span class="hljs-string">"Write your motivation"</span> <span class="hljs-attr">required</span><span class="hljs-tag">&gt;&lt;/textarea&gt;</span>
  <span class="hljs-tag">&lt;/div&gt;</span>

  <span class="hljs-tag">&lt;button</span> <span class="hljs-attr">type=</span><span class="hljs-string">"submit"</span> <span class="hljs-attr">class=</span><span class="hljs-string">"submit-btn"</span><span class="hljs-tag">&gt;</span>Submit Application<span class="hljs-tag">&lt;/button&gt;</span>
<span class="hljs-tag">&lt;/form&gt;</span></pre>
                        </div>
                    </div>
                </div>
                
                <div id="css-tab" class="code-tab-panel">
                    <div class="code-block-wrapper">
                        <div class="code-block-header">
                            <div class="code-block-info">
                                <span class="code-block-language">CSS</span>
                                <span class="code-block-desc">Styling for the job application form</span>
                            </div>
                            <button class="code-copy-btn" onclick="copyCode(this, 'css-code-content')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                Copy CSS
                            </button>
                        </div>
                        <div class="code-block-content">
                            <pre id="css-code-content"><span class="hljs-selector-class">.job-form</span> {
  <span class="hljs-attribute">max-width</span>: <span class="hljs-number">600px</span>;
  <span class="hljs-attribute">margin</span>: <span class="hljs-number">0</span> auto;
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">2rem</span>;
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#0d0d0d</span>;
  <span class="hljs-attribute">border</span>: <span class="hljs-number">1px</span> solid <span class="hljs-number">#1a1a1a</span>;
  <span class="hljs-attribute">border-radius</span>: <span class="hljs-number">12px</span>;
  <span class="hljs-attribute">font-family</span>: <span class="hljs-string">'Outfit'</span>, sans-serif;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">h3</span> {
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">1.5rem</span>;
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">600</span>;
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fafafa</span>;
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">0.5rem</span>;
  <span class="hljs-attribute">letter-spacing</span>: -<span class="hljs-number">0.02em</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.form-description</span> {
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">0.9rem</span>;
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#888888</span>;
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">1.5rem</span>;
  <span class="hljs-attribute">line-height</span>: <span class="hljs-number">1.6</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.form-group</span> {
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">1.25rem</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">label</span> {
  <span class="hljs-attribute">display</span>: block;
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">0.85rem</span>;
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">600</span>;
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#e6edf3</span>;
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">0.5rem</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">input</span><span class="hljs-selector-attr">[type="text"]</span>,
<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">input</span><span class="hljs-selector-attr">[type="email"]</span>,
<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">select</span>,
<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">textarea</span> {
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">0.75rem</span> <span class="hljs-number">1rem</span>;
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#111111</span>;
  <span class="hljs-attribute">border</span>: <span class="hljs-number">1px</span> solid <span class="hljs-number">#1a1a1a</span>;
  <span class="hljs-attribute">border-radius</span>: <span class="hljs-number">8px</span>;
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#fafafa</span>;
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">0.95rem</span>;
  <span class="hljs-attribute">transition</span>: all <span class="hljs-number">0.2s</span> ease;
  <span class="hljs-attribute">font-family</span>: inherit;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">input</span><span class="hljs-selector-pseudo">:focus</span>,
<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">select</span><span class="hljs-selector-pseudo">:focus</span>,
<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">textarea</span><span class="hljs-selector-pseudo">:focus</span> {
  <span class="hljs-attribute">outline</span>: none;
  <span class="hljs-attribute">border-color</span>: <span class="hljs-number">#00ff88</span>;
  <span class="hljs-attribute">box-shadow</span>: <span class="hljs-number">0</span> <span class="hljs-number">0</span> <span class="hljs-number">0</span> <span class="hljs-number">3px</span> <span class="hljs-built_in">rgba</span>(0, 255, 136, 0.15);
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">input</span><span class="hljs-selector-pseudo">::placeholder</span>,
<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">textarea</span><span class="hljs-selector-pseudo">::placeholder</span> {
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#555555</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">select</span> {
  <span class="hljs-attribute">cursor</span>: pointer;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.checkbox-group</span> {
  <span class="hljs-attribute">display</span>: flex;
  <span class="hljs-attribute">gap</span>: <span class="hljs-number">1.5rem</span>;
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">0.5rem</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.checkbox-item</span> {
  <span class="hljs-attribute">display</span>: flex;
  <span class="hljs-attribute">align-items</span>: center;
  <span class="hljs-attribute">gap</span>: <span class="hljs-number">0.5rem</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">input</span><span class="hljs-selector-attr">[type="checkbox"]</span> {
  <span class="hljs-attribute">width</span>: <span class="hljs-number">18px</span>;
  <span class="hljs-attribute">height</span>: <span class="hljs-number">18px</span>;
  <span class="hljs-attribute">accent-color</span>: <span class="hljs-number">#00ff88</span>;
  <span class="hljs-attribute">cursor</span>: pointer;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.checkbox-item</span> <span class="hljs-selector-tag">label</span> {
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">0.85rem</span>;
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#888888</span>;
  <span class="hljs-attribute">cursor</span>: pointer;
  <span class="hljs-attribute">margin-bottom</span>: <span class="hljs-number">0</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-tag">textarea</span> {
  <span class="hljs-attribute">resize</span>: vertical;
  <span class="hljs-attribute">min-height</span>: <span class="hljs-number">100px</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.submit-btn</span> {
  <span class="hljs-attribute">width</span>: <span class="hljs-number">100%</span>;
  <span class="hljs-attribute">padding</span>: <span class="hljs-number">0.875rem</span> <span class="hljs-number">1.5rem</span>;
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#00ff88</span>;
  <span class="hljs-attribute">border</span>: none;
  <span class="hljs-attribute">border-radius</span>: <span class="hljs-number">8px</span>;
  <span class="hljs-attribute">color</span>: <span class="hljs-number">#050505</span>;
  <span class="hljs-attribute">font-size</span>: <span class="hljs-number">1rem</span>;
  <span class="hljs-attribute">font-weight</span>: <span class="hljs-number">600</span>;
  <span class="hljs-attribute">cursor</span>: pointer;
  <span class="hljs-attribute">transition</span>: all <span class="hljs-number">0.2s</span> ease;
  <span class="hljs-attribute">margin-top</span>: <span class="hljs-number">0.5rem</span>;
}

<span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.submit-btn</span><span class="hljs-selector-pseudo">:hover</span> {
  <span class="hljs-attribute">background</span>: <span class="hljs-number">#fafafa</span>;
  <span class="hljs-attribute">transform</span>: <span class="hljs-built_in">translateY</span>(-<span class="hljs-number">1px</span>);
  <span class="hljs-attribute">box-shadow</span>: <span class="hljs-number">0</span> <span class="hljs-number">4px</span> <span class="hljs-number">20px</span> <span class="hljs-built_in">rgba</span>(0, 255, 136, 0.15);
}

<span class="hljs-keyword">@media</span> (<span class="hljs-attribute">max-width:</span> <span class="hljs-number">768px</span>) {
  <span class="hljs-selector-class">.job-form</span> {
    <span class="hljs-attribute">padding</span>: <span class="hljs-number">1.5rem</span>;
  }
  
  <span class="hljs-selector-class">.job-form</span> <span class="hljs-selector-class">.checkbox-group</span> {
    <span class="hljs-attribute">flex-direction</span>: column;
    <span class="hljs-attribute">gap</span>: <span class="hljs-number">0.75rem</span>;
  }
}</pre>
                        </div>
                    </div>
                </div>

                <div id="tailwind-tab" class="code-tab-panel">
                    <div class="code-block-wrapper">
                        <div class="code-block-header">
                            <div class="code-block-info">
                                <span class="code-block-language">Tailwind CSS</span>
                                <span class="code-block-desc">Tailwind version with external CSS file</span>
                            </div>
                            <button class="code-copy-btn" onclick="copyCode(this, 'tailwind-code-content')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                                Copy Code
                            </button>
                        </div>
                        <div class="code-block-content">
                            <pre id="tailwind-code-content"><span class="hljs-comment">&lt;!-- Add Tailwind CSS CDN to your &lt;head&gt; --&gt;</span>
<span class="hljs-tag">&lt;<span class="hljs-name">script</span> <span class="hljs-attr">src</span>=<span class="hljs-string">"https://cdn.tailwindcss.com"</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">script</span>&gt;</span>

<span class="hljs-comment">&lt;!-- HTML with Tailwind Classes --&gt;</span>
<span class="hljs-tag">&lt;<span class="hljs-name">form</span> <span class="hljs-attr">action</span>=<span class="hljs-string">"https://000form.com/f/your-endpoint"</span> 
      <span class="hljs-attr">method</span>=<span class="hljs-string">"POST"</span>
      <span class="hljs-attr">class</span>=<span class="hljs-string">"job-form-container max-w-2xl mx-auto p-8 bg-[#0d0d0d] border border-[#1a1a1a] rounded-xl"</span>&gt;</span>
  
  <span class="hljs-tag">&lt;<span class="hljs-name">h3</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"text-2xl font-semibold text-[#fafafa] mb-2 tracking-tight"</span>&gt;</span>
    Job Application Form
  <span class="hljs-tag">&lt;/<span class="hljs-name">h3</span>&gt;</span>
  
  <span class="hljs-tag">&lt;<span class="hljs-name">p</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"text-sm text-[#888888] mb-6 leading-relaxed"</span>&gt;</span>
    Apply for an open position at our company. Please fill in all required information.
  <span class="hljs-tag">&lt;/<span class="hljs-name">p</span>&gt;</span>

  <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-5"</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"block text-sm font-semibold text-[#e6edf3] mb-2"</span>&gt;</span>Full Name:<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"text"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"full_name"</span>
           <span class="hljs-attr">placeholder</span>=<span class="hljs-string">"Enter your name"</span>
           <span class="hljs-attr">class</span>=<span class="hljs-string">"w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"</span>
           <span class="hljs-attr">required</span>&gt;</span>
  <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>

  <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-5"</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"block text-sm font-semibold text-[#e6edf3] mb-2"</span>&gt;</span>Email:<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"email"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"email"</span>
           <span class="hljs-attr">placeholder</span>=<span class="hljs-string">"Enter your email"</span>
           <span class="hljs-attr">class</span>=<span class="hljs-string">"w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"</span>
           <span class="hljs-attr">required</span>&gt;</span>
  <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>

  <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-5"</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"block text-sm font-semibold text-[#e6edf3] mb-2"</span>&gt;</span>Position:<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">select</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"position"</span>
            <span class="hljs-attr">class</span>=<span class="hljs-string">"w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] focus:border-[#00ff88] transition-all cursor-pointer"</span>
            <span class="hljs-attr">required</span>&gt;</span>
      <span class="hljs-tag">&lt;<span class="hljs-name">option</span> <span class="hljs-attr">value</span>=<span class="hljs-string">""</span>&gt;</span>Select a position<span class="hljs-tag">&lt;/<span class="hljs-name">option</span>&gt;</span>
      <span class="hljs-tag">&lt;<span class="hljs-name">option</span> <span class="hljs-attr">value</span>=<span class="hljs-string">"software-engineer"</span>&gt;</span>Software Engineer<span class="hljs-tag">&lt;/<span class="hljs-name">option</span>&gt;</span>
      <span class="hljs-tag">&lt;<span class="hljs-name">option</span> <span class="hljs-attr">value</span>=<span class="hljs-string">"product-manager"</span>&gt;</span>Product Manager<span class="hljs-tag">&lt;/<span class="hljs-name">option</span>&gt;</span>
      <span class="hljs-tag">&lt;<span class="hljs-name">option</span> <span class="hljs-attr">value</span>=<span class="hljs-string">"designer"</span>&gt;</span>Designer<span class="hljs-tag">&lt;/<span class="hljs-name">option</span>&gt;</span>
    <span class="hljs-tag">&lt;/<span class="hljs-name">select</span>&gt;</span>
  <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>

  <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-5"</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"block text-sm font-semibold text-[#e6edf3] mb-2"</span>&gt;</span>Availability:<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"flex flex-col sm:flex-row gap-6 mt-2"</span>&gt;</span>
      <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"flex items-center gap-2 cursor-pointer"</span>&gt;</span>
        <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"checkbox"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"availability[]"</span> <span class="hljs-attr">value</span>=<span class="hljs-string">"full-time"</span>
               <span class="hljs-attr">class</span>=<span class="hljs-string">"w-[18px] h-[18px] cursor-pointer"</span>&gt;</span>
        <span class="hljs-tag">&lt;<span class="hljs-name">span</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"text-sm text-[#888888]"</span>&gt;</span>Full-Time<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span>
      <span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
      <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"flex items-center gap-2 cursor-pointer"</span>&gt;</span>
        <span class="hljs-tag">&lt;<span class="hljs-name">input</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"checkbox"</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"availability[]"</span> <span class="hljs-attr">value</span>=<span class="hljs-string">"part-time"</span>
               <span class="hljs-attr">class</span>=<span class="hljs-string">"w-[18px] h-[18px] cursor-pointer"</span>&gt;</span>
        <span class="hljs-tag">&lt;<span class="hljs-name">span</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"text-sm text-[#888888]"</span>&gt;</span>Part-Time<span class="hljs-tag">&lt;/<span class="hljs-name">span</span>&gt;</span>
      <span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
    <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>
  <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>

  <span class="hljs-tag">&lt;<span class="hljs-name">div</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"mb-6"</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">label</span> <span class="hljs-attr">class</span>=<span class="hljs-string">"block text-sm font-semibold text-[#e6edf3] mb-2"</span>&gt;</span>Why do you want this job?<span class="hljs-tag">&lt;/<span class="hljs-name">label</span>&gt;</span>
    <span class="hljs-tag">&lt;<span class="hljs-name">textarea</span> <span class="hljs-attr">name</span>=<span class="hljs-string">"motivation"</span> <span class="hljs-attr">rows</span>=<span class="hljs-string">"4"</span>
              <span class="hljs-attr">placeholder</span>=<span class="hljs-string">"Write your motivation"</span>
              <span class="hljs-attr">class</span>=<span class="hljs-string">"w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all resize-y min-h-[100px]"</span>
              <span class="hljs-attr">required</span>&gt;</span><span class="hljs-tag">&lt;/<span class="hljs-name">textarea</span>&gt;</span>
  <span class="hljs-tag">&lt;/<span class="hljs-name">div</span>&gt;</span>

  <span class="hljs-tag">&lt;<span class="hljs-name">button</span> <span class="hljs-attr">type</span>=<span class="hljs-string">"submit"</span>
          <span class="hljs-attr">class</span>=<span class="hljs-string">"w-full py-3 px-6 bg-[#00ff88] text-[#050505] font-semibold rounded-lg hover:bg-white transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#00ff88]/20"</span>&gt;</span>
    Submit Application
  <span class="hljs-tag">&lt;/<span class="hljs-name">button</span>&gt;</span>
<span class="hljs-tag">&lt;/<span class="hljs-name">form</span>&gt;</span></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-instructions">
            <div class="instruction-card">
                <div class="instruction-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                </div>
                <div class="instruction-content">
                    <h4>How to use this form</h4>
                    <ol>
                        <li><strong>Copy the HTML code</strong> and paste it into your website where you want the form to appear.</li>
                        <li><strong>Copy the CSS code</strong> and add it to your stylesheet, or use the Tailwind version if you're using Tailwind CSS.</li>
                        <li><strong>Replace <code>your-endpoint</code></strong> in the form action with your actual 000form endpoint URL.</li>
                        <li><strong>That's it!</strong> Your form will start receiving submissions directly to your inbox.</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <div class="related-forms">
            <h3>Related Application Forms</h3>
            <div class="related-forms-grid">
                <a href="#" class="related-form-card">
                    <h4>Rental Application Form</h4>
                    <p>Property rental application</p>
                    <span class="related-form-link">View form →</span>
                </a>
                <a href="#" class="related-form-card">
                    <h4>Vendor Application Form</h4>
                    <p>Supplier registration form</p>
                    <span class="related-form-link">View form →</span>
                </a>
                <a href="#" class="related-form-card">
                    <h4>Scholarship Application Form</h4>
                    <p>Educational financial aid form</p>
                    <span class="related-form-link">View form →</span>
                </a>
            </div>
        </div>
        
    </div>
</section>

<script>
    function switchTab(event, tabId) {
        const tabs = document.querySelectorAll('.code-tab');
        const panels = document.querySelectorAll('.code-tab-panel');
        
        tabs.forEach(tab => tab.classList.remove('active'));
        panels.forEach(panel => panel.classList.remove('active'));
        
        event.target.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    }
    
    function copyCode(button, elementId) {
        const codeElement = document.getElementById(elementId);
        let textToCopy = codeElement.textContent || codeElement.innerText;
        textToCopy = textToCopy.replace(/^\s+|\s+$/g, '');
        
        navigator.clipboard.writeText(textToCopy).then(function() {
            const originalHTML = button.innerHTML;
            button.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Copied!';
            
            setTimeout(function() {
                button.innerHTML = originalHTML;
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            alert('Failed to copy code. Please try again.');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const preElements = document.querySelectorAll('.code-block-content pre');
        preElements.forEach(pre => {
            pre.classList.add('hljs');
        });
    });
</script>

@endsection