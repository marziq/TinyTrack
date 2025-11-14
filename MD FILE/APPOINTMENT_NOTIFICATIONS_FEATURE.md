# In-App Appointment Notification Feature

## Overview
This feature automatically sends in-app notifications to parents as reminders for their baby's upcoming appointments. Notifications are sent 24 hours (or the next business day) before scheduled appointments.

## Components

### 1. **Command: SendAppointmentReminders**
**File:** `app/Console/Commands/SendAppointmentReminders.php`

This Artisan command handles sending appointment reminders:
- Finds all appointments scheduled for tomorrow with status "Waiting"
- Creates in-app notification entries in the database
- Sends email reminders via the AppointmentReminder mail class
- Prevents duplicate notifications using checks

**Usage:**
```bash
php artisan app:send-appointment-reminders
```

**Features:**
- Checks for appointments by date
- Automatically formats appointment details (date, time, purpose)
- Prevents duplicate notifications within the same day
- Logs all operations for debugging

### 2. **Scheduler Configuration**
**File:** `routes/console.php`

The reminder command is scheduled to run daily at 08:00 AM:
```php
Schedule::command('app:send-appointment-reminders')->dailyAt('08:00');
```

### 3. **NotificationsController API Endpoints**
**File:** `app/Http/Controllers/NotificationsController.php`

New API endpoints for the frontend:

#### Get All Notifications
```
GET /api/notifications
```
Returns all notifications (both read and unread) for the authenticated user.

**Response:**
```json
{
  "notifications": [...],
  "unreadCount": 5
}
```

#### Get Unread Notifications Only
```
GET /api/notifications/unread
```
Returns only unread notifications for the authenticated user, used for the notification bell.

**Response:**
```json
{
  "notifications": [...],
  "count": 3
}
```

#### Mark Notification as Read
```
POST /api/notifications/{id}/mark-read
```
Marks a specific notification as read.

**Response:**
```json
{
  "success": true,
  "message": "Notification marked as read"
}
```

### 4. **Routes Configuration**
**File:** `routes/web.php`

Added API routes under authenticated middleware:
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/api/notifications', [NotificationsController::class, 'getUserNotifications']);
    Route::get('/api/notifications/unread', [NotificationsController::class, 'getUnreadNotifications']);
    Route::post('/api/notifications/{id}/mark-read', [NotificationsController::class, 'markNotificationRead']);
});
```

### 5. **Frontend Integration**
**File:** `resources/views/user/appointment.blade.php`

Enhanced notification bell UI with real-time updates:
- Fetches unread notifications on page load
- Auto-refreshes notifications every 30 seconds
- Displays notification count badge
- Click on notification to view full message in modal
- Mark as read when notification is clicked
- Shows "No unread notifications" when none exist

**Key Features:**
```javascript
// Load notifications every 30 seconds
setInterval(loadNotifications, 30000);

// Display unread count in badge
notificationBadge.innerText = data.count;

// Mark notification as read when clicked
fetch(`/api/notifications/${notifId}/mark-read`, {...})
```

## Notification Model
**File:** `app/Models/Notification.php`

**Table:** `notifications`

**Fields:**
- `notification_id` (Primary Key)
- `user_id` (Foreign Key to users)
- `title` (String) - Notification title
- `message` (String) - Full notification message
- `dateSent` (DateTime) - When the notification was sent
- `status` (String) - 'read' or 'unread'

## Database Schema
The notifications table structure:
```php
Schema::create('notifications', function (Blueprint $table) {
    $table->id('notification_id');
    $table->foreignId('user_id');
    $table->string('title');
    $table->text('message');
    $table->dateTime('dateSent');
    $table->enum('status', ['read', 'unread'])->default('unread');
    $table->timestamps();
});
```

## Workflow

### When an Appointment is Created
1. User creates an appointment in the appointment page
2. Appointment is stored with status "Waiting" and a future date

### Daily Reminder Process
1. **08:00 AM:** Laravel scheduler triggers `app:send-appointment-reminders` command
2. Command queries all appointments scheduled for tomorrow with "Waiting" status
3. For each appointment found:
   - Checks if baby exists and has associated user
   - Prevents duplicate notifications
   - Creates notification record with formatted message
   - Sends email reminder via AppointmentReminder mail class
4. Logs all actions for debugging

### Frontend User Experience
1. Parent opens their dashboard
2. Notification bell shows unread count badge
3. Bell fetches unread notifications from `/api/notifications/unread`
4. Notifications are displayed in a dropdown list
5. Parent clicks on a notification to see full details in a modal
6. Clicking notification marks it as read via `/api/notifications/{id}/mark-read`
7. Notification count updates automatically

## Notification Message Format

Example in-app notification:
```
Title: Appointment Reminder - Baby Name
Message: "Your baby Baby Name has an appointment scheduled on Mon, Nov 15, 2025 at 02:30 PM. Purpose: Check-up"
```

## Testing

### Manual Testing
```bash
# Run the appointment reminder command manually
php artisan app:send-appointment-reminders

# Check notifications in database
php artisan tinker
>>> App\Models\Notification::where('user_id', 1)->get();
```

### API Testing
```bash
# Get all notifications (must be authenticated)
curl -X GET http://localhost/api/notifications \
  -H "Authorization: Bearer {token}"

# Get unread notifications
curl -X GET http://localhost/api/notifications/unread \
  -H "Authorization: Bearer {token}"

# Mark notification as read
curl -X POST http://localhost/api/notifications/1/mark-read \
  -H "Authorization: Bearer {token}"
```

## Configuration

### Schedule Time
To change reminder time, edit `routes/console.php`:
```php
// Change to 09:00 AM
Schedule::command('app:send-appointment-reminders')->dailyAt('09:00');

// Or at specific times
Schedule::command('app:send-appointment-reminders')->dailyAt('08:00')->dailyAt('20:00'); // 8 AM and 8 PM
```

### Duplicate Prevention
The duplicate check looks for notifications from the same day with appointment title:
```php
$existingNotification = Notification::where('user_id', $user->id)
    ->whereDate('dateSent', Carbon::today())
    ->where('title', 'like', '%' . $baby->name . '%Appointment%')
    ->first();
```

## Troubleshooting

### Notifications Not Appearing
1. Check scheduler is configured: `php artisan schedule:list`
2. Verify command runs: `php artisan app:send-appointment-reminders`
3. Check notifications table in database
4. Verify user is authenticated when accessing frontend

### Duplicate Notifications
- Check duplicate prevention logic in `SendAppointmentReminders.php`
- Clear notifications older than needed and re-run command

### API Returns 401
- Ensure user is authenticated (`auth:sanctum` middleware)
- Check CSRF token in POST requests
- Verify Authorization header for API requests

## Dependencies
- Laravel Framework (with Console Scheduling)
- Carbon (DateTime manipulation)
- Notification Model with user relationship
- Appointment Model with baby relationship
- Bootstrap 5 (for modal display)

## Future Enhancements
- SMS notifications
- Push notifications via browser/app
- Notification preferences (email only, in-app only, etc.)
- Custom reminder times (1 day, 1 week before)
- Notification history/archive
- Admin panel for notification management
