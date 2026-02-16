<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Application Form - 000form Library</title>
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

        .internship-form {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 12px;
        }

        .internship-form h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fafafa;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .internship-form .form-description {
            font-size: 0.9rem;
            color: #888888;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .internship-form h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #00ff88;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed #2a2a2a;
        }

        .internship-form h4:first-of-type {
            margin-top: 0;
        }

        .internship-form .form-group {
            margin-bottom: 1.25rem;
        }

        .internship-form label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #e6edf3;
            margin-bottom: 0.5rem;
        }

        .internship-form input[type="text"],
        .internship-form input[type="email"],
        .internship-form input[type="tel"],
        .internship-form select,
        .internship-form textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #111111;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            color: #fafafa;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .internship-form input:focus,
        .internship-form select:focus,
        .internship-form textarea:focus {
            outline: none;
            border-color: #00ff88;
            box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.15);
        }

        .internship-form input::placeholder,
        .internship-form textarea::placeholder {
            color: #555555;
        }

        .internship-form select {
            cursor: pointer;
        }

        .internship-form .form-row {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .internship-form .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .internship-form .checkbox-group {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.5rem;
        }

        .internship-form .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .internship-form input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #00ff88;
            cursor: pointer;
        }

        .internship-form .checkbox-label {
            font-size: 0.85rem;
            color: #888888;
            cursor: pointer;
        }

        .internship-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .internship-form .submit-btn {
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

        .internship-form .submit-btn:hover {
            background: #fafafa;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.15);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .internship-form {
                padding: 1.5rem;
            }

            .internship-form .form-row {
                flex-direction: column;
                gap: 0.5rem;
            }

            .internship-form .checkbox-group {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <form action="https://000form.com/f/your-endpoint" method="POST" class="internship-form">
        <h3>Internship Application Form</h3>
        <p class="form-description">
            Apply for internship positions at our company.
        </p>

        <h4>Personal information</h4>

        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
        </div>

        <h4>Education</h4>

        <div class="form-group">
            <label for="university">University:</label>
            <input type="text" id="university" name="university" placeholder="Name of university" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="major">Major:</label>
                <input type="text" id="major" name="major" placeholder="Your major" required>
            </div>
            <div class="form-group">
                <label for="graduation">Graduation:</label>
                <input type="text" id="graduation" name="graduation" placeholder="MM/YYYY" required>
            </div>
        </div>

        <h4>Internship details</h4>

        <div class="form-group">
            <label for="position">Position:</label>
            <select id="position" name="position" required>
                <option value="">Select a position</option>
                <option value="software-engineering">Software Engineering</option>
                <option value="product-management">Product Management</option>
                <option value="design">Design</option>
                <option value="marketing">Marketing</option>
                <option value="data-science">Data Science</option>
                <option value="business-development">Business Development</option>
            </select>
        </div>

        <div class="form-group">
            <label>Availability:</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="fulltime" name="availability[]" value="full-time">
                    <label for="fulltime" class="checkbox-label">Full-Time</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="parttime" name="availability[]" value="part-time">
                    <label for="parttime" class="checkbox-label">Part-Time</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="text" id="start_date" name="start_date" placeholder="MM/DD/YYYY" required>
        </div>

        <div class="form-group">
            <label for="motivation">Why are you interested in this internship?</label>
            <textarea id="motivation" name="motivation" placeholder="Write your motivation" required></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Internship Application</button>
    </form>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\Library\Internship-ApplicationForm.blade.php ENDPATH**/ ?>