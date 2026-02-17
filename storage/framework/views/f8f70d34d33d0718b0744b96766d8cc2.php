<!-- HTML Form with File Upload Support -->
<form action="http://127.0.0.1:8000/f/f_l63kxxnb" 
      method="POST" 
      enctype="multipart/form-data">
  
  <input type="email" name="email" placeholder="Your email" required>
  
  <textarea name="message" placeholder="Your message"></textarea>
  
  <input type="file" 
         name="uploads[]" 
         multiple
         placeholder="Choose file to upload">

  <input type="hidden" name="_cc" value="tsaklani2drish@gmail.com,tsaklani2@gmail.com">
  
    <!-- Honeypot (spam protection) -->
  <input type="text" name="honeypot_FZvnAP9m" style="display:none">
  
  <button type="submit">Send Message with File</button>
</form>

            <?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/test.blade.php ENDPATH**/ ?>