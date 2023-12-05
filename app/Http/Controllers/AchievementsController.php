<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $numberOfWatched= $user->watched()->count();
        $numberOfComments= $user->comments()->count();

        $numberOfAchievements=0;

        //start from empty array
        $unlockedAchievements=[];
        $nextAvailableAchievements=[];

        //from beginning, next step was set
        $nextAchievementFromComments="First Comment Written";
        $nextAchievementFromWatched="First Lesson Watched";

        ///////////////////////
        if($numberOfWatched>=1) {
            $unlockedAchievements[]="First Lesson Watched";
            $nextAchievementFromWatched="5 Lessons Watched";
            $numberOfAchievements++;
        }
        if($numberOfComments>=1) {
            $unlockedAchievements[]="First Comment Written";
            $nextAchievementFromComments="3 Comments Written";
            $numberOfAchievements++;
        }
        ///////////////////
        if($numberOfWatched>=5) {
            $unlockedAchievements[]="5 Lessons Watched";
            $nextAchievementFromWatched="10 Lessons Watched";
            $numberOfAchievements++;
        }
        if($numberOfComments>=3) {
            $unlockedAchievements[]="3 Comments Written";
            $nextAchievementFromComments="5 Comments Written";
            $numberOfAchievements++;
        }
        //////////////////////////
        if($numberOfWatched>=10) {
            $unlockedAchievements[]="10 Lessons Watched";
            $nextAchievementFromWatched="25 Lessons Watched";
            $numberOfAchievements++;
        }
        if($numberOfComments>=5) {
            $unlockedAchievements[]="5 Comments Written";
            $nextAchievementFromComments="10 Comments Written";
            $numberOfAchievements++;
        }
        /////////////////////////////
        if($numberOfWatched>=25) {
            $unlockedAchievements[]="25 Lessons Watched";
            $nextAchievementFromWatched="50 Lessons Watched";
            $numberOfAchievements++;
        }
        if($numberOfComments>=10) {
            $unlockedAchievements[]="10 Comments Written";
            $nextAchievementFromComments="20 Comments Written";
            $numberOfAchievements++;
        }
        /////////////////
        $nextAvailableAchievements=[$nextAchievementFromComments,$nextAchievementFromWatched];

        //if there is no higher achievement, the complex logic is needed
        if($numberOfWatched>=50) {
            $unlockedAchievements[]="50 Lessons Watched";
            $numberOfAchievements++;
            $nextAchievementFromWatched="";
            $nextAvailableAchievements=[$nextAchievementFromComments];
        }

        if($numberOfComments>=20) {
            $unlockedAchievements[]="20 Comments Written";
            $numberOfAchievements++;
            if($nextAchievementFromWatched=="") $nextAvailableAchievements=[];
            $nextAvailableAchievements=[$nextAchievementFromWatched];
        }

        // start to get current badge, next badge, remaining achievements to next badge
        //initialization
        $currentBadge="Beginner: 0 Achievements";
        $nextBadge="Intermediate: 4 Achievements";
        $remainToUnlockNextBadge=4;

        if($numberOfAchievements>=4) {
            $currentBadge="Intermediate: 4 Achievements";
            $nextBadge="Advanced: 8 Achievements";
        }
        if($numberOfAchievements>=8) {
            $currentBadge="Advanced: 8 Achievements";
            $nextBadge="Master: 10 Achievements";
            $remainToUnlockNextBadge=2;
        }
        if($numberOfAchievements>=10) {
            $currentBadge="Master: 10 Achievements";
            $nextBadge="";
            $remainToUnlockNextBadge=0;
        }


        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaing_to_unlock_next_badge' => $remainToUnlockNextBadge
        ]);
    }
}
