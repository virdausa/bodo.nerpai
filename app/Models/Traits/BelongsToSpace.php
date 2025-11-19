<?php

// app/Models/Traits/BelongsToSpace.php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait BelongsToSpace
{
    protected static function bootBelongsToSpace()
    {
        static::retrieved(function ($model) {
            $user = Auth::user();
            if (!$user) return; // skip kalau belum login

            $player = $user->player;
            $space_id = $model->space_id ?? null;

            if (
                $space_id && 
                !$player->spacesWithDescendants()->where('id', $space_id)->first()) {
                abort(403, 'Unauthorized access to this space.');
            }
        });
    }
}
