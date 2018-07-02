@extends('layout.main')

@section('head')

@endsection

@section('title')
    登革熱 Apriori 關聯規則分析結果 ({{ $type == "short" ? "近一年" : "1998年至今"}})
@endsection

@section('content')
    <div class="mb-3">
        <a href="?type=short" class="btn btn-primary btn-sm" role="button" aria-pressed="true">資料來源切換為前一年</a>
        <a href="?type=long" class="btn btn-primary btn-sm" role="button" aria-pressed="true">資料來源切換為西元1998年至今</a>
    </div>

    <h4>高頻項目集合</h4>
    <table class="table table-hover table-bordered">
        <tbody>
        @foreach($hfs as $key => $items)
            <tr class="table-info"><td colspan="5">＃{{ $key }} 個項目集合</td></tr>
            @foreach($items as $key => $item)
                @if ($key % 5 == 0)
                    <tr>
                @endif
                <td>{{ implode(", ", $item) }}</td>
                @if ($key % 5 == 4)
                    </tr>
                @endif
            @endforeach
        @endforeach
        </tbody>
    </table>
    <br>
    <h4>關聯</h4>
    <table class="table table-hover">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Antecedent</th>
            <th scope="col">Consequent</th>
            <th scope="col">Support</th>
            <th scope="col">Confidence</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rules as $key => $rule)
            @if ($key < $length * 0.1)
                <tr class="table-danger">
            @elseif ($key < $length * 0.25)
                <tr class="table-warning">
            @elseif ($key < $length * 0.5)
                <tr class="table-success">
            @else
                <tr>
            @endif

                <th scope="row">{{ $key + 1 }}</th>
                <td>{{ implode(",", $rule['antecedent']) }}</td>
                <td>{{ implode(",", $rule['consequent']) }}</td>
                <td>{{ round($rule['support'], 4) }}</td>
                <td>{{ round($rule['confidence'], 4) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection