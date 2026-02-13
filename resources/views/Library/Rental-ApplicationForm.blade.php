<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Application Form - 000form Library</title>
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

        .rental-form {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 12px;
        }

        .rental-form h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fafafa;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .rental-form .form-description {
            font-size: 0.9rem;
            color: #888888;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .rental-form h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #00ff88;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed #2a2a2a;
        }

        .rental-form h4:first-of-type {
            margin-top: 0;
        }

        .rental-form .form-group {
            margin-bottom: 1.25rem;
        }

        .rental-form label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #e6edf3;
            margin-bottom: 0.35rem;
        }

        .rental-form input[type="text"],
        .rental-form input[type="email"],
        .rental-form input[type="tel"] {
            width: 100%;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0;
            background: #111111;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            color: #fafafa;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .rental-form input:focus {
            outline: none;
            border-color: #00ff88;
            box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.15);
        }

        .rental-form input::placeholder {
            color: #555555;
        }

        .rental-form .form-row {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .rental-form .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .rental-form .submit-btn {
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

        .rental-form .submit-btn:hover {
            background: #fafafa;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.15);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .rental-form {
                padding: 1.5rem;
            }

            .rental-form .form-row {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <form action="https://000form.com/f/your-endpoint" method="POST" class="rental-form">
        <h3>Rental Application Form</h3>
        <p class="form-description">
            Please complete this rental application form to begin the tenant screening process.
        </p>

        <h4>Personal details</h4>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="text" id="dob" name="dob" placeholder="MM/DD/YYYY" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
        </div>

        <h4>Current address</h4>

        <div class="form-group">
            <label for="street_address">Street Address</label>
            <input type="text" id="street_address" name="street_address" placeholder="Street Address" required>
            <input type="text" id="apt_suite" name="apt_suite" placeholder="Apt/Suite (optional)">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="City" required>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="State" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="zip">ZIP Code</label>
                <input type="text" id="zip" name="zip" placeholder="ZIP Code" required>
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" id="country" name="country" placeholder="USA" value="USA">
            </div>
        </div>

        <h4>Employment</h4>

        <div class="form-group">
            <label for="employer">Current Employer</label>
            <input type="text" id="employer" name="employer" placeholder="Employer name" required>
        </div>

        <div class="form-group">
            <label for="income">Monthly Income</label>
            <input type="text" id="income" name="income" placeholder="$" required>
        </div>

        <button type="submit" class="submit-btn">Submit Application</button>
    </form>
</body>
</html>