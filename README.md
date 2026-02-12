# 000form.com

A free, open-source form backend service for static websites. A FormSpree/FormSubmit clone built with Laravel and Supabase.

## Features

- **Free Forever**: No credit card required, no hidden fees
- **Email Notifications**: Get instant notifications for form submissions
- **Spam Protection**: Built-in honeypot fields
- **Dashboard**: View and manage all submissions
- **AJAX Support**: Submit forms without page reloads
- **CSV Export**: Download your data anytime
- **Custom Redirects**: Redirect users after submission

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: PostgreSQL (via Supabase)
- **Authentication**: Supabase Auth (Email + Google OAuth)
- **Frontend**: Vanilla JavaScript
- **Email**: Self-hosted SMTP

## Requirements

- PHP 8.2+
- PostgreSQL 14+
- Composer
- Node.js (for asset compilation, optional)
- Nginx or Apache
- Self-hosted Supabase instance

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/000form.git
cd 000form
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your configuration:

```env
# App
APP_URL=https://000form.com

# Supabase
SUPABASE_URL=http://your-supabase-instance:8000
SUPABASE_KEY=your-anon-key
SUPABASE_SERVICE_KEY=your-service-key
SUPABASE_JWT_SECRET=your-jwt-secret

# Database
DB_CONNECTION=pgsql
DB_HOST=your-supabase-db-host
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password

# Mail
MAIL_HOST=mail.000form.com
MAIL_USERNAME=noreply@000form.com
MAIL_PASSWORD=your-mail-password

# Google OAuth (optional)
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
```

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Configure web server

See `deploy/nginx.conf` for Nginx configuration.

### 6. Set up queue worker

```bash
php artisan queue:work
```

Or use Supervisor (see `deploy/setup.sh`).

## Deployment

For Digital Ocean Ubuntu deployment, use the provided script:

```bash
sudo bash deploy/setup.sh
```

## Usage

### Basic HTML Form

```html
<form action="https://000form.com/f/YOUR_FORM_ID" method="POST">
  <input type="email" name="email" required>
  <textarea name="message"></textarea>
  <button type="submit">Send</button>
</form>
```

### Special Fields

| Field | Description |
|-------|-------------|
| `email` | Sender's email (enables reply-to) |
| `_replyto` | Alternative reply-to email |
| `_subject` | Custom email subject |
| `_next` | Redirect URL after submission |
| `_gotcha` | Honeypot field (spam protection) |
| `_format` | Set to `json` for JSON response |

### AJAX Submission

```javascript
fetch('https://000form.com/f/YOUR_FORM_ID', {
  method: 'POST',
  body: new FormData(form),
  headers: { 'Accept': 'application/json' }
})
.then(res => res.json())
.then(data => console.log(data));
```

## Project Structure

```
000form/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   └── FormSubmissionController.php
│   │   └── Middleware/
│   ├── Mail/
│   ├── Models/
│   └── Services/
│       ├── SpamDetectionService.php
│       └── SupabaseAuthService.php
├── config/
├── database/migrations/
├── deploy/
├── public/
├── resources/views/
└── routes/web.php
```

## Future Roadmap

### Phase 2
- File uploads
- reCAPTCHA integration
- Webhook notifications
- Custom auto-reply emails

### Phase 3
- Custom domains
- Slack/Discord integrations
- Team collaboration
- API access

### Phase 4+
- Drag-and-drop form builder
- Payment integration
- White-label option

## Contributing

Contributions are welcome! Please read our contributing guidelines first.

## License

MIT License - see LICENSE file for details.

## Support

- Documentation: https://000form.com/docs
- Email: support@000form.com
- Issues: GitHub Issues
