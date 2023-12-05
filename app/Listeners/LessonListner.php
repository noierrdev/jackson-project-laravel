<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LessonListner
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
    public function handle(LessonWatched $event): void
    {
        //
        $user= $event->user;
        $numberOfWatched= $user->watched()->count();
        if($numberOfWatched==1) event(new AchievementUnlocked("First Lesson Watched",$user));
        else if($numberOfWatched==5) event(new AchievementUnlocked("5 Lessons Watched",$user));
        else if($numberOfWatched==10) event(new AchievementUnlocked("10 Lessons Watched",$user));
        else if($numberOfWatched==25) event(new AchievementUnlocked("25 Lessons Watched",$user));
        else if($numberOfWatched==50) event(new AchievementUnlocked("50 Lessons Watched",$user));
    }
}
