<?php

namespace App\Broadcasting\Messages;

use App\Models\Member;
use App\Models\MemberContactDetail;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsAppChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
       
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);


        $to = $notifiable->routeNotificationFor('WhatsApp');
        if (!$to) {
            throw new \Exception('Recipient WhatsApp number is not set.');
        }
        $from = config('services.twilio.whatsapp_from');
        
        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.token');

        if (!$twilioSid || !$twilioToken) {
            throw new \Exception('Twilio credentials are not set.');
        }

        $twilio = new Client($twilioSid, $twilioToken);

        return $twilio->messages->create('whatsapp:' . $to, [
            "from" => 'whatsapp:' . $from,
            "body" => $message->content
        ]);
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        //
    }
}