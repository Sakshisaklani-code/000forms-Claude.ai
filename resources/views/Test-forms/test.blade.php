<style>
  .tenant-form {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;
  background: #0d0d0d;
  border: 1px solid #1a1a1a;
  border-radius: 12px;
  font-family: 'Outfit', sans-serif;
}

.tenant-form h3 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #fafafa;
  margin-bottom: 0.5rem;
  letter-spacing: -0.02em;
}

.tenant-form .form-description {
  font-size: 0.9rem;
  color: #888888;
  margin-bottom: 1.5rem;
  line-height: 1.6;
}

.tenant-form h4 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #00ff88;
  margin: 1.5rem 0 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px dashed #2a2a2a;
}

.tenant-form h4:first-of-type {
  margin-top: 0;
}

.tenant-form .form-group {
  margin-bottom: 1.25rem;
}

.tenant-form label {
  display: block;
  font-size: 0.85rem;
  font-weight: 500;
  color: #e6edf3;
  margin-bottom: 0.35rem;
}

.tenant-form input[type="text"],
.tenant-form input[type="email"],
.tenant-form input[type="tel"],
.tenant-form select,
.tenant-form textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  background: #111111;
  border: 1px solid #1a1a1a;
  border-radius: 8px;
  color: #fafafa;
  font-size: 0.95rem;
  transition: all 0.2s ease;
}

.tenant-form input:focus,
.tenant-form select:focus,
.tenant-form textarea:focus {
  outline: none;
  border-color: #00ff88;
  box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.15);
}

.tenant-form input::placeholder,
.tenant-form textarea::placeholder {
  color: #555555;
}

.tenant-form .form-row {
  display: flex;
  gap: 1rem;
  margin-top: 0.5rem;
}

.tenant-form .form-row .form-group {
  flex: 1;
  margin-bottom: 0;
}

.tenant-form .form-options {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 0.25rem;
}

.tenant-form .form-options label {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  font-size: 0.85rem;
  font-weight: normal;
  color: #888888;
  margin-bottom: 0;
  cursor: pointer;
}

.tenant-form .form-options input[type="radio"] {
  width: auto;
  margin-right: 0.25rem;
  accent-color: #00ff88;
}

.tenant-form textarea {
  resize: vertical;
  min-height: 80px;
  font-family: inherit;
}

.tenant-form .submit-btn {
  width: 100%;
  padding: 0.875rem 1.5rem;
  background: #00ff88;
  border: none;
  border-radius: 8px;
  color: #050505;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: 0.5rem;
}

.tenant-form .submit-btn:hover {
  background: #fafafa;
  transform: translateY(-1px);
  box-shadow: 0 4px 20px rgba(0, 255, 136, 0.15);
}

@media (max-width: 768px) {
  .tenant-form {
    padding: 1.5rem;
  }
  
  .tenant-form .form-row {
    flex-direction: column;
    gap: 0.5rem;
  }
  
  .tenant-form .form-options {
    flex-direction: column;
    gap: 0.5rem;
  }
}
</style>
<form action="https://000form.com/f/your-endpoint" method="POST" class="tenant-form">
  <h3>Tenant Application Form</h3>
  <p class="form-description">
    Thank you for taking an interest in renting one of our properties. 
    Please fill in this form with the needed information.
  </p>

  <h4>Tenancy details</h4>
  
  <div class="form-group">
    <label for="property_address">Property address</label>
    <input type="text" id="property_address" name="property_address" 
           placeholder="Street Address" required>
    <input type="text" id="property_address2" name="property_address2" 
           placeholder="Street Address Line 2">
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="city">City</label>
      <input type="text" id="city" name="city" placeholder="City" required>
    </div>
    <div class="form-group">
      <label for="region">Region</label>
      <input type="text" id="region" name="region" placeholder="Region" required>
    </div>
  </div>

  <div class="form-row">
    <div class="form-group">
      <label for="postal_code">Postal / Zip Code</label>
      <input type="text" id="postal_code" name="postal_code" 
             placeholder="Postal / Zip Code" required>
    </div>
    <div class="form-group">
      <label for="country">Country</label>
      <input type="text" id="country" name="country" value="USA" 
             placeholder="Country">
    </div>
  </div>

  <div class="form-group">
    <label for="commencement_date">Commencement of tenancy</label>
    <input type="text" id="commencement_date" name="commencement_date" 
           placeholder="MM/DD/YYYY" required>
  </div>

  <h4>Applicant details</h4>

  <div class="form-group">
    <label for="full_name">Full Name</label>
    <input type="text" id="full_name" name="full_name" 
           placeholder="Full Name" required>
  </div>

  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" 
           placeholder="Email Address" required>
  </div>

  <div class="form-group">
    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" 
           placeholder="Phone Number" required>
  </div>

  <div class="form-group">
    <label for="current_address">Current Address</label>
    <input type="text" id="current_address" name="current_address" 
           placeholder="Current Address" required>
  </div>

  <div class="form-group">
    <label>Employment Status</label>
    <div class="form-options">
      <label>
        <input type="radio" name="employment_status" value="employed"> Employed
      </label>
      <label>
        <input type="radio" name="employment_status" value="self-employed"> Self-employed
      </label>
      <label>
        <input type="radio" name="employment_status" value="unemployed"> Unemployed
      </label>
      <label>
        <input type="radio" name="employment_status" value="retired"> Retired
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="employer">Current Employer</label>
    <input type="text" id="employer" name="employer" 
           placeholder="Employer name (optional)">
  </div>

  <div class="form-group">
    <label for="income">Monthly Income</label>
    <input type="text" id="income" name="income" placeholder="$">
  </div>

  <div class="form-group">
    <label>Pets</label>
    <div class="form-options">
      <label>
        <input type="radio" name="pets" value="yes"> Yes
      </label>
      <label>
        <input type="radio" name="pets" value="no" checked> No
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="notes">Additional notes</label>
    <textarea id="notes" name="notes" rows="3" 
              placeholder="Any additional information..."></textarea>
  </div>

  <button type="submit" class="submit-btn">
    Submit Application
  </button>
</form>