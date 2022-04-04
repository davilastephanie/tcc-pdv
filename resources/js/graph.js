$.extend({
  hightchartRender: function(chartId, options) {
    Highcharts.chart(chartId, {
      credits: {
        enabled: false
      },

      title: {
        text: options.title
      },

      subtitle: {
        text: null
      },

      xAxis: {
        type: 'category'
      },

      yAxis: {
        allowDecimals: false,
        min          : 0,
        title        : {
          text  : options.yTitle,
          skew3d: true
        }
      },

      legend: {
        enabled: false
      },

      plotOptions: {
        series: {
          borderWidth: 0,
          dataLabels : {
            enabled: true,
            format : '{point.y}'
          }
        }
      },

      tooltip: {
        pointFormat: options.yTitle + ': <b>{point.y}</b>'
      },

      series: [
        {
          type        : 'column',
          colorByPoint: true,
          showInLegend: false,
          data        : options.series,
          colors      : options.colors || Highcharts.getOptions().colors
        }
      ]
    });
  },

  shuffleArray: function(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    while (0 !== currentIndex) {
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;

      temporaryValue      = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex]  = temporaryValue;
    }

    return array;
  }
});

$(function() {
  /**
   * Hightcarts
   *
   * https://www.highcharts.com/demo
   */

  $.each(window.CHARTS, function(id, chart) {
    if (!$('#' + id).length) {
      return;
    }

    var series = [];
    var colors = $.shuffleArray(Highcharts.getOptions().colors);

    console.log('colors', colors);

    $.each(chart.series, function(i, item) {
      series.push([item.label, Number(item.value)]);
    });

    $.hightchartRender(id, {
      title : chart.title,
      yTitle: chart.yTitle,
      series: series,
      colors: colors
    });
  });

});