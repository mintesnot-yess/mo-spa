/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Columns timeline example
 *
 *  Demo JS code for columns timeline chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsColumnsTimeline = function() {

    //
    // Setup module components
    //

    // Columns timeline chart
    var _columnsTimelineExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var columns_timeline_element = document.getElementById('columns_timeline');

        //
        // Charts configuration
        //

        if (columns_timeline_element) {

            // Initialize chart
            var columns_timeline = echarts.init(columns_timeline_element, null, { renderer: 'svg' });

            // Fetch data from the server
            fetch('/admin/chart-data')
                .then(response => response.json())
                .then(data => {

                    // Define options with fetched data
                    var options = {
                        // Setup timeline
                        timeline: {
                            axisType: 'category',
                            data: Object.keys(data.dataGDP),
                            left: 0,
                            right: 0,
                            bottom: 0,
                            label: {
                                fontSize: 12
                            },
                            lineStyle: {
                                color: 'var(--gray-200)'
                            },
                            checkpointStyle: {
                                color: 'var(--primary)',
                                borderColor: 'var(--primary)'
                            },
                            progress: {
                                label: {
                                    fontSize: 12
                                },
                                lineStyle: {
                                    color: 'var(--primary)'
                                }
                            },
                            autoPlay: true,
                            playInterval: 3000
                        },

                        // Config
                        options: Object.keys(data.dataGDP).map(year => ({
                            // Global text styles
                            textStyle: {
                                fontFamily: 'var(--body-font-family)',
                                color: 'var(--body-color)',
                                fontSize: 14,
                                lineHeight: 22,
                                textBorderColor: 'transparent'
                            },

                            // Chart animation duration
                            animationDuration: 750,

                            // Setup grid
                            grid: {
                                left: 10,
                                right: 10,
                                top: 35,
                                bottom: 60,
                                containLabel: true
                            },

                            // Add legend
                            legend: {
                                data: ['GDP', 'Financial', 'Real Estate'],
                                itemHeight: 8,
                                itemGap: 30,
                                textStyle: {
                                    color: 'var(--body-color)'
                                }
                            },

                            // Tooltip
                            tooltip: {
                                trigger: 'axis',
                                className: 'shadow-sm rounded',
                                backgroundColor: 'var(--white)',
                                borderColor: 'var(--gray-400)',
                                padding: 15,
                                textStyle: {
                                    color: '#000'
                                },
                                axisPointer: {
                                    type: 'shadow',
                                    shadowStyle: {
                                        color: 'rgba(var(--body-color-rgb), 0.025)'
                                    }
                                }
                            },

                            // Horizontal axis
                            xAxis: [{
                                type: 'category',
                                data: ['Paris', 'Budapest', 'Prague', 'Madrid', 'Amsterdam', 'Berlin', 'Bratislava', 'Munich', 'Hague', 'Rome'],
                                axisLabel: {
                                    color: 'rgba(var(--body-color-rgb), .65)'
                                },
                                axisLine: {
                                    lineStyle: {
                                        color: 'var(--gray-500)'
                                    }
                                },
                                splitLine: {
                                    show: true,
                                    lineStyle: {
                                        color: 'var(--gray-300)',
                                        type: 'dashed'
                                    }
                                },
                                splitArea: {
                                    show: true,
                                    areaStyle: {
                                        color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                                    }
                                }
                            }],

                            // Vertical axis
                            yAxis: [
                                {
                                    type: 'value',
                                    name: 'GDP（million)',
                                    max: 53500,
                                    axisLabel: {
                                        color: 'rgba(var(--body-color-rgb), .65)'
                                    },
                                    axisLine: {
                                        lineStyle: {
                                            color: 'var(--gray-500)'
                                        }
                                    },
                                    splitLine: {
                                        show: true,
                                        lineStyle: {
                                            color: 'var(--gray-300)'
                                        }
                                    }
                                },
                                {
                                    type: 'value',
                                    name: 'Other（million)',
                                    axisLabel: {
                                        color: 'rgba(var(--body-color-rgb), .65)'
                                    },
                                    axisLine: {
                                        lineStyle: {
                                            color: 'var(--gray-500)'
                                        }
                                    },
                                    splitLine: {
                                        show: true,
                                        lineStyle: {
                                            color: 'var(--gray-200)'
                                        }
                                    }
                                }
                            ],

                            // Add series
                            series: [
                                {
                                    name: 'Test 1',
                                    type: 'bar',
                                    itemStyle: {
                                        barBorderRadius: [4, 4, 0, 0]
                                    },
                                    markLine: {
                                        symbol: ['arrow', 'none'],
                                        symbolSize: [4, 2],
                                        itemStyle: {
                                            normal: {
                                                lineStyle: { color: 'orange' },
                                                barBorderColor: 'orange',
                                                label: {
                                                    position: 'start',
                                                    formatter: function (params) {
                                                        return Math.round(params.value);
                                                    },
                                                    textStyle: { color: 'orange' }
                                                }
                                            }
                                        },
                                        data: [{ type: 'average', name: 'Average' }]
                                    },
                                    data: data.dataGDP[year]
                                },
                                {
                                    name: 'Test 2',
                                    yAxisIndex: 1,
                                    type: 'bar',
                                    itemStyle: {
                                        barBorderRadius: [4, 4, 0, 0]
                                    },
                                    data: data.dataFinancial[year]
                                },
                                {
                                    name: 'Test 3',
                                    yAxisIndex: 1,
                                    type: 'bar',
                                    itemStyle: {
                                        barBorderRadius: [4, 4, 0, 0]
                                    },
                                    data: data.dataEstate[year]
                                }
                            ]
                        }))
                    };

                    // Set chart options
                    columns_timeline.setOption(options);

                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            columns_timeline_element && columns_timeline.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
            });
        }

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _columnsTimelineExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsColumnsTimeline.init();
});
