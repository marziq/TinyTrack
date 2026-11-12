<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment; // <-- Make appointment public
    public $user; // optional user provided to the mailable

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, User $user = null) // <-- Pass in the Appointment and optional User
    {
        $this->appointment = $appointment;
        $this->user = $user;

        // If appointment->user is null but a user was provided, attach it so the view can access it
        if ($this->user && (is_null($this->appointment->user) || empty($this->appointment->user))) {
            $this->appointment->setRelation('user', $this->user);
        }

        // Ensure baby relation exists (no-op if already loaded)
        if ($this->appointment->baby) {
            $this->appointment->setRelation('baby', $this->appointment->baby);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('support@tinytrack.com', 'TinyTrack Support'),
            subject: 'Your Appointment Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-reminder', // <-- Point to our new template
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
