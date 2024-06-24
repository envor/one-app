<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;

class TeamController extends Controller
{
    /**
     * Show the team management screen.
     *
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $teamUUID)
    {
        $team = Jetstream::newTeamModel()->where('uuid', $teamUUID)->firstOrFail();

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        return view('teams.show', [
            'user' => $request->user(),
            'team' => $team,
        ]);
    }
}
