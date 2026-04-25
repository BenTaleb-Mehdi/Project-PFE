# Guide: Setting up Email Notifications for Client Credentials

This document outlines the steps taken to implement and fix the email notification system that sends login credentials to clients upon registration.

## 1. Environment Configuration (`.env`)
The first step was configuring the mail server settings. We used Gmail's SMTP server.

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=mehdibentaleb548@gmail.com
MAIL_PASSWORD="your-google-app-password"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=mehdibentaleb548@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

> [!IMPORTANT]
> For Gmail, you must use an **App Password**, not your regular account password.

## 2. Create the Notification Class
We created a dedicated Laravel Notification class to handle the email logic.

**Command:**
```bash
php artisan make:notification SendClientCredentials
```

**Implementation (`app/Notifications/SendClientCredentials.php`):**
- Passed the generated `$password` through the constructor.
- Used the `toMail` method to define the subject and template.
- Specified the Markdown view `emails.client_credentials`.

## 3. Design the Email Template
We created a clean, professional Markdown-based email template.

**File:** `resources/views/emails/client_credentials.blade.php`
- Includes the client's email.
- Includes the temporary password.
- Provides a direct link to the login page.

## 4. Integrate into the Service Layer
We updated the `ClientRegistryService` to handle the registration workflow.

**File:** `app/Services/ClientRegistryService.php`
- **Step A:** Generate a random secure password using `Str::random(12)`.
- **Step B:** Create the `User` and `Client` records within a database transaction.
- **Step C:** Trigger the notification using `$user->notify(new SendClientCredentials($password))`.
- **Step D:** Added a `try-catch` block with logging (`Log::info`/`Log::error`) to ensure that if an email fails, the registration still completes but the error is recorded.

## 5. Troubleshooting & Fixes
During the process, we resolved several common issues:

- **Sender Verification:** Ensured `MAIL_FROM_ADDRESS` matches the `MAIL_USERNAME` to prevent SMTP "Sender address rejected" errors.
- **SSL Verification:** On some Windows environments, PHP might need a `cacert.pem` file configured in `php.ini`. We used `MAIL_ENCRYPTION=ssl` on port `465` for a stable connection.
- **Sync vs Async:** We kept the notification synchronous (didn't implement `ShouldQueue` yet) to ensure immediate delivery and easier debugging during development.

---
**Status:** ✅ Successfully sending credentials directly to the client's inbox.
