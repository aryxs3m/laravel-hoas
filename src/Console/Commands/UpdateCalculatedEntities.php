<?php

namespace Aryxs3m\LaravelHoas\Console\Commands;

use Aryxs3m\LaravelHoas\Services\HomeAssistantService;
use Illuminate\Console\Command;

class UpdateCalculatedEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoas:update-calculated-entities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates calculated entities and publish their state.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(HomeAssistantService $service): void
    {
        $service->updateCalculatedEntities();
        $this->info('Updated calculated entities!');
    }
}
