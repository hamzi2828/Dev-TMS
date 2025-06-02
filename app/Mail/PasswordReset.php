<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Services\PhpMailerService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    protected $phpMailer;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->phpMailer = new PhpMailerService();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Has Been Reset',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset',
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
    
    /**
     * Send the password reset email using PHPMailer
     *
     * @param string $email
     * @return bool
     */
    public function sendWithPhpMailer(string $email): bool
    {
        try {
            // Render the email template
            $htmlContent = View::make('emails.password-reset', [
                'user' => $this->user,
                'password' => $this->password
            ])->render();
            
            // Send the email using PHPMailer
            return $this->phpMailer->send(
                $email,
                'Your Password Has Been Reset',
                $htmlContent,
                'Your password has been reset. Your new password is: ' . $this->password
            );
        } catch (\Exception $e) {
            Log::error('Failed to send password reset email: ' . $e->getMessage());
            return false;
        }
    }
}
