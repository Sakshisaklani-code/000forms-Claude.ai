

<?php $__env->startSection('title', 'Test Forms - 000form'); ?>

<?php $__env->startSection('content'); ?>

<!-- HTML Form -->
<form action="https://formsubmit.co/tsaklani2drish@gmail.com" method="POST">
     <input type="text" name="name" required>
     <input type="email" name="email" required>
     <input type="hidden" name="_next" value="http://127.0.0.1:8000/thank-you">
     <textarea name="message" placeholder="Your message"></textarea>
     <input type="hidden" name="_subject" value="New submission from Formsubmit!">
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
     <button type="submit">Send</button>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/formsubmit.blade.php ENDPATH**/ ?>