<?php

namespace App\Console\Commands;

use App\Mapset;
use Illuminate\Console\Command;

class UpdateBeatmapsetInfo extends Command
{
    protected $signature = 'mapset:update';
    protected $description = 'Update ranked statuses and metadata of all approved mapsets';

    public function handle()
    {
        $mapsets = Mapset::where('approved', true)->where('deleted', false)->get();

        $bar = $this->output->createProgressBar(count($mapsets));
        $bar->start();

        foreach ($mapsets as $mapset) {
            $mapset->updateOnline();

            $bar->advance();
        }

        $bar->finish();
    }
}
