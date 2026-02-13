<!-- Add Tailwind CSS CDN to your <head> -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- HTML with Tailwind Classes -->
<form action="https://000form.com/f/your-endpoint" 
      method="POST"
      class="job-form-container max-w-2xl mx-auto p-8 bg-[#0d0d0d] border border-[#1a1a1a] rounded-xl">
  
  <h3 class="text-2xl font-semibold text-[#fafafa] mb-2 tracking-tight">
    Job Application Form
  </h3>
  
  <p class="text-sm text-[#888888] mb-6 leading-relaxed">
    Apply for an open position at our company. Please fill in all required information.
  </p>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Full Name:</label>
    <input type="text" name="full_name"
           placeholder="Enter your name"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Email:</label>
    <input type="email" name="email"
           placeholder="Enter your email"
           class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all"
           required>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Position:</label>
    <select name="position"
            class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] focus:border-[#00ff88] transition-all cursor-pointer"
            required>
      <option value="">Select a position</option>
      <option value="software-engineer">Software Engineer</option>
      <option value="product-manager">Product Manager</option>
      <option value="designer">Designer</option>
    </select>
  </div>

  <div class="mb-5">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Availability:</label>
    <div class="flex flex-col sm:flex-row gap-6 mt-2">
      <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="availability[]" value="full-time"
               class="w-[18px] h-[18px] cursor-pointer">
        <span class="text-sm text-[#888888]">Full-Time</span>
      </label>
      <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="availability[]" value="part-time"
               class="w-[18px] h-[18px] cursor-pointer">
        <span class="text-sm text-[#888888]">Part-Time</span>
      </label>
    </div>
  </div>

  <div class="mb-6">
    <label class="block text-sm font-semibold text-[#e6edf3] mb-2">Why do you want this job?</label>
    <textarea name="motivation" rows="4"
              placeholder="Write your motivation"
              class="w-full px-4 py-3 bg-[#111111] border border-[#1a1a1a] rounded-lg text-[#fafafa] placeholder-[#555555] focus:border-[#00ff88] transition-all resize-y min-h-[100px]"
              required></textarea>
  </div>

  <button type="submit"
          class="w-full py-3 px-6 bg-[#00ff88] text-[#050505] font-semibold rounded-lg hover:bg-white transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#00ff88]/20">
    Submit Application
  </button>
</form>