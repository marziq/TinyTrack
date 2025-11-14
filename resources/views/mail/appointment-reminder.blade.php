<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: auto; padding: 20px; }
        .header { font-size: 24px; color: #1976d2; }
        .content { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Hi {{ $appointment->user->name }},</div>

        <div class="content">
            <p>This is a friendly reminder for your upcoming appointment for <strong>{{ $appointment->baby->name }}</strong>.</p>

            <p>
                <strong>Date:</strong> {{ $appointment->appointmentDate->format('F j, Y') }}<br>
                <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('g:i A') }}<br>
                <strong>Purpose:</strong> {{ $appointment->purpose }}
            </p>

            <p>If you need to reschedule, please contact us.</p>
        </div>

        <div class="footer">
            <p>Thank you,<br>The TinyTrack Team</p>
        </div>
    </div>
</body>
</html>
