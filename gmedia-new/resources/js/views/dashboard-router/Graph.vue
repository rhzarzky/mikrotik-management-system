<template>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <div class="container">
            <v-btn color="primary" small class="mt-2">
            <v-progress-circular
              indeterminate
              size="16" 
              class="mr-2"
              color="#FFFFFF"
            ></v-progress-circular>
            Data Realtime
          </v-btn>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="card">
                <div id="graph"></div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <td>
                        <VSelect
                          label="Interface"
                          v-model="selectedInterface"
                          item-text="name"
                          @change="changeInterface"
                          class="form-control"
                          :items="dataInterfaces.map(item => item.name)"
                          style="min-width: 200px;"
                          >
                        </VSelect>
                    </td>
                      <td>
                        <v-text-field
                        v-model="formattedTX"
                        label="Upload (TX)"
                        readonly
                        class="form-control"
                        style="min-width: 200px;"
                      />
                      </td>
                      <td>
                        <v-text-field
                        v-model="formattedRX"
                        label="Download (RX)"
                        readonly
                        class="form-control"
                        style="min-width: 200px;"
                      />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Highcharts from 'highcharts';
  import { computed, watch, onBeforeUnmount, onMounted } from 'vue';
  import { useTheme } from 'vuetify';
  
  export default {
    setup() {
      const vuetifyTheme = useTheme();
      const backgroundColor = computed(() => {
        return vuetifyTheme.global.name === 'light' ? '#FFFFFF' : '#312D4B';
      });
  
      return { vuetifyTheme, backgroundColor };
    },
    data() {
      return {
        dataInterfaces: [],
        selectedInterface: null,
        chart: null,
        tx: 0,
        rx: 0,
        previousRxBytes: 0,
        previousTxBytes: 0,
        intervalId: null, // To store the interval ID
      };
    },
    computed: {
      formattedTX() {
        return this.convert(this.tx);
      },
      formattedRX() {
        return this.convert(this.rx);
      },
    },
    mounted() {
      this.fetchdataInterfaces();
      this.initChart();
      watch(
        () => this.$vuetify.theme.dark,
        (newVal, oldVal) => {
          if (newVal !== oldVal) {
            this.updateChartBackground();
          }
        }
      );

      // Clear interval when the component is unmounted
      onBeforeUnmount(() => {
        if (this.intervalId) {
          clearInterval(this.intervalId);
        }
      });
    },
    methods: {
      fetchdataInterfaces() {
        axios.get('/interface-show')
          .then(response => {
            console.log('Interface data:', response.data);
            this.dataInterfaces = response.data.interface.map(item => ({
                id: item['.id'],
                name: item.name,
            }));
            if (this.dataInterfaces.length > 0) {
              this.selectedInterface = this.dataInterfaces[0].name;
              this.updateTraffic(this.selectedInterface);
            }
          })
          .catch(error => {
            console.error("Error fetching dataInterfaces:", error);
            window.location.href = '/router';
          });
      },
      changeInterface() {
        this.previousRxBytes = 0;
        this.previousTxBytes = 0;
        this.updateTraffic(this.selectedInterface);
      },
      updateTraffic(interfaceData) {
        if (!interfaceData) return;
  
        const currentRxBytes = parseInt(interfaceData['rx-byte']);
        const currentTxBytes = parseInt(interfaceData['tx-byte']);
        const deltaTime = 1; // in seconds
  
        // Ensure previous bytes are initialized properly
        if (this.previousRxBytes === 0 || this.previousTxBytes === 0) {
          this.previousRxBytes = currentRxBytes;
          this.previousTxBytes = currentTxBytes;
          return;
        }
  
        // Calculate speed in bps
        const rxSpeedBps = Math.max(((currentRxBytes - this.previousRxBytes) * 8) / deltaTime, 0);
        const txSpeedBps = Math.max(((currentTxBytes - this.previousTxBytes) * 8) / deltaTime, 0);
  
        this.tx = txSpeedBps;
        this.rx = rxSpeedBps;
  
        this.previousRxBytes = currentRxBytes;
        this.previousTxBytes = currentTxBytes;
  
        const x = (new Date()).getTime();
        const shift = this.chart.series[0].data.length > 19;
        this.chart.series[0].addPoint([x, this.tx], true, shift);
        this.chart.series[1].addPoint([x, this.rx], true, shift);
      },
      initChart() {
        Highcharts.setOptions({
          global: {
            useUTC: false,
          },
        });
  
        this.chart = Highcharts.chart('graph', {
          chart: {
            type: 'spline',
            backgroundColor: this.backgroundColor.value, // Set initial background color
            events: {
              load: () => {
                this.intervalId = setInterval(() => {
                  if (this.selectedInterface) {
                    axios.get('/interface-show')
                      .then(response => {
                        const interfaceData = response.data.interface.find(i => i.name === this.selectedInterface);
                        this.updateTraffic(interfaceData);
                      })
                      .catch(error => {
                        console.error("Error updating traffic data:", error);
                        window.location.href = '/router';
                      });
                  }
                }, 1000);
              },
            },
          },
          title: {
            text: 'Monitoring',
            style: {
              color: '#25BE33',
            },
          },
          xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000,
            labels: {
              style: {
                color: '#25BE33', 
              },
            },
          },
          yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
              text: 'Traffic',
              style: {
                color: '#25BE33',
              },
            },
            labels: {
              style: {
                color: '#25BE33',
              },
              formatter: function () {
                const bytes = this.value;
                const sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                if (bytes === 0) return '0 bps';
                const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
              },
            },
          },
          series: [
            {
              name: 'TX',
              data: [],
            },
            {
              name: 'RX',
              data: [],
            },
          ],
          tooltip: {
            headerFormat: '<b>{series.name}</b><br/>',
            pointFormat: '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y}',
          },
        });
      },
      updateChartBackground() {
        this.chart.update({
          chart: {
            backgroundColor: this.backgroundColor.value,
          },
        });
      },
      convert(bytes) {
        const sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
        if (bytes === 0) return '0 bps';
        const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
      },
    },
  };
  </script>
  
  <style>
  .table-responsive .table th,
  .table-responsive .table td {
    padding: 0.5rem; /* Adjust padding as needed */
  }
  
  .table-responsive .table th {
    text-align: center; /* Center-align the headers */
  }
  
  .table-responsive .table td {
    text-align: center; /* Center-align the cells */
  }
  
  .select-interface {
    margin-bottom: 1rem; /* Adjust margin as needed */
  }

  .custom-select {
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.custom-select:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

  </style>
