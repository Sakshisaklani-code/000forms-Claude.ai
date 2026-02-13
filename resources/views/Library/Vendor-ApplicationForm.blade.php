<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Application Form - 000form Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: #050505;
            color: #fafafa;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vendor-form {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 12px;
        }

        .vendor-form h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fafafa;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .vendor-form .form-description {
            font-size: 0.9rem;
            color: #888888;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .vendor-form h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #00ff88;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed #2a2a2a;
        }

        .vendor-form h4:first-of-type {
            margin-top: 0;
        }

        .vendor-form .form-group {
            margin-bottom: 1.25rem;
        }

        .vendor-form label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #e6edf3;
            margin-bottom: 0.5rem;
        }

        .vendor-form input[type="text"],
        .vendor-form input[type="email"],
        .vendor-form input[type="tel"],
        .vendor-form select {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #111111;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            color: #fafafa;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .vendor-form input:focus,
        .vendor-form select:focus {
            outline: none;
            border-color: #00ff88;
            box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.15);
        }

        .vendor-form input::placeholder {
            color: #555555;
        }

        .vendor-form select {
            cursor: pointer;
        }

        .vendor-form .form-row {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .vendor-form .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .vendor-form .submit-btn {
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

        .vendor-form .submit-btn:hover {
            background: #fafafa;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.15);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .vendor-form {
                padding: 1.5rem;
            }

            .vendor-form .form-row {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <form action="https://000form.com/f/your-endpoint" method="POST" class="vendor-form">
        <h3>Vendor Application Form</h3>
        <p class="form-description">
            Register your business as a vendor or supplier for our company.
        </p>

        <h4>Company information</h4>

        <div class="form-group">
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" placeholder="Enter your company name" required>
        </div>

        <div class="form-group">
            <label for="business_type">Business Type:</label>
            <select id="business_type" name="business_type" required>
                <option value="">Select business type</option>
                <option value="sole-proprietorship">Sole Proprietorship</option>
                <option value="partnership">Partnership</option>
                <option value="llc">LLC</option>
                <option value="corporation">Corporation</option>
                <option value="non-profit">Non-Profit</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tax_id">Tax ID / EIN:</label>
            <input type="text" id="tax_id" name="tax_id" placeholder="XX-XXXXXXX" required>
        </div>

        <h4>Contact person</h4>

        <div class="form-group">
            <label for="contact_name">Full Name:</label>
            <input type="text" id="contact_name" name="contact_name" placeholder="Enter contact name" required>
        </div>

        <div class="form-group">
            <label for="contact_email">Email:</label>
            <input type="email" id="contact_email" name="contact_email" placeholder="Enter email address" required>
        </div>

        <div class="form-group">
            <label for="contact_phone">Phone:</label>
            <input type="tel" id="contact_phone" name="contact_phone" placeholder="Enter phone number" required>
        </div>

        <h4>Business address</h4>

        <div class="form-group">
            <label for="street_address">Street Address:</label>
            <input type="text" id="street_address" name="street_address" placeholder="Street address" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" placeholder="City" required>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" placeholder="State" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="zip">ZIP Code:</label>
                <input type="text" id="zip" name="zip" placeholder="ZIP Code" required>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" placeholder="USA" value="USA">
            </div>
        </div>

        <button type="submit" class="submit-btn">Submit Vendor Application</button>
    </form>
</body>
</html>