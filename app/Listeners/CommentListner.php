<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentListner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWritten $event): void
    {
        //
        $user= $event->user;
        $numberOfComments= $user->comments()->count();
        if($numberOfComments==1) event(new AchievementUnlocked("First Comment Written",$user));
        else if($numberOfComments==3) event(new AchievementUnlocked("3 Comments Written",$user));
        else if($numberOfComments==5) event(new AchievementUnlocked("5 Comments Written",$user));
        else if($numberOfComments==10) event(new AchievementUnlocked("10 Comments Written",$user));
        else if($numberOfComments==20) event(new AchievementUnlocked("20 Comments Written",$user));
    }
}
