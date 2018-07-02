<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
ini_set('memory_limit', '512M');
class AprioriService
{

    /**
     * 登革熱資料集
     * link:https://data.gov.tw/dataset/21026
     * link:https://data.gov.tw/dataset/21025
     */
    private $dataSetName = "dataset\Dengue_Daily_last12m.json";

    private $dataSet;

    public $rules;

    public const ARRAY_KEY_ANTECEDENT = 'antecedent';

    public const ARRAY_KEY_CONSEQUENT = 'consequent';

    public function __construct()
    {
        if (!Storage::disk('local')->exists($this->dataSetName)) {
            new \Exception("[AprioriService] 找不到資料集");
        }
    }

    public function reviseData()
    {
        $dataSet = json_decode(Storage::disk('local')->get($this->dataSetName), true);
        $this->dataSet = [];

        foreach ($dataSet as $item) {
            $data = [];
            $data[] = date('Y', strtotime($item['發病日'])) . "年";
            $data[] = date('l', strtotime($item['發病日']));
            $data[] = date('m', strtotime($item['發病日'])) . "月";
            $data[] = $item['是否境外移入'] === '是' ? $item['感染國家'] : '台灣';
            $data[] = $item['性別'] . "性";
            $data[] = $item['年齡層'] . "歲";
            $data[] = "居住" . $item['居住縣市'];

            if ($item['血清型'] !== 'None') {
                $data[] = $item['血清型'];
            }
            $this->dataSet[] = $data;
        }
    }

    public function changeDataSet()
    {
        $this->dataSetName = "dataset\Dengue_Daily.json";
    }

    /**
     * @return mixed
     */
    public function getDataSet()
    {
        return $this->dataSet;
    }

    public function predict(array $samples)
    {
        if (!is_array($samples[0])) {
            return $this->predictSample($samples);
        }

        $predicted = [];
        foreach ($samples as $index => $sample) {
            $predicted[$index] = $this->predictSample($sample);
        }

        return $predicted;
    }

    protected function predictSample(array $sample): array
    {
        $predicts = array_values(array_filter($this->rules, function ($rule) use ($sample) {
            return $this->equals($rule[self::ARRAY_KEY_ANTECEDENT], $sample);
        }));

        return array_map(function ($rule) {
            return $rule[self::ARRAY_KEY_CONSEQUENT];
        }, $predicts);
    }

    private function equals(array $set1, array $set2): bool
    {
        return array_diff($set1, $set2) == array_diff($set2, $set1);
    }
}