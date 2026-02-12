<?php
// app/Helpers/FormEmbedHelper.php

namespace App\Helpers;

use App\Models\Form;

class FormEmbedHelper
{
    /**
     * Generate both HTML and AJAX embed codes for the form.
     */
    public static function generateEmbedCodes(Form $form): array
    {
        $formUrl = route('forms.submit', $form->id);
        $successMessage = $form->success_message ?? 'Thank you for your submission!';
        
        return [
            'html' => self::generateHtmlCode($formUrl),
            'ajax' => self::generateAjaxCode($formUrl, $successMessage),
            'ajax_minified' => self::generateMinifiedAjaxCode($formUrl, $successMessage),
            'success_message' => $successMessage,
            'form_url' => $formUrl,
            'form_id' => $form->id
        ];
    }

    /**
     * Generate normal HTML form code.
     */
    public static function generateHtmlCode(string $formUrl): string
    {
        return <<<HTML
<!-- Normal HTML Form -->
<form action="{$formUrl}" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token}}">
    
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="4" required></textarea>
    </div>
    
    <button type="submit">Submit</button>
</form>
HTML;
    }

    /**
     * Generate AJAX form code with response message.
     */
    public static function generateAjaxCode(string $formUrl, string $successMessage): string
    {
        $formId = 'ajax_form_' . uniqid();
        $responseId = 'response_' . uniqid();
        
        return <<<AJAX
<!-- AJAX Form with Response Message -->
<form id="{$formId}" class="ajax-form" action="{$formUrl}" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token}}">
    
    <div class="form-group">
        <label for="name_{$formId}">Name</label>
        <input type="text" id="name_{$formId}" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="email_{$formId}">Email</label>
        <input type="email" id="email_{$formId}" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="message_{$formId}">Message</label>
        <textarea id="message_{$formId}" name="message" rows="4" required></textarea>
    </div>
    
    <button type="submit">Submit</button>
    
    <!-- Response message appears here -->
    <div id="{$responseId}" class="form-response" style="margin-top: 20px; display: none;"></div>
</form>

<script>
(function() {
    const form = document.getElementById('{$formId}');
    const responseDiv = document.getElementById('{$responseId}');
    const successMsg = "{$successMessage}";
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        // Show loading
        responseDiv.style.display = 'block';
        responseDiv.innerHTML = '<div class="alert alert-info">Sending...</div>';
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                responseDiv.innerHTML = '<div class="alert alert-success">' + 
                                        (data.message || successMsg) + 
                                        '</div>';
                form.reset();
            } else {
                responseDiv.innerHTML = '<div class="alert alert-danger">' + 
                                        (data.message || 'An error occurred. Please try again.') + 
                                        '</div>';
            }
        } catch (error) {
            responseDiv.innerHTML = '<div class="alert alert-danger">' + 
                                    'Connection error. Please check your internet and try again.' + 
                                    '</div>';
        }
    });
})();
</script>

<style>
#{$formId} .form-group {
    margin-bottom: 15px;
}
#{$formId} label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}
#{$formId} input[type="text"],
#{$formId} input[type="email"],
#{$formId} textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box;
}
#{$formId} button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#{$formId} button:hover {
    background-color: #0056b3;
}
#{$formId} .alert {
    padding: 15px;
    border-radius: 4px;
    margin: 10px 0;
}
#{$formId} .alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}
#{$formId} .alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}
#{$formId} .alert-info {
    background-color: #e9ecef;
    color: #495057;
}
</style>
AJAX;
    }

    /**
     * Generate minified AJAX code.
     */
    public static function generateMinifiedAjaxCode(string $formUrl, string $successMessage): string
    {
        $formId = 'af_' . md5($formUrl);
        $responseId = 'r_' . md5($formUrl);
        
        return <<<MINIFIED
<form id="{$formId}" action="{$formUrl}" method="POST">
<input type="hidden" name="_token" value="{{csrf_token}}">
<div><label>Name</label><input type="text" name="name" required></div>
<div><label>Email</label><input type="email" name="email" required></div>
<div><label>Message</label><textarea name="message" required></textarea></div>
<button type="submit">Submit</button>
<div id="{$responseId}" style="margin-top:15px;display:none"></div>
</form>
<script>
!function(){const f=document.getElementById('{$formId}'),r=document.getElementById('{$responseId}'),s="{$successMessage}";
f.addEventListener('submit',async function(e){e.preventDefault();
const d=new FormData(f);r.style.display='block';
r.innerHTML='<div style="padding:12px;background:#e9ecef">Sending...</div>';
try{const p=await fetch(f.action,{method:'POST',body:d,headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}});
const j=await p.json();p.ok?
(r.innerHTML='<div style="padding:12px;background:#d4edda;border:1px solid #c3e6cb;color:#155724;border-radius:4px">'+(j.message||s)+'</div>',f.reset()):
(r.innerHTML='<div style="padding:12px;background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;border-radius:4px">'+(j.message||'Error')+'</div>');}
catch(e){r.innerHTML='<div style="padding:12px;background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;border-radius:4px">Connection error</div>';}})}();
</script>
MINIFIED;
    }

    /**
     * Generate custom form with user-defined fields.
     */
    public static function generateCustomForm(Form $form, array $fields = []): array
    {
        $formUrl = route('forms.submit', $form->id);
        $successMessage = $form->success_message ?? 'Thank you for your submission!';
        
        $htmlFields = '';
        $ajaxFields = '';
        
        foreach ($fields as $field) {
            $fieldName = $field['name'] ?? 'field';
            $fieldLabel = $field['label'] ?? ucfirst($fieldName);
            $fieldType = $field['type'] ?? 'text';
            $required = isset($field['required']) && $field['required'] ? 'required' : '';
            
            $fieldHtml = self::generateFieldHtml($fieldName, $fieldLabel, $fieldType, $required);
            $htmlFields .= $fieldHtml;
            $ajaxFields .= $fieldHtml;
        }
        
        return [
            'html' => self::wrapHtmlForm($formUrl, $htmlFields),
            'ajax' => self::wrapAjaxForm($formUrl, $successMessage, $ajaxFields),
        ];
    }

    /**
     * Generate single field HTML.
     */
    private static function generateFieldHtml(string $name, string $label, string $type, string $required): string
    {
        $id = 'field_' . $name . '_' . uniqid();
        
        if ($type === 'textarea') {
            return <<<FIELD
    <div class="form-group">
        <label for="{$id}">{$label}</label>
        <textarea id="{$id}" name="{$name}" rows="4" {$required}></textarea>
    </div>
FIELD;
        }
        
        if ($type === 'select') {
            return <<<FIELD
    <div class="form-group">
        <label for="{$id}">{$label}</label>
        <select id="{$id}" name="{$name}" {$required}>
            <option value="">Select...</option>
        </select>
    </div>
FIELD;
        }
        
        return <<<FIELD
    <div class="form-group">
        <label for="{$id}">{$label}</label>
        <input type="{$type}" id="{$id}" name="{$name}" {$required}>
    </div>
FIELD;
    }

    /**
     * Wrap fields in HTML form.
     */
    private static function wrapHtmlForm(string $formUrl, string $fields): string
    {
        return <<<HTML
<form action="{$formUrl}" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token}}">
    {$fields}
    <button type="submit">Submit</button>
</form>
HTML;
    }

    /**
     * Wrap fields in AJAX form.
     */
    private static function wrapAjaxForm(string $formUrl, string $successMessage, string $fields): string
    {
        $formId = 'ajax_form_' . uniqid();
        $responseId = 'response_' . uniqid();
        
        return <<<AJAX
<form id="{$formId}" class="ajax-form" action="{$formUrl}" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token}}">
    {$fields}
    <button type="submit">Submit</button>
    <div id="{$responseId}" class="form-response" style="margin-top: 20px; display: none;"></div>
</form>

<script>
(function() {
    const form = document.getElementById('{$formId}');
    const responseDiv = document.getElementById('{$responseId}');
    const successMsg = "{$successMessage}";
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        responseDiv.style.display = 'block';
        responseDiv.innerHTML = '<div class="alert alert-info">Sending...</div>';
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                responseDiv.innerHTML = '<div class="alert alert-success">' + 
                                        (data.message || successMsg) + 
                                        '</div>';
                form.reset();
            } else {
                responseDiv.innerHTML = '<div class="alert alert-danger">' + 
                                        (data.message || 'An error occurred.') + 
                                        '</div>';
            }
        } catch (error) {
            responseDiv.innerHTML = '<div class="alert alert-danger">Connection error</div>';
        }
    });
})();
</script>

<style>
#{$formId} .form-group { margin-bottom: 15px; }
#{$formId} label { display: block; margin-bottom: 5px; font-weight: 600; }
#{$formId} input[type="text"],
#{$formId} input[type="email"],
#{$formId} input[type="tel"],
#{$formId} input[type="number"],
#{$formId} select,
#{$formId} textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    box-sizing: border-box;
}
#{$formId} button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#{$formId} button:hover { background-color: #0056b3; }
#{$formId} .alert {
    padding: 15px;
    border-radius: 4px;
    margin: 10px 0;
}
#{$formId} .alert-success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
#{$formId} .alert-danger { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
#{$formId} .alert-info { background-color: #e9ecef; color: #495057; }
</style>
AJAX;
    }
}