# 🧪 Testing Guide - In-App Appointment Notifications

## Quick Start Testing

### 1. Verify Installation (1 minute)

```bash
# Check if command exists
php artisan app:send-appointment-reminders --help
# Should show: "Send email and in-app notifications for appointments happening tomorrow"

# Check if routes exist
php artisan route:list | grep api/notifications
# Should show 3 routes
```

### 2. Manual Command Test (5 minutes)

```bash
# Run the command manually
php artisan app:send-appointment-reminders

# Expected output:
# Checking for appointments tomorrow...
# No appointments for tomorrow.  (or found X appointments)
```

### 3. Database Verification (5 minutes)

```bash
# Enter tinker
php artisan tinker

# Check if notifications table exists
>>> DB::table('notifications')->count();
# Should return number of notifications

# Get latest notification
>>> App\Models\Notification::latest()->first();
# Should show notification object with all fields

# Get notifications for a specific user
>>> App\Models\Notification::where('user_id', 1)->get();
```

### 4. API Endpoint Testing (10 minutes)

#### Using cURL
```bash
# Get all notifications (replace TOKEN with actual bearer token)
curl -X GET http://localhost:8000/api/notifications \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"

# Get unread notifications only
curl -X GET http://localhost:8000/api/notifications/unread \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"

# Mark notification as read (replace 1 with actual notification_id)
curl -X POST http://localhost:8000/api/notifications/1/mark-read \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN"
```

#### Using Postman
1. Create new GET request: `http://localhost:8000/api/notifications/unread`
2. Go to Authorization tab → Select "Bearer Token"
3. Paste your auth token
4. Go to Headers tab → Add `Accept: application/json`
5. Click Send
6. Should return JSON with notifications array and count

### 5. Frontend Testing (15 minutes)

#### Step 1: Create Test Appointment
1. Login to dashboard
2. Go to Appointment page
3. Create appointment for tomorrow at any time
4. Fill all required fields
5. Click "Submit Appointment"
6. Verify it appears in appointment list

#### Step 2: Run Command to Generate Notification
```bash
# In terminal, run:
php artisan app:send-appointment-reminders

# Should show:
# Found 1 appointments. Sending emails and in-app notifications...
# Notification created for user X (X@email.com).
```

#### Step 3: Test Notification Bell UI
1. Refresh dashboard page
2. Look for notification bell icon (top right)
3. Should see red badge with count "1"
4. Click bell → dropdown appears with notification
5. Notification shows: "Appointment Reminder - BabyName"
6. Shows preview of appointment details

#### Step 4: Test Click to Read
1. Click on notification in dropdown
2. Modal popup appears with full details
3. Shows:
   - Title: "Appointment Reminder - BabyName"
   - Full message with date/time/purpose
   - "Received: Date" at bottom
4. Badge count updates to "0"
5. Close modal with X button

#### Step 5: Test Auto-Refresh
1. Keep notification bell dropdown open
2. In another browser/tab, manually create another appointment
3. In first tab, wait 30 seconds
4. New notification should appear automatically
5. Badge count updates to "2"

## Advanced Testing

### Test Duplicate Prevention

```bash
# Create appointment for tomorrow
# Run command twice:
php artisan app:send-appointment-reminders
# First run: Creates notification

php artisan app:send-appointment-reminders
# Second run: Shows "Notification already exists"

# Verify only ONE notification in database
php artisan tinker
>>> App\Models\Notification::where('title', 'like', '%appointment%')->count();
# Should return 1 (not 2)
```

### Test Scheduler

```bash
# List all scheduled tasks
php artisan schedule:list

# Should show:
# app:send-appointment-reminders ........... 08:00

# To debug scheduler
php artisan schedule:run --verbose
# This simulates running the scheduler once
```

### Test Multiple Appointments

```bash
# Create 3 appointments for tomorrow in database directly
php artisan tinker

>>> $baby = App\Models\Baby::first();
>>> App\Models\Appointment::create([
    'baby_id' => $baby->id,
    'appointmentDate' => now()->addDay()->toDateString(),
    'appointmentTime' => '10:00:00',
    'purpose' => 'Checkup',
    'status' => 'Waiting'
]);

# Repeat for multiple appointments
# Run command:
php artisan app:send-appointment-reminders

# Should create 3 notifications
# Frontend should show badge: "3"
```

### Test API Response Formats

```bash
# Terminal 1: Monitor notifications table
watch -n 1 'php artisan tinker <<< "App\Models\Notification::latest()->get();" 2>/dev/null'

# Terminal 2: Make API calls and observe updates
curl -X GET http://localhost:8000/api/notifications/unread \
  -H "Authorization: Bearer TOKEN" | jq

# Should show JSON:
# {
#   "notifications": [...],
#   "count": X
# }
```

## Automated Testing

