<script type="text/javascript">
    let pyramidOptions = {
        series     : [
            {
                name: "",
                data: [
                    @if(count ($statuses) > 0)
                        @foreach($statuses as $key => $status)
                            {{ $status }}
                            {{ $loop -> last ? '' : ',' }}
                        @endforeach
                    @endif
                ],
            },
        ],
        chart      : {
            type  : 'bar',
            height: 350,
        },
        plotOptions: {
            bar: {
                borderRadius: 0,
                horizontal  : true,
                distributed : true,
                barHeight   : '80%',
                isFunnel    : true,
            },
        },
        colors     : [
            '#F44F5E',
            '#E55A89',
            '#D863B1',
            '#CA6CD8',
            '#B57BED',
            '#8D95EB',
            '#62ACEA',
            '#4BC3E6',
        ],
        dataLabels : {
            enabled   : true,
            formatter : function ( val, opt ) {
                return opt.w.globals.labels[ opt.dataPointIndex ]
            },
            dropShadow: {
                enabled: true,
            },
        },
        title      : {
            text : '',
            align: 'middle',
        },
        xaxis      : {
            categories: [
                @if(count ($statuses) > 0)
                    @foreach($statuses as $key => $status)
                        '{{ str () -> title (str_replace ('_', ' ', str_replace ('total_', '', $key))) }}'
                        {{ $loop -> last ? '' : ',' }}
                    @endforeach
                @endif
            ],
        },
        legend     : {
            show: true,
        },
    };
    
    let pyramidChart = new ApexCharts ( document.querySelector ( "#status-statistics" ), pyramidOptions );
    pyramidChart.render ();
</script>