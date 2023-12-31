<?php

namespace Aryxs3m\LaravelHoas\Console\Commands;

use Aryxs3m\LaravelHoas\Services\HomeAssistantService;
use Illuminate\Console\Command;

class PublishDevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoas:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish devices to Home Assistant';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(HomeAssistantService $service): void
    {
        $service->publishDevices();
        $this->info('Devices published!');
    }
}
