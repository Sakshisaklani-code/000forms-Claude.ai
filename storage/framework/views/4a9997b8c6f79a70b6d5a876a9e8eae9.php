

<?php $__env->startSection('title', 'Application Forms - 000form Library'); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/library.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/category.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Category Content -->
<section class="category-features" style="padding-top: 2rem;">
    <div class="container">
        
        <!-- Category Header -->
        <div class="category-header">
            <div class="category-info">
                <h2>All Application Forms</h2>
                <p>Choose templates, copy HTML code instantly</p>
            </div>
        </div>
        
        <!-- Templates Grid - 2 columns -->
        <div class="application-forms-grid">
            
            <!-- 1. Tenant Application Form -->
            <div class="card application-form-card">
                <div class="form-preview-header">
                    <h3 class="form-preview-title">Tenant Application Form</h3>
                    <p class="form-preview-description">Interested in renting one of our properties. Please fill the form with the needed information.</p>
                </div>
                
                <div class="form-preview-content">
                    <h4 class="form-section-heading">Tenancy details</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Property address</label>
                        <div class="form-input-placeholder">Street Address</div>
                        <div class="form-input-placeholder">Street Address Line 2</div>
                        
                        <div class="form-row">
                            <div class="form-input-placeholder">City</div>
                            <div class="form-input-placeholder">Region</div>
                            <div class="form-input-placeholder">Postal / Zip Code</div>
                            <div class="form-input-placeholder">Country</div>
                        </div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Commencement of tenancy</label>
                        <div class="form-input-placeholder">MM/DD/YYYY</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Applicant details</label>
                        <div class="form-input-placeholder">Full Name</div>
                        <div class="form-input-placeholder">Email Address</div>
                        <div class="form-input-placeholder">Phone Number</div>
                        <div class="form-input-placeholder">Current Address</div>
                    </div>
                    
                    <div class="form-submit-btn">Submit Application</div>
                </div>
                
                <div class="form-preview-footer">
                    <span class="form-badge">HTML</span>
                    <span class="form-fields-count">12 fields</span>
                    <a href="<?php echo e(route('Home.library.TenantApplicationForm')); ?>" class="get-code-btn">Get code →</a>
                </div>
            </div>
            
            <!-- 2. Job Application Form -->
            <div class="card application-form-card">
                <div class="form-preview-header">
                    <h3 class="form-preview-title">Job Application Form</h3>
                    <p class="form-preview-description">Apply for an open position at our company. Please fill in all required information.</p>
                </div>
                
                <div class="form-preview-content">
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Full Name:</label>
                        <div class="form-input-placeholder-light">Enter your name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Email:</label>
                        <div class="form-input-placeholder-light">Enter your email</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Position:</label>
                        <div class="form-select-placeholder">Select a position</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Availability:</label>
                        <div class="form-checkbox-group">
                            <div class="form-checkbox-item">
                                <span class="form-checkbox-box">□</span>
                                <span class="form-checkbox-label">Full-Time</span>
                            </div>
                            <div class="form-checkbox-item">
                                <span class="form-checkbox-box">□</span>
                                <span class="form-checkbox-label">Part-Time</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Why do you want this job?</label>
                        <div class="form-textarea-placeholder">Write your motivation</div>
                    </div>
                    
                    <div class="form-submit-btn">Submit Application</div>
                </div>
                
                <div class="form-preview-footer">
                    <span class="form-badge">HTML</span>
                    <span class="form-fields-count">6 fields</span>
                    <a href="<?php echo e(route('Home.library.JobApplicationForm')); ?>" class="get-code-btn">Get code →</a>
                </div>
            </div>
            
            <!-- 3. Rental Application Form -->
            <div class="card application-form-card">
                <div class="form-preview-header">
                    <h3 class="form-preview-title">Rental Application Form</h3>
                    <p class="form-preview-description">Please complete this rental application form to begin the tenant screening process.</p>
                </div>
                
                <div class="form-preview-content">
                    <h4 class="form-section-heading">Personal details</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Full Name</label>
                        <div class="form-input-placeholder">Enter your full name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Date of Birth</label>
                        <div class="form-input-placeholder">MM/DD/YYYY</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Phone Number</label>
                        <div class="form-input-placeholder">Enter your phone number</div>
                    </div>
                    
                    <h4 class="form-section-heading">Current address</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Street Address</label>
                        <div class="form-input-placeholder">Street Address</div>
                        <div class="form-input-placeholder">Apt/Suite (optional)</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label">City</label>
                            <div class="form-input-placeholder">City</div>
                        </div>
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label">State</label>
                            <div class="form-input-placeholder">State</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label">ZIP Code</label>
                            <div class="form-input-placeholder">ZIP Code</div>
                        </div>
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label">Country</label>
                            <div class="form-input-placeholder">USA</div>
                        </div>
                    </div>
                    
                    <h4 class="form-section-heading">Employment</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Current Employer</label>
                        <div class="form-input-placeholder">Employer name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Monthly Income</label>
                        <div class="form-input-placeholder">$</div>
                    </div>
                    
                    <div class="form-submit-btn">Submit Application</div>
                </div>
                
                <div class="form-preview-footer">
                    <span class="form-badge">HTML</span>
                    <span class="form-fields-count">14 fields</span>
                    <a href="<?php echo e(route('Home.library.RentalApplicationForm')); ?>" class="get-code-btn">Get code →</a>
                </div>
            </div>
            
            <!-- 4. Vendor Application Form -->
            <div class="card application-form-card">
                <div class="form-preview-header">
                    <h3 class="form-preview-title">Vendor Application Form</h3>
                    <p class="form-preview-description">Register your business as a vendor or supplier for our company.</p>
                </div>
                
                <div class="form-preview-content">
                    <h4 class="form-section-heading">Company information</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Company Name:</label>
                        <div class="form-input-placeholder-light">Enter your company name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Business Type:</label>
                        <div class="form-select-placeholder">Select business type</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Tax ID / EIN:</label>
                        <div class="form-input-placeholder-light">XX-XXXXXXX</div>
                    </div>
                    
                    <h4 class="form-section-heading">Contact person</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Full Name:</label>
                        <div class="form-input-placeholder-light">Enter contact name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Email:</label>
                        <div class="form-input-placeholder-light">Enter email address</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Phone:</label>
                        <div class="form-input-placeholder-light">Enter phone number</div>
                    </div>
                    
                    <h4 class="form-section-heading">Business address</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Street Address:</label>
                        <div class="form-input-placeholder-light">Street address</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label-bold">City:</label>
                            <div class="form-input-placeholder-light">City</div>
                        </div>
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label-bold">State:</label>
                            <div class="form-input-placeholder-light">State</div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label-bold">ZIP Code:</label>
                            <div class="form-input-placeholder-light">ZIP Code</div>
                        </div>
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label-bold">Country:</label>
                            <div class="form-input-placeholder-light">USA</div>
                        </div>
                    </div>
                    
                    <div class="form-submit-btn">Submit Vendor Application</div>
                </div>
                
                <div class="form-preview-footer">
                    <span class="form-badge">HTML</span>
                    <span class="form-fields-count">11 fields</span>
                    <a href="<?php echo e(route('Home.library.VendorApplicationForm')); ?>" class="get-code-btn">Get code →</a>
                </div>
            </div>
            
            <!-- 5. Scholarship Application Form -->
            <div class="card application-form-card">
                <div class="form-preview-header">
                    <h3 class="form-preview-title">Scholarship Application Form</h3>
                    <p class="form-preview-description">Apply for educational scholarships and financial aid opportunities.</p>
                </div>
                
                <div class="form-preview-content">
                    <h4 class="form-section-heading">Student information</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Full Name</label>
                        <div class="form-input-placeholder">Enter your full name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Date of Birth</label>
                        <div class="form-input-placeholder">MM/DD/YYYY</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Email Address</label>
                        <div class="form-input-placeholder">Enter your email</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Phone Number</label>
                        <div class="form-input-placeholder">Enter your phone number</div>
                    </div>
                    
                    <h4 class="form-section-heading">Academic information</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">School/University</label>
                        <div class="form-input-placeholder">Name of institution</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label">Graduation Year</label>
                            <div class="form-input-placeholder">YYYY</div>
                        </div>
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label">GPA</label>
                            <div class="form-input-placeholder">0.0 - 4.0</div>
                        </div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Major/Field of Study</label>
                        <div class="form-input-placeholder">Your major</div>
                    </div>
                    
                    <h4 class="form-section-heading">Scholarship details</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Scholarship Name</label>
                        <div class="form-input-placeholder">Name of scholarship</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Amount Requested</label>
                        <div class="form-input-placeholder">$</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label">Personal Statement</label>
                        <div class="form-textarea-placeholder">Write your personal statement here...</div>
                    </div>
                    
                    <div class="form-submit-btn">Submit Scholarship Application</div>
                </div>
                
                <div class="form-preview-footer">
                    <span class="form-badge">HTML</span>
                    <span class="form-fields-count">13 fields</span>
                    <a href="<?php echo e(route('Home.library.ScholarshipApplicationForm')); ?>" class="get-code-btn">Get code →</a>
                </div>
            </div>
            
            <!-- 6. Internship Application Form -->
            <div class="card application-form-card">
                <div class="form-preview-header">
                    <h3 class="form-preview-title">Internship Application Form</h3>
                    <p class="form-preview-description">Apply for internship positions at our company.</p>
                </div>
                
                <div class="form-preview-content">
                    <h4 class="form-section-heading">Personal information</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Full Name:</label>
                        <div class="form-input-placeholder-light">Enter your full name</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Email:</label>
                        <div class="form-input-placeholder-light">Enter your email</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Phone:</label>
                        <div class="form-input-placeholder-light">Enter your phone number</div>
                    </div>
                    
                    <h4 class="form-section-heading">Education</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">University:</label>
                        <div class="form-input-placeholder-light">Name of university</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label-bold">Major:</label>
                            <div class="form-input-placeholder-light">Your major</div>
                        </div>
                        <div class="form-field-group" style="flex: 1;">
                            <label class="form-visual-label-bold">Graduation:</label>
                            <div class="form-input-placeholder-light">MM/YYYY</div>
                        </div>
                    </div>
                    
                    <h4 class="form-section-heading">Internship details</h4>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Position:</label>
                        <div class="form-select-placeholder">Select a position</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Availability:</label>
                        <div class="form-checkbox-group">
                            <div class="form-checkbox-item">
                                <span class="form-checkbox-box">□</span>
                                <span class="form-checkbox-label">Full-Time</span>
                            </div>
                            <div class="form-checkbox-item">
                                <span class="form-checkbox-box">□</span>
                                <span class="form-checkbox-label">Part-Time</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Start Date:</label>
                        <div class="form-input-placeholder-light">MM/DD/YYYY</div>
                    </div>
                    
                    <div class="form-field-group">
                        <label class="form-visual-label-bold">Why are you interested in this internship?</label>
                        <div class="form-textarea-placeholder">Write your motivation</div>
                    </div>
                    
                    <div class="form-submit-btn">Submit Internship Application</div>
                </div>
                
                <div class="form-preview-footer">
                    <span class="form-badge">HTML</span>
                    <span class="form-fields-count">12 fields</span>
                    <a href="<?php echo e(route('Home.library.InternshipApplicationForm')); ?>" class="get-code-btn">Get code →</a>
                </div>
            </div>
            
        </div>
        
    </div>
</section>

<!-- CTA Section -->
<section class="features" style="background: var(--bg-secondary);">
    <div class="container">
        <div class="card" style="text-align: center; padding: 3rem 2rem;">
            <h2 style="margin-bottom: 0.75rem; font-size: 1.75rem;">Need a different application form?</h2>
            <p style="max-width: 500px; margin: 0 auto 1.5rem; color: var(--text-secondary);">
                Create your own form endpoint in seconds and customize any template.
            </p>
            <a href="#" class="btn btn-primary">
                Create Your Form →
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\Library\ApplicationFormTemplates.blade.php ENDPATH**/ ?>