### Create Test Command
Create file: `app/Console/Commands/TestNotifications.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Baby;
use Carbon\Carbon;

class TestNotifications extends Command
{
    protected $signature = 'test:notifications';
    protected $description = 'Create test appointment for tomorrow';

    public function handle()
    {
        $baby = Baby::first();
        
        if (!$baby) {
            $this->error('No babies found. Create a baby first.');
            return;
        }

        $appointment = Appointment::create([
            'baby_id' => $baby->id,
            'appointmentDate' => now()->addDay()->toDateString(),
            'appointmentTime' => '10:30:00',
            'purpose' => 'Test Checkup',
            'status' => 'Waiting'
        ]);

        $this->info("Created test appointment: {$appointment->appointmentID}");
        $this->info("Run: php artisan app:send-appointment-reminders");
    }
}
```

### Run Test Sequence
```bash
# 1. Create test appointment
php artisan test:notifications

# 2. Run reminder command
php artisan app:send-appointment-reminders

# 3. Check database
php artisan tinker
>>> App\Models\Notification::latest()->first();

# 4. Test via browser
# Login and check notification bell
```

## Troubleshooting Checklist

### No notifications appear
- [ ] Command runs without errors: `php artisan app:send-appointment-reminders`
- [ ] Tomorrow's appointments exist: `php artisan tinker` → `App\Models\Appointment::where('appointmentDate', now()->addDay()->toDateString())->get();`
- [ ] User has id: `>>> $appointment->baby->user;`
- [ ] Notification in database: `>>> App\Models\Notification::latest()->first();`

### Bell doesn't show count
- [ ] Browser console has no errors (F12 → Console)
- [ ] API returns data: Test `/api/notifications/unread` in curl
- [ ] JavaScript `loadNotifications()` executes on page load
- [ ] Authentication token valid: Check if user is logged in

### Click doesn't open modal
- [ ] Bootstrap 5 loaded: Check `<script src="bootstrap.bundle.min.js">`
- [ ] CSS styles loaded: Check for bootstrap CSS in head
- [ ] JavaScript error: Check browser console
- [ ] Modal HTML generated: Inspect page source for `id="notifModal"`

### Auto-refresh not working
- [ ] JavaScript runs: Add `console.log('Auto-refresh active')` in `loadNotifications()`
- [ ] setInterval working: Check `window.setInterval` in console
- [ ] API endpoint accessible: Test manually in curl
- [ ] CSRF token valid: Check in form

## Performance Testing

### Check API Response Time
```bash
# Time the API call
curl -w '\nTotal time: %{time_total}s\n' \
  -X GET http://localhost:8000/api/notifications/unread \
  -H "Authorization: Bearer TOKEN"

# Should be < 100ms for good performance
```

### Database Query Performance
```bash
# Enable query logging
php artisan tinker
>>> DB::enableQueryLog();
>>> $notifications = App\Models\Notification::where('user_id', 1)->get();
>>> dd(DB::getQueryLog());

# Should show efficient query with eager loading
```

## Security Testing

### Test Authentication
```bash
# Try without token - should get 401
curl -X GET http://localhost:8000/api/notifications/unread

# Try with invalid token - should get 401
curl -X GET http://localhost:8000/api/notifications/unread \
  -H "Authorization: Bearer invalid_token"
```

### Test Authorization
```bash
# User 1 tries to read User 2's notifications
# API should only return User 1's notifications

# Should NOT return other users' notifications
```

### Test CSRF Protection
```bash
# Try POST without CSRF token - should fail
curl -X POST http://localhost:8000/api/notifications/1/mark-read \
  -H "Authorization: Bearer TOKEN"

# Should return 419 (CSRF token mismatch)
```

## Success Criteria Checklist

- [ ] Command runs successfully
- [ ] Notifications created in database
- [ ] API endpoints return correct data
- [ ] Frontend bell shows badge
- [ ] Click opens modal
- [ ] Mark as read works
- [ ] Auto-refresh updates UI
- [ ] No duplicate notifications
- [ ] Emails still send
- [ ] Scheduler runs daily at 08:00
- [ ] No JavaScript errors in console
- [ ] Responsive on mobile
- [ ] Works in different browsers

## Test Results Template

```
Test Date: _______________
Tester: ___________________

✅ Command Test: PASS / FAIL
✅ Database Test: PASS / FAIL
✅ API Test: PASS / FAIL
✅ Frontend Test: PASS / FAIL
✅ Auto-refresh Test: PASS / FAIL
✅ Scheduler Test: PASS / FAIL
✅ Security Test: PASS / FAIL

Issues Found:
_________________________________
_________________________________

Notes:
_________________________________
_________________________________

Signed: ___________________
```

---

**Testing Guide Version:** 1.0
**Last Updated:** November 14, 2025
**Status:** ✅ Ready for Testing
