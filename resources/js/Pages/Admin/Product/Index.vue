<template>
    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex bg-gray-800 justify-between items=center p-5">
                        <div class="flex space-x-2 items-center text-white">
                            Product Settings Page! Here you can list, create, update or delete product!
                        </div>
                        <div class="flex space-x-2 items-center" v-if="can.create">
                            <a href="#" class="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center"><span class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span> Create Product</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">Title</th>
                            <th scope="col" class="py-3 px-6">Description</th>
                            <th v-if="can.edit || can.delete" scope="col" class="py-3 px-6">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in products.data" :key="product.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td data-label="Title" class="py-4 px-6">
                                {{ product.name }}
                            </td>
                            <td data-label="Title" class="py-4 px-6">
                                {{ product.description }}
                            </td>
                            <td
                                v-if="can.edit || can.delete"
                                class="py-4 px-6 w-48"
                            >
                                <div type="justify-start lg:justify-end" no-wrap>
                                    <PrimaryButton class="ml-4 bg-green-500 px-2 py-1 rounded text-white cursor-pointer"
                                                   v-if="can.edit"
                                                   @click="editProduct(product)"
                                    >
                                        Edit
                                    </PrimaryButton>
                                    <PrimaryButton class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer"
                                                   v-if="can.delete">
                                        Delete
                                    </PrimaryButton>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Show the modal when editModalOpen is true -->
        <ProductEditModal v-if="editModalOpen" :product="editingProduct" @close="closeEditModal" @save="saveChangesToProduct" />

    </AuthenticatedLayout>

</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue"; // Import your modal component
import { ref, defineProps } from 'vue';
import ProductEditModal from "@/Pages/Admin/Product/ProductEditModal.vue";

const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
});

// Define reactive properties
const editingProduct = ref(null);
const editModalOpen = ref(false);

// Add your methods here
const editProduct = (product) => {
    editingProduct.value = product;
    editModalOpen.value = true;
};

const closeEditModal = () => {
    editingProduct.value = null;
    editModalOpen.value = false;
};

const saveChangesToProduct = () => {
    // Close the modal
    closeEditModal();
};

</script>
