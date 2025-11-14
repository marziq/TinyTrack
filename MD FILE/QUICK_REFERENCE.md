# 🔔 Quick Reference: In-App Appointment Notifications

## Overview
Automated in-app notifications that remind parents about their baby's upcoming appointments.

## Key Components

### 1. Command
```bash
php artisan app:send-appointment-reminders
```
- **Runs:** Daily at 08:00 AM (via scheduler)
- **Does:** Creates in-app notifications for tomorrow's appointments
- **File:** `app/Console/Commands/SendAppointmentReminders.php`

### 2. API Endpoints
```
GET  /api/notifications              - All notifications
GET  /api/notifications/unread       - Unread only (for bell)
POST /api/notifications/{id}/mark-read - Mark as read
```

### 3. Frontend
**File:** `resources/views/user/appointment.blade.php`

Features:
- Notification bell with red badge showing count
- Auto-refreshes every 30 seconds
- Click notification to view full details
- Mark as read when clicked
- Modal popup for full message

### 4. Database
**Table:** `notifications`
- Stores all notification records
- Links to users
- Tracks read/unread status

## How to Use

### For Development Testing
```bash
# Test the command manually
php artisan app:send-appointment-reminders

# Check what was created
php artisan tinker
>>> App\Models\Notification::latest()->first();
```

### For Users
1. Create appointment on appointment page
2. See notification tomorrow at 08:00 AM (command runs)
3. Click bell icon to see notifications
4. Click notification to view full details
5. Notification auto-marks as read

## Configuration

### Change Reminder Time
Edit `routes/console.php`:
```php
// Change from 08:00 to 09:00
Schedule::command('app:send-appointment-reminders')->dailyAt('09:00');
```

### Add Multiple Times
```php
Schedule::command('app:send-appointment-reminders')
    ->dailyAt('08:00')
    ->dailyAt('20:00');  // Also at 8 PM
```

## Notification Example

**When created:**
- User has appointment for Baby "Emma" on Nov 15 at 2:30 PM for "Check-up"

**At 08:00 AM on Nov 15:**
- Title: `Appointment Reminder - Emma`
- Message: `Your baby Emma has an appointment scheduled on Sat, Nov 15, 2025 at 02:30 PM. Purpose: Check-up`

## Frontend Integration Points

The notification system integrates with:
- Appointment creation (`/appointments` route)
- Dashboard notification bell icon
- Notification dropdown display
- Bootstrap 5 modal for details

## Relationships

```
Appointment → Baby → User
User ← has many → Notifications
```

The system automatically:
- Finds appointments scheduled for tomorrow
- Gets the associated baby
- Gets the baby's user (parent)
- Creates notification for that user

## Troubleshooting

| Issue | Solution |
|-------|----------|
| No notifications appear | Check scheduler: `php artisan schedule:list` |
| Duplicate notifications | Restart Laravel app, clear cache |
| API returns 401 | Ensure user is logged in (check CSRF token) |
| Bell not updating | Check browser console for JavaScript errors |

## Files Modified

1. ✅ `app/Console/Commands/SendAppointmentReminders.php`
2. ✅ `app/Http/Controllers/NotificationsController.php`
3. ✅ `app/Models/User.php` (added notifications relationship)
4. ✅ `routes/web.php` (added API routes)
5. ✅ `resources/views/user/appointment.blade.php` (enhanced UI)

## Testing Commands

```bash
# Verify command exists
php artisan app:send-appointment-reminders --help

# Run manually
php artisan app:send-appointment-reminders

# Check database
php artisan tinker
>>> App\Models\Notification::count();

# Check routes registered
php artisan route:list | grep api/notifications
```

## Important Notes

- ✅ Notifications only created for "Waiting" status appointments
- ✅ Only created for future appointments (tomorrow and beyond)
- ✅ Duplicate prevention: One notification per appointment per day
- ✅ Both email and in-app notifications sent
- ✅ Email functionality maintained (backward compatible)
- ✅ Scheduler configured and running daily at 08:00 AM

---

**Last Updated:** November 14, 2025
**Status:** Production Ready ✅
