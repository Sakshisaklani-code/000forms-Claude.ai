<!-- Add Tailwind CSS CDN to your <head> -->
<script src="https://cdn.tailwindcss.com"></script>



<!-- HTML with Tailwind Classes -->
<form action="https://000form.com/f/your-endpoint" 
      method="POST"
      class="rental-form-container max-w-2xl mx-auto p-8 bg-[#0d0d0d] border border-[#1a1a1a] rounded-xl">
  
  <h3 class="text-2xl font-semibold text-[#fafafa] mb-2 tracking-tight">
    Rental Application Form
  </h3>
  
  <p class="text-sm text-[#888888] mb-6 leading-relaxed">
    Please complete this rental application form to begin the tenant screening process.
  </p>

  <h4 class="text-lg font-semibold text-[#00ff88] mb-4 pb-2 border-b border-dashed border-[#2a2a2a]">
    Personal details
  </h4>

  <div class="mb-5">
    <label class="block text-sm font-medium text-[#e6edf3] mb-1">Full Name</label>
    <input type="text" name="full_name"
           placeholder="Enter your full name"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-medium text-[#e6edf3] mb-1">Date of Birth</label>
    <input type="text" name="dob"
           placeholder="MM/DD/YYYY"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-medium text-[#e6edf3] mb-1">Phone Number</label>
    <input type="tel" name="phone"
           placeholder="Enter your phone number"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2"
           required>
  </div>

  <h4 class="text-lg font-semibold text-[#00ff88] mt-6 mb-4 pb-2 border-b border-dashed border-[#2a2a2a]">
    Current address
  </h4>

  <div class="mb-5">
    <label class="block text-sm font-medium text-[#e6edf3] mb-1">Street Address</label>
    <input type="text" name="street_address"
           placeholder="Street Address"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2 mb-2"
           required>
    <input type="text" name="apt_suite"
           placeholder="Apt/Suite (optional)"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2">
  </div>

  <div class="flex flex-col sm:flex-row gap-4 mb-5 mt-2">
    <div class="flex-1">
      <label class="block text-sm font-medium text-[#e6edf3] mb-1">City</label>
      <input type="text" name="city" placeholder="City"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
             required>
    </div>
    <div class="flex-1">
      <label class="block text-sm font-medium text-[#e6edf3] mb-1">State</label>
      <input type="text" name="state" placeholder="State"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
             required>
    </div>
  </div>

  <div class="flex flex-col sm:flex-row gap-4 mb-5">
    <div class="flex-1">
      <label class="block text-sm font-medium text-[#e6edf3] mb-1">ZIP Code</label>
      <input type="text" name="zip" placeholder="ZIP Code"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
             required>
    </div>
    <div class="flex-1">
      <label class="block text-sm font-medium text-[#e6edf3] mb-1">Country</label>
      <input type="text" name="country" value="USA"
             class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all">
    </div>
  </div>

  <h4 class="text-lg font-semibold text-[#00ff88] mt-6 mb-4 pb-2 border-b border-dashed border-[#2a2a2a]">
    Employment
  </h4>

  <div class="mb-5">
    <label class="block text-sm font-medium text-[#e6edf3] mb-1">Current Employer</label>
    <input type="text" name="employer"
           placeholder="Employer name"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2"
           required>
  </div>

  <div class="mb-6">
    <label class="block text-sm font-medium text-[#e6edf3] mb-1">Monthly Income</label>
    <input type="text" name="income"
           placeholder="$"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all mt-2"
           required>
  </div>

  <button type="submit"
          class="w-full py-3 px-6 bg-[#00ff88] text-[#050505] font-semibold rounded-lg hover:bg-white transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#00ff88]/20">
    Submit Application
  </button>
</form><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views/Test-forms/test.blade.php ENDPATH**/ ?>