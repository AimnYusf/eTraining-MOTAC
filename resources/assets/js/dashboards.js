/**
 * Dashboard CRM
 */

'use strict';
(function () {
  let cardColor, labelColor, headingColor, shadeColor, legendColor, borderColor, barBgColor;
  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
    headingColor = config.colors_dark.headingColor;
    barBgColor = '#3d4157';
    shadeColor = 'dark';
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
    headingColor = config.colors.headingColor;
    barBgColor = '#efeef0';
    shadeColor = '';
  }

  // Earning Reports Tabs Function
  function EarningReportsBarChart(arrayData, highlightData) {
    const basicColor = config.colors_label.primary,
      highlightColor = config.colors.primary;
    var colorArr = [];

    for (let i = 0; i < arrayData.length; i++) {
      if (i === highlightData) {
        colorArr.push(highlightColor);
      } else {
        colorArr.push(basicColor);
      }
    }

    const earningReportBarChartOpt = {
      chart: {
        height: 231,
        parentHeightOffset: 0,
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          columnWidth: '32%',
          startingShape: 'rounded',
          borderRadius: 6,
          distributed: true,
          dataLabels: {
            position: 'top'
          }
        }
      },
      grid: {
        show: false,
        padding: {
          top: 0,
          bottom: 0,
          left: -10,
          right: -10
        }
      },
      colors: colorArr,
      dataLabels: {
        enabled: true,
        offsetY: -30,
        style: {
          fontSize: '15px',
          colors: [headingColor],
          fontWeight: '500',
          fontFamily: 'Public Sans'
        }
      },
      series: [
        {
          data: arrayData
        }
      ],
      legend: {
        show: false
      },
      tooltip: {
        enabled: false
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dis'],
        axisBorder: {
          show: true,
          color: borderColor
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '13px',
            fontFamily: 'Public Sans'
          }
        }
      },
      yaxis: {
        labels: {
          offsetX: -15,
          formatter: function (val) {
            return parseInt(val / 1);
          },
          style: {
            fontSize: '13px',
            colors: labelColor,
            fontFamily: 'Public Sans'
          },
          min: 0,
          max: 60000,
          tickAmount: 6
        }
      },
      responsive: [
        {
          breakpoint: 1441,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '41%'
              }
            }
          }
        },
        {
          breakpoint: 590,
          options: {
            plotOptions: {
              bar: {
                columnWidth: '61%',
                borderRadius: 5
              }
            },
            yaxis: {
              labels: {
                show: false
              }
            },
            grid: {
              padding: {
                right: 0,
                left: -20
              }
            },
            dataLabels: {
              style: {
                fontSize: '12px',
                fontWeight: '400'
              }
            }
          }
        }
      ]
    };
    return earningReportBarChartOpt;
  }

  // Init Chart
  // --------------------------------------------------------------------
  // const data = [60, 50, 20, 45, 50, 30, 70, 50, 60, 80, 100, 20];

  const data = [
    // Year 1
    [3, 7, 6, 4, 5, 8, 10, 0, 6, 4, 3, 0],
    // Year 2
    [2, 4, 5, 6, 7, 9, 8, 10, 6, 5, 4, 7],
    // Year 3
    [1, 3, 4, 5, 7, 8, 9, 10, 6, 4, 2, 5],
    // Year 4
    [5, 6, 7, 8, 6, 5, 4, 7, 8, 9, 10, 6],
    // Year 5
    [6, 7, 5, 8, 7, 6, 10, 9, 8, 7, 6, 5],
    // Year 6
    [3, 4, 6, 7, 8, 10, 9, 7, 6, 5, 4, 3],
    // Year 7
    [2, 3, 4, 5, 6, 7, 8, 9, 10, 8, 6, 4]
  ];

  const earningReportsTabsOrdersEl = document.querySelector('#earningReportsTabsOrders'),
    earningReportsTabsOrdersConfig = EarningReportsBarChart(data[0], data[0].indexOf(Math.max(...data[0])));

  if (typeof earningReportsTabsOrdersEl !== undefined && earningReportsTabsOrdersEl !== null) {
    const earningReportsTabsOrders = new ApexCharts(earningReportsTabsOrdersEl, earningReportsTabsOrdersConfig);
    earningReportsTabsOrders.render();
  }
})();
