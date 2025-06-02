<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class PhpMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    protected function configure()
    {
        try {
            // Debug settings - change to 2 for full debugging
            $this->mailer->SMTPDebug = config('app.debug') ? 2 : 0;  // Enable verbose debug output in development
            $this->mailer->Debugoutput = function($str, $level) {
                Log::info("PHPMailer [$level]: $str");
            };
            
            // Server settings
            $this->mailer->isSMTP();                           // Send using SMTP
            $this->mailer->Host       = config('mail.mailers.smtp.host');       // SMTP server
            $this->mailer->SMTPAuth   = true;                  // Enable SMTP authentication
            $this->mailer->Username   = config('mail.mailers.smtp.username');   // SMTP username
            $this->mailer->Password   = config('mail.mailers.smtp.password');   // SMTP password
            
            // Security settings
            $encryption = config('mail.mailers.smtp.encryption');
            if ($encryption && strtolower($encryption) !== 'null') {
                $this->mailer->SMTPSecure = strtolower($encryption);  // ssl or tls
            } else {
                $this->mailer->SMTPSecure = '';  // No encryption
            }
            
            $this->mailer->Port = config('mail.mailers.smtp.port');  // TCP port to connect to
            
            // Disable SSL certificate verification if needed
            $this->mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
            
            // Default sender - use the SMTP username if from address is not set properly
            $fromAddress = config('mail.from.address');
            if (empty($fromAddress) || $fromAddress === 'hello@example.com') {
                $fromAddress = config('mail.mailers.smtp.username');
            }
            
            $this->mailer->setFrom(
                $fromAddress,
                config('mail.from.name', 'TMS System')
            );
            
            $this->mailer->isHTML(true);  // Set email format to HTML
            
            // Log the configuration for debugging
            if (config('app.debug')) {
                Log::info('PHPMailer Configuration:', [
                    'host' => $this->mailer->Host,
                    'port' => $this->mailer->Port,
                    'encryption' => $this->mailer->SMTPSecure,
                    'username' => $this->mailer->Username,
                    'from_address' => $fromAddress,
                ]);
            }
        } catch (Exception $e) {
            Log::error("Mailer configuration error: {$e->getMessage()}");
            throw new Exception("Mailer configuration error: {$e->getMessage()}");
        }
    }

    /**
     * Send an email
     *
     * @param string|array $to Recipient(s)
     * @param string $subject Email subject
     * @param string $htmlBody HTML content
     * @param string $textBody Plain text content (optional)
     * @param array $attachments Array of attachments (optional)
     * @return bool
     * @throws Exception
     */
    public function send($to, string $subject, string $htmlBody, string $textBody = '', array $attachments = []): bool
    {
        try {
            // Reset recipients
            $this->mailer->clearAllRecipients();
            $this->mailer->clearAttachments();
            
            // Add recipient(s)
            if (is_array($to)) {
                foreach ($to as $address) {
                    $this->mailer->addAddress($address);
                }
            } else {
                $this->mailer->addAddress($to);
            }

            // Set content
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $htmlBody;
            
            if (!empty($textBody)) {
                $this->mailer->AltBody = $textBody;
            }

            // Add attachments
            foreach ($attachments as $attachment) {
                if (isset($attachment['path'])) {
                    $this->mailer->addAttachment(
                        $attachment['path'],
                        $attachment['name'] ?? '',
                        $attachment['encoding'] ?? 'base64',
                        $attachment['type'] ?? ''
                    );
                }
            }

            // Send the email
            return $this->mailer->send();
        } catch (Exception $e) {
            \Log::error("Email sending failed: {$e->getMessage()}");
            throw new Exception("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        }
    }
}
