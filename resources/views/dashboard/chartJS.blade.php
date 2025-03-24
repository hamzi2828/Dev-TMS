<script type="text/javascript">
    
    ( function () {
        // Color Variables
        const purpleColor      = '#836AF9',
              yellowColor      = '#ffe800',
              cyanColor        = '#28dac6',
              orangeColor      = '#FF8132',
              orangeLightColor = '#FDAC34',
              oceanBlueColor   = '#299AFF',
              greyColor        = '#4F5D70',
              greyLightColor   = '#EDF1F4',
              blueColor        = '#2B9AFF',
              blueLightColor   = '#84D0FF';
        
        const chartColors = {
            donut: {
                series1: config.colors.success,
                series2: '#28c76fb3',
                series3: '#28c76f80',
                series4: config.colors_label.success
            }
        };
        
        let cardColor,
            headingColor,
            labelColor,
            borderColor,
            legendColor;
        
        if ( isDarkStyle ) {
            cardColor    = config.colors_dark.cardColor;
            headingColor = config.colors_dark.headingColor;
            labelColor   = config.colors_dark.textMuted;
            legendColor  = config.colors_dark.bodyColor;
            borderColor  = config.colors_dark.borderColor;
        }
        else {
            cardColor    = config.colors.cardColor;
            headingColor = config.colors.headingColor;
            labelColor   = config.colors.textMuted;
            legendColor  = config.colors.bodyColor;
            borderColor  = config.colors.borderColor;
        }
        
        // Set height according to their data-height
        // --------------------------------------------------------------------
        const chartList = document.querySelectorAll ( '.chartjs' );
        chartList.forEach ( function ( chartListItem ) {
            chartListItem.height = chartListItem.dataset.height;
        } );
        
        // Bar Chart
        // --------------------------------------------------------------------
        const barChart = document.getElementById ( 'barChart' );
        if ( barChart ) {
            const barChartVar = new Chart ( barChart, {
                type   : 'bar',
                data   : {
                    labels  : [ {!! "'" . implode ( "', '", $banks_balances['title'] ) . "'" !!} ],
                    datasets: [
                        {
                            data           : [ {{ implode ( ",", $banks_balances['value'] ) }} ],
                            backgroundColor: [
                                orangeLightColor,
                                purpleColor,
                                blueColor,
                                cyanColor,
                                orangeColor,
                                greyColor,
                                oceanBlueColor,
                                greyLightColor,
                                blueLightColor,
                                yellowColor,
                            ],
                            borderColor    : 'transparent',
                            maxBarThickness: 15,
                            borderRadius   : {
                                topRight: 15,
                                topLeft : 15
                            }
                        }
                    ]
                },
                options: {
                    responsive         : true,
                    maintainAspectRatio: false,
                    animation          : {
                        duration: 500
                    },
                    plugins            : {
                        tooltip: {
                            rtl            : isRtl,
                            backgroundColor: cardColor,
                            titleColor     : headingColor,
                            bodyColor      : legendColor,
                            borderWidth    : 1,
                            borderColor    : borderColor
                        },
                        legend : {
                            display: false
                        }
                    },
                    scales             : {
                        x: {
                            grid : {
                                color      : borderColor,
                                drawBorder : true,
                                borderColor: borderColor
                            },
                            ticks: {
                                color: labelColor
                            }
                        },
                        y: {
                            min  : 0,
                            max  : {{ max ($banks_balances['value']) }},
                            grid : {
                                color      : borderColor,
                                drawBorder : true,
                                borderColor: borderColor
                            },
                            ticks: {
                                stepSize: 5000,
                                color   : labelColor
                            }
                        }
                    }
                }
            } );
        }
        
        const generatedLeadsChartEl     = document.querySelector ( '#generatedLeadsChart' ),
              generatedLeadsChartConfig = {
                  chart      : {
                      height            : 185,
                      width             : 185,
                      parentHeightOffset: 0,
                      type              : 'donut'
                  },
                  labels     : [ {!! "'" . implode ( "', '", $daily_cash_balances['title'] ) . "'" !!} ],
                  series     : [ {{ implode ( ",", $daily_cash_balances['value'] ) }} ],
                  colors     : [
                      orangeLightColor,
                      purpleColor,
                      blueColor,
                      cyanColor,
                      orangeColor,
                      greyColor,
                      oceanBlueColor,
                      greyLightColor,
                      blueLightColor,
                      yellowColor,
                  ],
                  stroke     : {
                      width: 0
                  },
                  dataLabels : {
                      enabled  : false,
                      formatter: function ( val, opt ) {
                          return parseInt ( val ) + '%';
                      }
                  },
                  legend     : {
                      show: false
                  },
                  tooltip    : {
                      theme: false
                  },
                  grid       : {
                      padding: {
                          top  : 15,
                          right: -20,
                          left : -20
                      }
                  },
                  states     : {
                      hover: {
                          filter: {
                              type: 'none'
                          }
                      }
                  },
                  plotOptions: {
                      pie: {
                          donut: {
                              size  : '60%',
                              labels: {
                                  show : true,
                                  value: {
                                      fontSize  : '1.375rem',
                                      fontFamily: 'Public Sans',
                                      color     : headingColor,
                                      fontWeight: 500,
                                      offsetY   : -15,
                                      formatter : function ( val ) {
                                          return parseInt ( val ) + '%';
                                      }
                                  },
                                  name : {
                                      offsetY   : 20,
                                      fontFamily: 'Public Sans'
                                  },
                                  total: {
                                      show      : true,
                                      showAlways: true,
                                      color     : config.colors.success,
                                      fontSize  : '.8125rem',
                                      label     : 'Total',
                                      fontFamily: 'Public Sans',
                                      formatter : function ( w ) {
                                          return '{{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($daily_cash_balances['sum']) }}';
                                      }
                                  }
                              }
                          }
                      }
                  },
                  responsive : [
                      {
                          breakpoint: 1025,
                          options   : {
                              chart: {
                                  height: 172,
                                  width : 160
                              }
                          }
                      },
                      {
                          breakpoint: 769,
                          options   : {
                              chart: {
                                  height: 178
                              }
                          }
                      },
                      {
                          breakpoint: 426,
                          options   : {
                              chart: {
                                  height: 147
                              }
                          }
                      }
                  ]
              };
        if ( typeof generatedLeadsChartEl !== undefined && generatedLeadsChartEl !== null ) {
            const generatedLeadsChart = new ApexCharts ( generatedLeadsChartEl, generatedLeadsChartConfig );
            generatedLeadsChart.render ();
        }
    } ) ();
</script>