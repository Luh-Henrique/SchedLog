<script setup>
import Modal from '@/Components/Modal.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';
</script>

<template>
    <AppLayout title="Transportadoras">
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h1 class="text-2xl font-bold mb-4">Transportadoras</h1>

                    <!-- Create Button -->
                    <button class="bg-blue-500 text-white px-4 py-2 rounded mb-4" @click="showCreateModal">
                        Criar Entrada
                    </button>

                    <!-- Table -->
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="w-full bg-gray-200 text-left">
                                <th class="py-2 px-4">Nome</th>
                                <th class="py-2 px-4">CNPJ</th>
                                <th class="py-2 px-4">CEP</th>
                                <th class="py-2 px-4">Endereço</th>
                                <th class="py-2 px-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in carriersData" :key="item.id" class="border-b">
                                <td class="py-2 px-4">{{ item.name }}</td>
                                <td class="py-2 px-4">{{ item.cnpj }}</td>
                                <td class="py-2 px-4">{{ item.cep }}</td>
                                <td class="py-2 px-4">{{ item.address }}</td>
                                <td class="py-2 px-4">
                                    <button @click="openEditModal(item)" class="text-blue-500 mr-2">Editar</button>
                                    <button @click="deleteEntry(item.id)" class="text-red-500">Excluir</button>
                                </td>
                            </tr>
                            <tr v-if="!carriersData.length">
                                <td colspan="5" class="py-4 text-center text-gray-500">Nenhum dado disponível</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Modal -->
        <Modal :show="createModalVisible" @close="closeCreateModal">
            <template v-slot>
                <div class="box p-4">
                    <h2 class="text-xl">Criar Entrada</h2>
                    <form @submit.prevent="createEntry">
                        <div class="mb-4">
                            <InputLabel for="name" value="Nome" />
                            <TextInput
                                id="name"
                                v-model="newEntry.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError v-if="errors?.name" :message="errors.name[0]" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="cnpj" value="CNPJ" />
                            <TextInput
                                id="cnpj"
                                v-model="newEntry.cnpj"
                                type="text"
                                v-mask="'##.###.###/####-##'"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError v-if="errors?.cnpj" :message="errors.cnpj[0]" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="cep" value="CEP" />
                            <TextInput
                                id="cep"
                                v-model="newEntry.cep"
                                type="text"
                                v-mask="'#####-###'"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError v-if="errors?.cep" :message="errors.cep[0]" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="address" value="Endereço" />
                            <TextInput
                                id="address"
                                v-model="newEntry.address"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError v-if="errors?.address" :message="errors.address[0]" class="mt-2" />
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="closeCreateModal" class="mr-2 text-gray-500">Cancelar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                </div>
            </template>
        </Modal>


        <!-- Edit Modal -->
        <Modal :show="editModalVisible" @close="closeEditModal">
            <template v-slot>
                <div class="box p-4">
                    <h2 class="text-xl">Editar Entrada</h2>
                    <form @submit.prevent="updateEntry">
                        <div class="mb-4">
                            <InputLabel for="name" value="Nome" />
                            <TextInput
                                id="name"
                                v-model="selectedEntry.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError v-if="errors?.name" :message="errors.name[0]" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="cnpj" value="CNPJ" />
                            <TextInput
                                id="cnpj"
                                v-model="selectedEntry.cnpj"
                                type="text"
                                v-mask="'##.###.###/####-##'"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError v-if="errors?.cnpj" :message="errors.cnpj[0]" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="cep" value="CEP" />
                            <TextInput
                                id="cep"
                                v-model="selectedEntry.cep"
                                type="text"
                                v-mask="'#####-###'"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError v-if="errors?.cep" :message="errors.cep[0]" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="address" value="Endereço" />
                            <TextInput
                                id="address"
                                v-model="selectedEntry.address"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError v-if="errors?.address" :message="errors.address[0]" class="mt-2" />
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="closeEditModal" class="mr-2 text-gray-500">Cancelar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar</button>
                        </div>
                    </form>
                </div>
            </template>
        </Modal>

    </div>
</AppLayout>
</template>

<script>
export default {
    props:{
        carriers: Array,
    },
    components: { Modal },
    data() {
        return {
            createModalVisible: false,
            carriersData: [],
            editModalVisible: false,
            newEntry: { name: '', cnpj: '', cep: '', address: '' },
            selectedEntry: null,
            tableData: [],
            errors: {}
        };
    },
    mounted(){
        this.carriersData = this.carriers;
    },
    methods: {
        showCreateModal() {
            this.createModalVisible = true;
        },
        closeCreateModal() {
            this.createModalVisible = false;
            this.newEntry = { name: '', cnpj: '', cep: '', address: '' };
        },
        createEntry() {
            axios.post(route('carrier.store'), this.newEntry)
            .then(response => {
                this.carriersData = response.data;
                this.closeCreateModal();
            })
            .catch(error => {
                this.errors = error.response.data.errors;
                console.log(this.errors);
            })
            // this.tableData.push({ ...this.newEntry, id: Date.now() });

        },
        openEditModal(entry) {
            this.selectedEntry = { ...entry };
            this.editModalVisible = true;
        },
        closeEditModal() {
            this.editModalVisible = false;
            this.selectedEntry = null;
        },
        updateEntry() {
            axios.post(route('carrier.store'), this.selectedEntry)
            .then(response => {
                this.carriersData = response.data;
            })
            .catch(error => {
                console.log(error);
            })
            // const index = this.tableData.findIndex(e => e.id === this.selectedEntry.id);
            // if (index !== -1) {
            //     this.tableData.splice(index, 1, { ...this.selectedEntry });
            // }
            this.closeEditModal();
        },
        deleteEntry(id) {
            axios.delete(route('carrier.destroy', id))
            .then(response => {
                this.carriersData = response.data;
            })
            .catch(error => {
                console.log(error);
            })
            // this.tableData = this.tableData.filter(e => e.id !== id);
        },
    },
};
</script>
