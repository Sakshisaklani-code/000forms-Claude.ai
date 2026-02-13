<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarship Application Form - 000form Library</title>
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

        .scholarship-form {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
            background: #0d0d0d;
            border: 1px solid #1a1a1a;
            border-radius: 12px;
        }

        .scholarship-form h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #fafafa;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .scholarship-form .form-description {
            font-size: 0.9rem;
            color: #888888;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .scholarship-form h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #00ff88;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed #2a2a2a;
        }

        .scholarship-form h4:first-of-type {
            margin-top: 0;
        }

        .scholarship-form .form-group {
            margin-bottom: 1.25rem;
        }

        .scholarship-form label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #e6edf3;
            margin-bottom: 0.35rem;
        }

        .scholarship-form input[type="text"],
        .scholarship-form input[type="email"],
        .scholarship-form input[type="tel"],
        .scholarship-form textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0;
            background: #111111;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            color: #fafafa;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .scholarship-form input:focus,
        .scholarship-form textarea:focus {
            outline: none;
            border-color: #00ff88;
            box-shadow: 0 0 0 3px rgba(0, 255, 136, 0.15);
        }

        .scholarship-form input::placeholder,
        .scholarship-form textarea::placeholder {
            color: #555555;
        }

        .scholarship-form .form-row {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .scholarship-form .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .scholarship-form textarea {
            resize: vertical;
            min-height: 120px;
        }

        .scholarship-form .submit-btn {
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

        .scholarship-form .submit-btn:hover {
            background: #fafafa;
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.15);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .scholarship-form {
                padding: 1.5rem;
            }

            .scholarship-form .form-row {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <form action="https://000form.com/f/your-endpoint" method="POST" class="scholarship-form">
        <h3>Scholarship Application Form</h3>
        <p class="form-description">
            Apply for educational scholarships and financial aid opportunities.
        </p>

        <h4>Student information</h4>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="text" id="dob" name="dob" placeholder="MM/DD/YYYY" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
        </div>

        <h4>Academic information</h4>

        <div class="form-group">
            <label for="institution">School/University</label>
            <input type="text" id="institution" name="institution" placeholder="Name of institution" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="graduation_year">Graduation Year</label>
                <input type="text" id="graduation_year" name="graduation_year" placeholder="YYYY" required>
            </div>
            <div class="form-group">
                <label for="gpa">GPA</label>
                <input type="text" id="gpa" name="gpa" placeholder="0.0 - 4.0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="major">Major/Field of Study</label>
            <input type="text" id="major" name="major" placeholder="Your major" required>
        </div>

        <h4>Scholarship details</h4>

        <div class="form-group">
            <label for="scholarship_name">Scholarship Name</label>
            <input type="text" id="scholarship_name" name="scholarship_name" placeholder="Name of scholarship" required>
        </div>

        <div class="form-group">
            <label for="amount">Amount Requested</label>
            <input type="text" id="amount" name="amount" placeholder="$" required>
        </div>

        <div class="form-group">
            <label for="statement">Personal Statement</label>
            <textarea id="statement" name="statement" placeholder="Write your personal statement here..." required></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Scholarship Application</button>
    </form>
</body>
</html>