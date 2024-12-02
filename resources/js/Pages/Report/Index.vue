<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h1 class="text-2xl font-bold">Relatórios</h1>
                    <div class="grid grid-cols-12 gap-4">

                        <!-- Chart for Bookings by Stage -->
                        <div class="col-span-12">
                            <h2 class="text-xl font-semibold">Agendamentos / estagio</h2>
                            <BarChart :chart-data="stageData" v-if="stageData" />
                        </div>

                        <!-- Chart for Bookings by Carrier -->
                        <div class="col-span-12">
                            <h2 class="text-xl font-semibold">Agendamentos / Transportadora</h2>
                            <BarChart :chart-data="carrierData" v-if="carrierData" />
                        </div>

                        <!-- Chart for Bookings by Vehicle -->
                        <div class="col-span-12">
                            <h2 class="text-xl font-semibold">Agendamentos / veiculo</h2>
                            <BarChart :chart-data="vehicleData" v-if="vehicleData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import axios from 'axios';
import BarChart from '@/Components/BarChart.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    components: { BarChart },
    data() {
        return {
            stageData: null,
            carrierData: null,
            vehicleData: null,
        };
    },
    methods: {
        async fetchData() {
            try {
                // Fetch data from the backend
                const [stageRes, carrierRes, vehicleRes] = await Promise.all([
                    axios.get(route('reports.getBookingsByStage')),
                    axios.get(route('reports.getBookingsByCarrier')),
                    axios.get(route('reports.getBookingsByVehicle')),
                ]);

                // Transform data for Chart.js
                this.stageData = this.formatChartData(stageRes.data, 'Estágio');
                this.carrierData = this.formatChartData(carrierRes.data, 'Transportadora');
                this.vehicleData = this.formatChartData(vehicleRes.data, 'Veiculo');
                console.log(this.stageData);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        formatChartData(data, labelPrefix) {
            // Ensure the data is in the correct format
            const labels = data.map(item => `${item.stage_desc || item.carrier_name || item.vehicle_placa}`);
            const dataset = data.map(item => item.total);

            return {
                labels: labels,  // Stage/Carrier/Vehicle labels
                datasets: [
                    {
                        label: `${labelPrefix}`,  // Dynamic label based on the data type
                        data: dataset,  // Total data
                        backgroundColor: '#4A90E2',  // Bar color
                    }
                ]
            };
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>

<style scoped>
.bar-chart {
    max-width: 600px;
    margin: 0 auto;
}
</style>
