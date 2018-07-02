<?php

namespace App\Http\Controllers;

use App\AprioriResult;
use App\Services\AprioriService;
use Illuminate\Http\Request;

class AprioriController extends Controller
{
    private $orderBy = "support";

    private $direct = "DESC";

    /**
     * 需執行: puck:run-apriori
     */

    public function cmp($a, $b)
    {
        if ($this->direct === "ASC") {
            return $a[$this->orderBy] > $b[$this->orderBy] ? 1 : -1;
        }

        return $a[$this->orderBy] > $b[$this->orderBy] ? -1 : 1;
    }

    public function index(Request $request)
    {
        $type = $request->input('type', 'short');
        $data = json_decode(AprioriResult::pull($type === "short" ? 1 : 2), true);
        $rules = $data['rules'];
        $hfs = $data['hfs'];
        usort($rules, [$this, 'cmp']);

        $predict = $request->input('predict', null);
        $predictResult = [];
        if ($predict) {
            $aprioriService = (new AprioriService());
            $aprioriService->rules = $rules;
            $predictResult = $aprioriService->predict($predict);
        }

        return view('apriori.index', [
            'type'          => $type,
            'rules'         => $rules,
            'hfs'           => $hfs,
            'length'        => count($rules),
            'predict'       => $predict,
            'predictResult' => $predictResult,
        ]);
    }
}
