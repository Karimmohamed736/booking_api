<?php

namespace App\Notifications;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotify extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    private $otp;



    //Create a new notification instance.
    public function __construct()
    {
        $this->message = "Use the OTP code below to verify your email address.";
        $this->subject = "Email Verification";
        $this->fromEmail = config('mail.from.address');
        $this->mailer= "smtp";
        $this->otp= new Otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otpCode = $this->otp->generate($notifiable->email,'numeric',6,120); // Generate a 6-digit OTP for email valid for 120 seconds
        return (new MailMessage)
            ->mailer($this->mailer)
            ->subject($this->subject)
            ->greeting("Hello, $notifiable->name")
            ->line($this->message)
            ->line("Your OTP code is: $otpCode->token");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
