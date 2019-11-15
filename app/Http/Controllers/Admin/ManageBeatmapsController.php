<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Mapset;
use Auth;
use Cache;
use Illuminate\Http\Request;
use OsuApi;

class ManageBeatmapsController extends Controller
{
    public function approve(Request $request)
    {
        $beatmap = Mapset::find($request->beatmap_id);
        $beatmap->approved = true;
        $beatmap->deleted = false;
        $beatmap->save();

        Event::log('Approved beatmap '.$beatmap->beatmapset_artist.' - '.$beatmap->beatmapset_title);
    }

    public function delete(Request $request)
    {
        $beatmap = Mapset::find($request->beatmap_id);
        $beatmap->approved = false;
        $beatmap->deleted = true;
        $beatmap->save();

        Event::log('Refused beatmap '.$beatmap->beatmapset_artist.' - '.$beatmap->beatmapset_title);
    }

    public function index()
    {
        $beatmapsDeleted = mapset::where('deleted', 1)->get();
        $beatmapsNotApproved = Mapset::where('deleted', 0)->where('approved', 0)->get();

        return view('admin.beatmaps')
            ->with('beatmapsDeleted', $beatmapsDeleted)
            ->with('beatmapsNotApproved', $beatmapsNotApproved);
    }

    public function restore(Request $request)
    {
        $beatmap = Mapset::find($request->beatmap_id);
        $beatmap->approved = true;
        $beatmap->deleted = false;
        $beatmap->save();

        Event::log('Restored beatmap '.$beatmap->beatmapset_artist.' - '.$beatmap->beatmapset_title);
    }

    public function forumExport()
    {
        static $rankedStatusCacheTime = 240; // 4 hours

        $bbcode = '';
        $mapsets = Mapset::where('approved', true)->get();

        foreach (Mapset::MODES as $mode) {
            $mapsForMode = $mapsets->where($mode, true);

            if (count($mapsForMode) === 0) {
                continue;
            }

            $bbcode .= "$mode!\n[list=1]\n";

            foreach ($mapsForMode as $set) {
                $bbcode .= "[*][url=https://osu.ppy.sh/beatmapsets/$set->beatmapset_osu_id]$set->beatmapset_artist - $set->beatmapset_title[/url] ([url=https://osu.ppy.sh/users/$set->osu_user_id]$set->beatmapset_creator[/url])";

                $rankedStatus = Cache::remember("ranked-status:$set->beatmapset_osu_id", $rankedStatusCacheTime, function () use ($set) {
                    return OsuApi::getBeatmapset($set->beatmapset_osu_id)[0]->approved;
                });

                switch (Mapset::RANKED_STATUSES[$rankedStatus]) {
                    case 'ranked':
                    case 'approved':
                        $bbcode .= ' [b]RANKED[/b]';
                        break;
                    case 'qualified':
                        $bbcode .= ' [b]QUALIFIED[/b]';
                        break;
                    case 'loved':
                        $bbcode .= ' [b]LOVED[/b]';
                        break;
                }

                $bbcode .= "\n";
            }

            $bbcode .= "[/list]\n";
        }

        return response($bbcode)->header('Content-Type', 'text/plain');
    }
}
