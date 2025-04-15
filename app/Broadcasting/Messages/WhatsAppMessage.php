<?php

namespace App\Broadcasting\Messages;
// namespace App\Channels\Messages;

use App\Models\User;

class WhatsAppMessage
{
    public $content;    
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
    
    }
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        //
    }
}