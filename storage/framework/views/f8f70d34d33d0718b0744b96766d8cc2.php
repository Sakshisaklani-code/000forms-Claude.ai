<!-- Add Tailwind CSS CDN to your <head> -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- HTML with Tailwind Classes -->
<form action="https://000form.com/f/your-endpoint" 
      method="POST"
      class="vendor-form-container max-w-2xl mx-auto p-8 bg-[#0d0d0d] border border-[#1a1a1a] rounded-xl">
  
  <h3 class="text-2xl font-semibold text-[#fafafa] mb-2 tracking-tight">
    Vendor Application Form
  </h3>
  
  <p class="text-sm text-[#888888] mb-6 leading-relaxed">
    Register your business as a vendor or supplier for our company.
  </p>

  <h4 class="text-lg font-semibold text-[#00ff88] mb-4 pb-2 border-b border-dashed border-[#2a2a2a]">
    Company information
  </h4>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Company Name:</label>
    <input type="text" name="company_name"
           placeholder="Enter your company name"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Business Type:</label>
    <select name="business_type"
            class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] focus:border-[#00ff88] transition-all cursor-pointer"
            required>
      <option value="">Select business type</option>
      <option value="sole-proprietorship">Sole Proprietorship</option>
      <option value="partnership">Partnership</option>
      <option value="llc">LLC</option>
      <option value="corporation">Corporation</option>
      <option value="non-profit">Non-Profit</option>
    </select>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Tax ID / EIN:</label>
    <input type="text" name="tax_id"
           placeholder="XX-XXXXXXX"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <h4 class="text-lg font-semibold text-[#00ff88] mt-6 mb-4 pb-2 border-b border-dashed border-[#2a2a2a]">
    Contact person
  </h4>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Full Name:</label>
    <input type="text" name="contact_name"
           placeholder="Enter contact name"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Email:</label>
    <input type="email" name="contact_email"
           placeholder="Enter email address"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Phone:</label>
    <input type="tel" name="contact_phone"
           placeholder="Enter phone number"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <h4 class="text-lg font-semibold text-[#00ff88] mt-6 mb-4 pb-2 border-b border-dashed border-[#2a2a2a]">
    Business address
  </h4>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Street Address:</label>
    <input type="text" name="street_address"
           placeholder="Street address"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <div class="flex flex-col sm:flex-row gap-4 mb-5 mt-2">
    <div class="flex-1">
      <label class="block text-sm font-semibold text-[#e6edf3] mb-2">City:</label>
      <input type="text" name="city" placeholder="City"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
             required>
    </div>
    <div class="flex-1">
      <label class="block text-sm font-semibold text-[#e6edf3] mb-2">State:</label>
      <input type="text" name="state" placeholder="State"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
             required>
    </div>
  </div>

  <div class="flex flex-col sm:flex-row gap-4 mb-6 mt-2">
    <div class="flex-1">
      <label class="block text-sm font-semibold text-[#e6edf3] mb-2">ZIP Code:</label>
      <input type="text" name="zip" placeholder="ZIP Code"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
             required>
    </div>
    <div class="flex-1">
      <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Country:</label>
      <input type="text" name="country" value="USA"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all">
    </div>
  </div>

  <button type="submit"
          class="w-full py-3 px-6 bg-[#00ff88] text-[#050505] font-semibold rounded-lg hover:bg-white transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#00ff88]/20">
    Submit Vendor Application
  </button>
</form><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/test.blade.php ENDPATH**/ ?>