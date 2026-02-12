

<?php $__env->startSection('title', 'Test Forms - 000form'); ?>

<?php $__env->startSection('content'); ?>

<!-- HTML Form -->
<form  action="http://127.0.0.1:8000/f/f_qychdxq8" method="POST">
  <input type="email" name="email" placeholder="Your email" required>

  <textarea name="message" placeholder="Your message"></textarea>
  
    <!-- Honeypot (spam protection) -->
  <input type="text" name="_gotcha" style="display:none">
  <input type="hidden" name="_next" value="http://127.0.0.1:8000/thank-you">
  <input type="hidden" name="_subject" value="New submission from 000forms First Form while testing _subject field">
  <button type="submit">Send Message</button>
</form>

<!-- <script>
document.getElementById('form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const responseBox = document.getElementById('form');
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Disable button and show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Sending...';
    responseBox.innerHTML = '<span style="color: #64748b;"> Sending your message...</span>';
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            responseBox.innerHTML = '<span style="color: #22c55e;"> Thank you for your submission!</span>';
            form.reset();
        } else {
            throw new Error(data.error || 'Something went wrong');
        }
    } catch (error) {
        responseBox.innerHTML = '<span style="color: #ef4444;"> ' + error.message + '. Please try again.</span>';
    } finally {
        // Re-enable button
        submitButton.disabled = false;
        submitButton.textContent = 'Send Message';
    }
});
</script> -->

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/test.blade.php ENDPATH**/ ?>