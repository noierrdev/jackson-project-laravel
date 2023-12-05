<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementListner
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
    public function handle(AchievementUnlocked $event): void
    {
        //
        $user= $event->user;
        $numberOfComments= $user->comments()->count();
        $numberOfWatched= $user->watched()->count();

        $numberOfAchievementsFromComments= 0;
        if($numberOfComments>=20) $numberOfAchievementsFromComments= 5;
        else if($numberOfComments>=10) $numberOfAchievementsFromComments= 4;
        else if($numberOfComments>=5) $numberOfAchievementsFromComments= 3;
        else if($numberOfComments>=3) $numberOfAchievementsFromComments= 2;
        else if($numberOfComments>=1) $numberOfAchievementsFromComments= 1;

        $numberOfAchievementsFromWatched= 0;
        if($numberOfWatched>=50) $numberOfAchievementsFromWatched= 5;
        else if($numberOfWatched>=25) $numberOfAchievementsFromWatched= 4;
        else if($numberOfWatched>=10) $numberOfAchievementsFromWatched= 3;
        else if($numberOfWatched>=5) $numberOfAchievementsFromWatched= 2;
        else if($numberOfWatched>=1) $numberOfAchievementsFromWatched= 1;

        $numberOfTotalAchievements= $numberOfAchievementsFromWatched + $numberOfAchievementsFromComments;

        if($numberOfTotalAchievements==4) event(new BadgeUnlocked("Intermediate: 4 Achievements",$user));
        if($numberOfTotalAchievements==8) event(new BadgeUnlocked("Advanced: 8 Achievements",$user));
        if($numberOfTotalAchievements==10) event(new BadgeUnlocked("Master: 10 Achievements",$user));

    }
}
