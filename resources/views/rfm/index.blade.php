@extends('layout.main')

@section('head')

@endsection

@section('title')
    RFM Chart
@endsection

@section('content')
    <div class="card bg-light mb-3">
        <div class="card-header">Chart 1</div>
        <div class="card-body">
            <div class="chart1"></div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script>
        var width = 960;
        var height = 500;
        var margin = {left: 80, right: 80, top: 80, bottom: 80};
        var innerWidth = width - margin.left - margin.right;
        var innerHeight = height - margin.top - margin.bottom;

        var data = [];

        for (var i = 1; i <= 5; i++) {
            for (var j = 1; j <= 5; j++) {
                data.push([i, j, Math.random(), Math.random()]);
            }
        }

        var xScale = d3.scaleLinear().range([0, innerWidth])
            .domain([0, 6]);
        var yScale = d3.scaleLinear()
            .range([innerHeight, 0])
            .domain([0, 6]);

        var svg = d3.select(".chart1").append("svg")
            .attr("width", width)
            .attr("height", height)

        var g = svg.append('g')
            .attr('transform', "translate(" + margin.left + "," + margin.top + ")")
            .attr('width', innerWidth)
            .attr('height', innerHeight)

        var xAxis = d3.axisBottom()
            .scale(xScale)
            .tickValues([1, 2, 3, 4, 5])
            .ticks(10)
            .tickPadding(15);

        var yAxis = d3.axisLeft()
            .scale(yScale)
            .tickValues([1, 2, 3, 4, 5])
            .ticks(10)
            .tickPadding(15);

        var xAxisG = g.append('g')
            .attr("transform", "translate(0," + innerHeight + ")");

        var yAxisG = g.append('g');

        var color = d3.scaleLinear()
            .domain([0, 0.2, 0.4, 0.6, 1])
            .range(['green', '#ffef42', '#ffc33f', 'red']);

        g.selectAll('circle')
            .data(data)
            .enter().append('svg:circle')
            .attr('cx', function (d, i) {
                return xScale(d[0]);
            })
            .attr('cy', function (d) {
                return yScale(d[1]);
            })
            .attr('r', function (d) {
                return 30 * d[3];
            })
            .attr("fill", function (d) {
                return color(d[2]);
            });

        xAxisG.attr("class", "axis").call(xAxis);
        yAxisG.attr("class", "axis").call(yAxis);
    </script>
@endsection