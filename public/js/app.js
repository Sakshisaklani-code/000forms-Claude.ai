/**
 * 000form.com - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    initNavigation();
    initCodeCopy();
    initMobileMenu();
    initAlerts();
});

/**
 * Navigation scroll effect
 */
function initNavigation() {
    const nav = document.querySelector('.nav');
    if (!nav) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
}

/**
 * Code copy functionality
 */
function initCodeCopy() {
    document.querySelectorAll('.code-copy').forEach(button => {
        button.addEventListener('click', async () => {
            const codeBlock = button.closest('.code-block');
            const code = codeBlock.querySelector('pre').textContent;
            
            try {
                await navigator.clipboard.writeText(code);
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.style.color = 'var(--accent)';
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.color = '';
                }, 2000);
            } catch (err) {
                console.error('Failed to copy:', err);
            }
        });
    });
}

/**
 * Mobile menu toggle
 */
function initMobileMenu() {
    const toggle = document.querySelector('.nav-toggle');
    const links = document.querySelector('.nav-links');
    const actions = document.querySelector('.nav-actions');
    
    if (!toggle) return;

    toggle.addEventListener('click', () => {
        links?.classList.toggle('open');
        actions?.classList.toggle('open');
    });
}

/**
 * Auto-dismiss alerts
 */
function initAlerts() {
    document.querySelectorAll('.alert[data-dismiss]').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

/**
 * Copy to clipboard helper
 */
function copyToClipboard(text) {
    return navigator.clipboard.writeText(text).then(() => {
        showToast('Copied to clipboard!');
    }).catch(err => {
        console.error('Copy failed:', err);
    });
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type}`;
    toast.style.cssText = `
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    `;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Form validation helper
 */
function validateForm(form) {
    let isValid = true;
    
    form.querySelectorAll('[required]').forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('error');
        } else {
            input.classList.remove('error');
        }
    });
    
    return isValid;
}

/**
 * Endpoint URL copy
 */
function copyEndpoint(slug) {
    const url = `${window.location.origin}/f/${slug}`;
    copyToClipboard(url);
}

/**
 * Confirm action helper
 */
function confirmAction(message) {
    return new Promise((resolve) => {
        if (confirm(message)) {
            resolve(true);
        } else {
            resolve(false);
        }
    });
}

/**
 * Delete form confirmation
 */
async function deleteForm(formId, formName) {
    const confirmed = await confirmAction(`Are you sure you want to delete "${formName}"? This will also delete all submissions and cannot be undone.`);
    
    if (confirmed) {
        document.getElementById(`delete-form-${formId}`).submit();
    }
}

/**
 * Delete submission confirmation
 */
async function deleteSubmission(formId, submissionId) {
    const confirmed = await confirmAction('Are you sure you want to delete this submission?');
    
    if (confirmed) {
        document.getElementById(`delete-submission-${submissionId}`).submit();
    }
}

/**
 * Toggle form status
 */
function toggleFormStatus(formId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'paused' : 'active';
    document.getElementById(`form-status-${formId}`).value = newStatus;
    document.getElementById(`form-settings-${formId}`).submit();
}

/**
 * Sidebar toggle for mobile
 */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar?.classList.toggle('open');
}

// Export functions for use in templates
window.copyEndpoint = copyEndpoint;
window.deleteForm = deleteForm;
window.deleteSubmission = deleteSubmission;
window.toggleFormStatus = toggleFormStatus;
window.toggleSidebar = toggleSidebar;
window.showToast = showToast;
