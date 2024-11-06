// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");

// Colors array with a sufficient number of colors
var colors = ['#007bff', '#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d', '#6610f2'];

// Slice the colors array to match the length of pieChartNames
var backgroundColors = colors.slice(0, pieChartNames.length);

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: pieChartNames,
    datasets: [{
      data: pieChartPercentages,
      backgroundColor: backgroundColors,
    }],
  },
});
