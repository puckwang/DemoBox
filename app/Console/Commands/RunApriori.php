<?php

namespace App\Console\Commands;

use App\AprioriResult;
use App\Services\AprioriService;
use Illuminate\Console\Command;
use Phpml\Association\Apriori;

class RunApriori extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'puck:run-apriori {--l|long : 常資料集}
                                             {--s|support=0.075 : 最小支持度}
                                             {--c|confidence=0.075 : 最小可信度}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Apriori associator.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('開始執行...');
        $support = $this->option('support');
        $confidence = $this->option('confidence');
        $associator = new Apriori($support, $confidence);
        $aprioriService = (new AprioriService());

        if ($this->option('long')) {
            $aprioriService->changeDataSet();
        }

        $aprioriService->reviseData();
        $associator->train($aprioriService->getDataSet(), []);

        if ($this->option('long')) {
            AprioriResult::put(json_encode([
                    'rules' => $associator->getRules(),
                    'hfs'   => $associator->apriori()
            ]), 2);
        } else {
            AprioriResult::put(json_encode([
                'rules' => $associator->getRules(),
                'hfs'   => $associator->apriori()
            ]));
        }
        $this->info('執行結束...');
    }
}
