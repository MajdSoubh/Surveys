<?php

namespace App\Events;

use App\Models\Survey;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveyCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $survey;
    /**
     * The owner of the survey and the one who should broadcast event to him
     */
    private $userID;

    public function __construct($survey)
    {

        $this->survey = $survey;
        $this->userID = $survey->user_id;
    }
    public function broadcastWith()
    {
        return [
            'survey' => $this->survey
        ];
    }
    public function broadcastAs()
    {
        return 'SurveyCreated';
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('survey.' . $this->userID),
        ];
    }
}
