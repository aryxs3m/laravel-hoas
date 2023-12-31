<?php

namespace Aryxs3m\LaravelHoas\Console\Commands;

use Aryxs3m\LaravelHoas\Services\HomeAssistantService;
use Illuminate\Console\Command;

class MqttListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoas:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run MQTT listener for 1 minute. This will also publish your devices.';

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle(HomeAssistantService $service): void
    {
        $this->info('MQTT Listener starting...');
        $service->startListenLoop();
        $this->info('MQTT Listener stopped.');
    }
}
