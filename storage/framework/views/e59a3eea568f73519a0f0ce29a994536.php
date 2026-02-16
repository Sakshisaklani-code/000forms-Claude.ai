<!-- HTML Form with File Upload Support -->
<form action="http://127.0.0.1:8000/f/f_l63kxxnb" 
      method="POST" 
      enctype="multipart/form-data">
  
  <input type="email" name="email" placeholder="Your email" required>
  <input type="text" name="name" placeholder="Your name" required>
  <input type="hidden" name="_subject" value="Form Created 16 February- New submission!">
  <input type="hidden" name="_template" value="basic"> 
  <textarea name="message" placeholder="Your message"></textarea>
  
  <input type="file" 
         name="upload" 
         
         placeholder="Choose file to upload">
  
    <!-- Honeypot (spam protection) -->
  <input type="text" name="honeypot_FZvnAP9m" style="display:none">
  
  <button type="submit">Send Message with File</button>
</form>

            <?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\Test-forms\test.blade.php ENDPATH**/ ?>