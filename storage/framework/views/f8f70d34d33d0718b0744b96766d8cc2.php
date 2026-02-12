

<?php $__env->startSection('title', 'Test Forms - 000form'); ?>

<?php $__env->startSection('content'); ?>

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
  <!-- <input type="hidden" name="_next" value="http://127.0.0.1:8000/thank-you"> -->
  <input type="hidden" name="_subject" value="New submission from 000forms First Form while testing _subject field">
  <button type="submit">Send Message</button>
</form>

<script>
fetch('http://127.0.0.1:8000/f/f_qychdxq8', {
  method: 'POST',
  body: new FormData(form),
  headers: { 'Accept': 'application/json' }
})
.then(res => res.json())
.then(data => console.log(data));
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/test.blade.php ENDPATH**/ ?>