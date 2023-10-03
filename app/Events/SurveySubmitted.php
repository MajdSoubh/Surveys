<?php

namespace App\Events;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use App\Models\Survey;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveySubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    private $latestSubmission;

    /**
     * The owner of submitted survey
     */
    private $userID;

    public function __construct(Submission $submission)
    {
        $this->latestSubmission = $submission;
        $this->userID = $submission->survey->user->id;
    }
    public function broadcastWith()
    {
        return ['submission' => new SubmissionResource($this->latestSubmission)];
    }
    public function broadcastAs()
    {
        return 'SurveySubmitted';
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
