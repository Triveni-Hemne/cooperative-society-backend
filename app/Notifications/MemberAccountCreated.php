<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Member;
use App\Models\MemberContactDetail;
use App\Broadcasting\Messages\WhatsAppChannel;
use App\Broadcasting\Messages\WhatsAppMessage;

class MemberAccountCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $member;
    public function __construct($member)
    {
        $this->member = $member;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }
    
    public function toWhatsApp($notifiable)
    {
        // $orderUrl = url("/members/{$this->order->id}");
        $company = 'RTSoft';
        $AccCreatedDate = $this->member->created_at->addDays(4)->toFormattedDateString();


        return (new WhatsAppMessage)
            ->content("Your {$company} Member Account Created Successfully at {$AccCreatedDate}");
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