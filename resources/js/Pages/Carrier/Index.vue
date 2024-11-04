<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Index Transportadoras">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Index Transportadoras
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-screen flex flex-col">
                        <div class="container mx-auto p-4 flex-grow flex flex-col relative">
                            <h1 class="text-2xl font-bold mb-4">Agendamentos</h1>

                            <!-- Create Booking Button -->
                            <button class="absolute top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded z-10"
                                @click="showCreateModal">
                                Criar agendamento
                            </button>

                            <div class="flex flex-row justify-between flex-grow">
                                <div class="containerStage content min-w-[20%] max-w-[20%] mx-1 px-1 bg-gray-100 rounded overflow-auto hover-overflow flex flex-col"
                                    v-for="stage in stages" :key="stage.id">
                                    <div class="text-center my-2 font-semibold">{{ stage.nome }} ({{ bookings.filter(b => b.stage_id === stage.id).length }})</div>
                                    <div class="flex-grow">
                                        <div v-for="booking in bookings.filter(b => b.stage_id === stage.id)"
                                            :key="booking.id" class="border p-2 mb-2 rounded bg-white shadow">
                                            <p>{{ booking.nome }}</p>
                                            <button @click="openModal(booking)" class="text-blue-500">Avançar</button>
                                        </div>
                                        <p v-if="!bookings.filter(b => b.stage_id === stage.id).length"
                                            class="text-gray-500 text-center">Nenhum agendamento</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Create Booking Modal -->
                            <Modal :show="createModalVisible" @close="closeCreateModal">
                                <template v-slot>
                                    <div class="box p-4">
                                        <h2 class="text-xl">Criar agendamento</h2>
                                        <form @submit.prevent="createBooking">
                                            <div class="mb-4">
                                                <label class="block text-sm">Data/Horário</label>
                                                <select v-model="newBooking.stage_id" class="border rounded p-2 w-full">
                                                    <option v-for="stage in stages" :key="stage.id" :value="stage.id">{{
                                                        stage.nome }}</option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm">Nome</label>
                                                <input v-model="newBooking.nome" type="text"
                                                    class="border rounded p-2 w-full" required />
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Modal from '@/Components/Modal.vue'; // Import your modal component

export default {
    components: { Modal },
    data() {
        return {
            createModalVisible: false,
            advanceModalVisible: false,
            newBooking: {
                nome: '',
                stage_id: null,
            },
            selectedBooking: null,
            bookings: [], // Placeholder for booking data
            stages: [
                { id: 1, nome: 'Agendado' },
                { id: 2, nome: 'Check-in' },
                { id: 3, nome: 'Entrou na Planta' },
                { id: 4, nome: 'Em Operação' },
                { id: 5, nome: 'Finalizou Operação' },
                { id: 6, nome: 'Saiu da Planta' },
                { id: 7, nome: 'Faltou' },
                { id: 8, nome: 'Cancelado' },
            ],
        };
    },
    methods: {
        showCreateModal() {
            this.createModalVisible = true;
        },
        closeCreateModal() {
            this.createModalVisible = false;
            this.newBooking = { nome: '', stage_id: null };
        },
        createBooking() {
            this.bookings.push({ ...this.newBooking, id: Date.now() }); // Mock ID generation
            this.closeCreateModal();
        },
        openModal(booking) {
            this.selectedBooking = booking;
            this.advanceModalVisible = true;
        },
        closeAdvanceModal() {
            this.advanceModalVisible = false;
            this.selectedBooking = null;
        },
        advanceBooking() {
            if (this.selectedBooking) {
                this.selectedBooking.stage_id += 1; // Move to the next stage
                this.closeAdvanceModal();
            }
        },
    },
};
</script>
