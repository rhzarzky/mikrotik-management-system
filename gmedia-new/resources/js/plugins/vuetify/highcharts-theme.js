import Highcharts from 'highcharts';
import themes from './theme'; // Ensure this path is correct

const applyHighchartsTheme = (themeName) => {
  const theme = themes[themeName];

  Highcharts.setOptions({
    colors: [theme.colors.primary, theme.colors.secondary, theme.colors.success, theme.colors.info, theme.colors.warning, theme.colors.error],
    chart: {
      backgroundColor: theme.colors.background,
      style: {
        color: theme.colors['on-background'],
      },
    },
    title: {
      style: {
        color: theme.colors['on-background'],
      },
    },
    xAxis: {
      labels: {
        style: {
          color: theme.colors['on-background'],
        },
      },
    },
    yAxis: {
      labels: {
        style: {
          color: theme.colors['on-background'],
        },
      },
    },
    legend: {
      itemStyle: {
        color: theme.colors['on-background'],
      },
    },
  });
};

export default applyHighchartsTheme;
