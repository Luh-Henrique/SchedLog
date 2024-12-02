<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-screen flex flex-col">
                        <div class="container mx-auto p-4 flex-grow flex flex-col relative h-full">
                            <h1 class="text-2xl font-bold mb-4">Agendamentos</h1>

                            <!-- Create Booking Button -->
                            <button class="absolute top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded z-10"
                                @click="showCreateModal">
                                Criar agendamento
                            </button>

                            <div class="flex flex-row justify-between overflow-x-auto flex-nowrap h-screen">
                                <!-- Stage Columns -->
                                <div
                                    class="containerStage min-w-[20%] max-w-[20%] mx-1 px-1 bg-gray-100 rounded flex flex-col overflow-hidden"
                                    v-for="stage in stages"
                                    :key="stage.id">
                                    <div class="text-center my-2 font-semibold">
                                        {{ stage.desc }} ({{ bookings.filter(b => b.stage_id === stage.id).length }})
                                    </div>
                                    <div class="flex-grow overflow-y-auto max-h-[calc(100vh-64px)]">
                                        <div
                                            v-for="booking in bookings.filter(b => b.stage_id === stage.id)"
                                            @click="showBookingModal(booking)"
                                            :key="booking.id"
                                            class="border p-2 mb-2 rounded bg-white shadow cursor-pointer">
                                            <p><strong>Placa:</strong> {{ booking.vehicle?.placa ?? 'Sem Placa' }}</p>
                                            <p><strong>Transportadora:</strong> {{ booking.carrier?.name ?? 'Sem Transportadora' }}</p>
                                            <!-- <button @click="openModal(booking)" class="text-blue-500">Avançar</button> -->
                                        </div>
                                        <p
                                            v-if="!bookings.filter(b => b.stage_id === stage.id).length"
                                            class="text-gray-500 text-center">
                                            Nenhum agendamento
                                        </p>
                                    </div>
                                </div>
                            </div>




                            <!-- Create Booking Modal -->
                            <Modal class="h-full" :show="createModalVisible" @close="closeCreateModal">
                                <template v-slot>
                                    <div class="box p-4">
                                        <h2 class="text-xl">Criar agendamento</h2>
                                        <form @submit.prevent="createBooking">
                                            <div class="mb-4">
                                                <label class="block text-sm">Selecionar Data</label>
                                                <VueDatePicker teleport-center  locale="pt-BR" format="dd/MM/yyyy HH:mm" cancelText="Cancelar" selectText="Selecionar" v-model="newBooking.booking_dt" auto-apply  />
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm">Transportadora</label>
                                                <select v-model="newBooking.carrier_id" class="border rounded p-2 w-full">
                                                    <option v-for="carrier in carriers" :key="carrier.id" :value="carrier.id">
                                                        {{ carrier.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm">Placa</label>
                                                <input v-mask="'AAA#N##'" @input="newBooking.placa = newBooking.placa.toUpperCase()" type="text" class="border rounded p-2 w-full" v-model="newBooking.placa"/>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm">Tipo de Veículo</label>
                                                <select v-model="newBooking.vehicle_type_id" class="border rounded p-2 w-full">
                                                    <option v-for="vehicleType in vehicleTypes" :key="vehicleType.id" :value="vehicleType.id">
                                                        {{ vehicleType.desc }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm">Motorista</label>
                                                <select v-model="newBooking.driver_id" class="border rounded p-2 w-full">
                                                    <option v-for="driver in drivers" :key="driver.id" :value="driver.id">
                                                        {{ driver.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm">Vaga</label>
                                                <select v-model="newBooking.parking_space_id" class="border rounded p-2 w-full">
                                                    <option v-for="parkingSpace in parkingSpaces.filter(el => (el.vehicle_types.includes(newBooking.vehicle_type_id) || !el.vehicle_types.length))" :key="parkingSpace.id" :value="parkingSpace.id">
                                                        {{ parkingSpace.desc }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="button" @click="closeCreateModal"
                                                    class="mr-2 text-gray-500">Cancelar</button>
                                                <button type="submit"
                                                    class="bg-blue-500 text-white px-4 py-2 rounded">Criar</button>
                                            </div>
                                        </form>
                                    </div>
                                </template>
                            </Modal>

                            <!-- Advance Booking Modal -->
                            <Modal :show="advanceModalVisible" @close="closeAdvanceModal">
                                <template v-slot>
                                    <div class="box p-4">
                                        <h2 class="text-xl">Confirmar Avanço</h2>
                                        <p>Você tem certeza que deseja avançar este agendamento?</p>
                                        <div class="flex justify-end">
                                            <button type="button" @click="closeAdvanceModal"
                                                class="mr-2 text-gray-500">Cancelar</button>
                                            <button @click="advanceBooking"
                                                class="bg-blue-500 text-white px-4 py-2 rounded">Confirmar</button>
                                        </div>
                                    </div>
                                </template>
                            </Modal>

                            <Modal :show="bookingModalVisible" @close="closeBookingModal">
    <template v-slot>
      <!-- Modal Container -->
      <div class="relative w-full max-w-4xl mx-auto bg-white rounded-lg shadow-xl p-6 space-y-6">

        <!-- Burger Menu in Top Left -->
        <div class="absolute top-4 left-4">
          <div class="relative">
            <!-- Burger Button -->
            <button @click="toggleMenu" class="text-gray-600 hover:text-gray-800">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 5h14a1 1 0 110 2H3a1 1 0 110-2zm0 4h14a1 1 0 110 2H3a1 1 0 110-2zm0 4h14a1 1 0 110 2H3a1 1 0 110-2z" clip-rule="evenodd" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div
              v-if="menuOpen"
              class="absolute top-8 left-0 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-10"
            >
              <ul>
                <li>
                  <button
                    @click="cancelBooking"
                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                  >
                    Cancelar
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Modal Title -->
        <div class="flex items-center justify-between">
          <h2 class="text-2xl font-semibold text-gray-800">Detalhes do Agendamento</h2>
          <button @click="closeBookingModal" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M6.293 4.293a1 1 0 011.414 0L10 6.586l2.293-2.293a1 1 0 111.414 1.414L11.414 8l2.293 2.293a1 1 0 11-1.414 1.414L10 9.414l-2.293 2.293a1 1 0 11-1.414-1.414L8.586 8 6.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>

        <!-- Booking Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <p class="text-sm text-gray-500"><strong>Placa:</strong> <span class="font-medium text-gray-700">{{ selectedBooking?.vehicle?.placa ?? 'Sem Placa' }}</span></p>
            <p class="text-sm text-gray-500"><strong>Transportadora:</strong> <span class="font-medium text-gray-700">{{ selectedBooking?.carrier?.name ?? 'Sem Transportadora' }}</span></p>
            <p class="text-sm text-gray-500"><strong>Tipo de Veículo:</strong> <span class="font-medium text-gray-700">{{ selectedBooking?.vehicle_type?.desc ?? 'Não especificado' }}</span></p>
          </div>

          <div>
            <p class="text-sm text-gray-500"><strong>Motorista:</strong> <span class="font-medium text-gray-700">{{ selectedBooking?.driver?.name ?? 'Não especificado' }}</span></p>
            <p class="text-sm text-gray-500"><strong>Data do Agendamento:</strong> <span class="font-medium text-gray-700">{{ selectedBooking?.booking_dt ?? 'Data não especificada' }}</span></p>
            <p class="text-sm text-gray-500"><strong>Vaga:</strong> <span class="font-medium text-gray-700">{{ selectedBooking?.parking_space?.desc ?? 'Não especificado' }}</span></p>
          </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex justify-end mt-6">
          <button v-if="!['99'].includes(selectedBooking.stage?.code)" @click="openAdvanceModal" class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Avançar
          </button>
        </div>
      </div>
    </template>
  </Modal>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Modal from '@/Components/Modal.vue'; // Import your modal component
import moment from 'moment';
import axios from 'axios';
export default {
    props: {
        stages: Array,
        carriers: Array,
        parkingSpaces: Array,
        vehicleTypes: Array,
        drivers: Array
    },
    components: { Modal },
    data() {
        return {
            menuOpen: false,
            createModalVisible: false,
            advanceModalVisible: false,
            bookingModalVisible: false,
            newBooking: {
                booking_dt: moment().add(1, 'day'),
                stage_id: null,
                parking_space_id: null,
                vehicle_type_id: null,
                vehicle: {
                    placa: null,
                }
            },
            selectedBooking: null,
            bookings: [], // Placeholder for booking data
            // stages: [
            //     { id: 1, nome: 'Agendado' },
            //     { id: 2, nome: 'Check-in' },
            //     { id: 3, nome: 'Entrou na Planta' },
            //     { id: 4, nome: 'Em Operação' },
            //     { id: 5, nome: 'Finalizou Operação' },
            //     { id: 6, nome: 'Saiu da Planta' },
            //     { id: 7, nome: 'Faltou' },
            //     { id: 8, nome: 'Cancelado' },
            // ],
        };
    },
    mounted(){
        this.getData();
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen; // Toggle menu visibility
        },
        cancelBooking() {
            axios.post(route('booking.cancel', this.selectedBooking.id))
            .then(response => {
                this.bookings = response.data;
                this.closeBookingModal();
                this.closeAdvanceModal();
            })
            .catch(error => {
                this.closeBookingModal();
                this.closeAdvanceModal();
                window.Toast.error('Erro ao cancelar agendamento!');
            });
            this.selectedBooking = null;
            this.closeBookingModal();
        },
        plateMask() {
            if (/^[A-Za-z]{3}\d{1}[A-Za-z]{1}\d{2}$/.test(this.newBooking.placa)) {
                return "AAA#A##";
            } else {
                return "AAA####";
            }
        },
        async getData(){
            axios.get(route('booking.getBookings'))
            .then(response => {
                console.log(response);
                this.bookings = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        },
        showCreateModal(booking) {
            this.selectedBooking = booking;
            this.createModalVisible = true;
        },
        closeCreateModal() {
            this.createModalVisible = false;
            this.selectedBooking = null;
        },
        showBookingModal(booking) {
            this.selectedBooking = booking;
            this.bookingModalVisible = true;
        },
        closeBookingModal() {
            this.bookingModalVisible = false;
            this.newBooking = {
                booking_dt: moment().add(1, 'day'),
                stage_id: null,
                parking_space_id: null,
                vehicle_type_id: null,
                vehicle: {
                    placa: null,
                }
            };
        },
        createBooking() {
            axios.post(route('booking.store'), this.newBooking)
            .then(response => {
                this.bookings = response.data;
            })
            .catch(error => {
                console.log(error);
            })
            // this.bookings.push({ ...this.newBooking, id: Date.now() }); // Mock ID generation
            this.closeCreateModal();
        },
        closeAdvanceModal() {
            this.advanceModalVisible = false;
            this.selectedBooking = null;
        },
        openAdvanceModal() {
            this.advanceModalVisible = true;
            toast.success('test');
        },
        advanceBooking() {
            if (this.selectedBooking) {
                axios.post(route('booking.nextStage', this.selectedBooking.id))
                .then(response => {
                    this.bookings = response.data;
                    this.closeBookingModal();
                    this.closeAdvanceModal();
                })
                .catch(error => {
                    this.closeBookingModal();
                    this.closeAdvanceModal();
                    window.Toast.error('Erro ao avançar agendamento ou estágio final alcançado!');
                });
            }
        },
    },
};
</script>
