<template>
    <div class="bar-chart">
      <canvas ref="canvas"></canvas>
    </div>
  </template>

  <script>
  import { Chart } from 'chart.js/auto';

  export default {
    props: {
      chartData: {
        type: Object,
        required: true,
      },
    },
    mounted() {
      this.renderChart();
    },
    methods: {
        renderChart() {
  new Chart(this.$refs.canvas, {
    type: 'bar',
    data: this.chartData,  // Data (can also use this.carrierData or this.vehicleData)
    options: {
      responsive: true,
      maintainAspectRatio: false,  // Chart will resize dynamically
      animation: {
        duration: 1000,
        easing: 'easeInOutQuad',
      },
      plugins: {
        legend: {
          display: true,
          position: 'top',
          labels: {
            boxWidth: 20,
            padding: 15,
            font: {
              family: 'Poppins, sans-serif',  // Modern font
              size: 16,
            },
          },
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.7)',
          titleColor: '#fff',
          bodyColor: '#fff',
          callbacks: {
            label: (tooltipItem) => {
              return `${tooltipItem.label}: ${tooltipItem.raw}`;
            },
          },
        },
        datalabels: {
          color: '#fff',
          font: {
            weight: 'bold',
            size: 14,
          },
          anchor: 'end',
          align: 'top',
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            // Display as integers
            stepSize: 1,
          },
          // Add custom Y-axis label
          title: {
            display: true,
            text: 'Total',  // The custom label text
            font: {
              family: 'Poppins, sans-serif',  // Modern font
              size: 16,
              weight: 'bold',
            },
          },
        },
      },
    },
  });
},

    },
  };
  </script>

  <style scoped>
  .bar-chart {
    width: 100%;
    height: auto;
  }
  </style>
