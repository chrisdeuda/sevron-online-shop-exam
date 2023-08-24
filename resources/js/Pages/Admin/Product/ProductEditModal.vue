<template>
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 z-10" style="width: 75%;">
            <h2 class="text-lg font-semibold mb-3">Edit Product</h2>
            <form @submit.prevent="saveChanges">
                <table class="w-full">
                    <tbody>
                    <tr>
                        <td class="w-1/4">
                            <label class="block">
                                Product Name:
                            </label>
                        </td>
                        <td class="w-3/4">
                            <input v-model="editedProduct.name" type="text" class="mt-1 w-full" />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-1/4">
                            <label class="block">
                                Price:
                            </label>
                        </td>
                        <td class="w-3/4">
                            <input v-model="editedProduct.price" type="number" step="0.01" class="mt-1 w-full" />
                        </td>
                    </tr>
                    <tr>
                        <td class="w-1/4">
                            <label class="block">
                                Description:
                            </label>
                        </td>
                        <td class="w-3/4">
                            <textarea v-model="editedProduct.description" class="mt-1 w-full taller-textarea"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-1/4">
                            <label class="block">
                                Current Photo:
                            </label>
                        </td>
                        <td class="w-3/4">
                            <img v-if="editedProduct.photo" :src="editedProduct.photo"
                                 alt="Product Photo"
                                 style="max-width: 250px; max-height: 250px;" />
                        </td>
                    </tr>
<!--                    <tr>-->
<!--                        <td class="w-1/4">-->
<!--                            <label class="block">-->
<!--                                New Photo:-->
<!--                            </label>-->
<!--                        </td>-->
<!--                        <td class="w-3/4">-->
<!--                            <input type="file" accept="image/*" @change="handleFileChange" class="mt-1 w-full" />-->
<!--                        </td>-->
<!--                    </tr>-->
                    </tbody>
                </table>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Save Changes</button>
                    <button @click="closeModal" class="bg-gray-200 text-gray-700 px-3 py-1 rounded ml-3">Cancel</button>
                </div>
                <!-- Alert message -->
                <div v-if="alertMessage" class="mt-4 text-center text-green-500">
                    {{ alertMessage }}
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref, defineProps } from 'vue';
import axios from 'axios';

export default {
    props: {
        product: {
            type: Object,
            default: () => ({}),
        },
    },
    setup(props, context) {
        const editedProduct = ref({ ...props.product });
        const alertMessage = ref(null);

        const closeModal = () => {
            context.emit('close');
        };

        const saveChanges = async () => {
            try {
                const response = await axios.post(`/api/admin/product/${editedProduct.value.id}`, editedProduct.value);

                if (response.status === 200) {
                    // Set success alert message
                    alertMessage.value = 'Product updated successfully';

                    // Delay before closing the modal
                    setTimeout(() => {
                        closeModal();
                    }, 2000); // Adjust the delay time (in milliseconds) as needed
                } else {
                    // Set error alert message
                    alertMessage.value = 'Failed to update product';
                }
            } catch (error) {
                console.error('Error updating product:', error);
                // Set error alert message
                alertMessage.value = 'An error occurred while updating the product';
            }
        };

        const handleFileChange = (event) => {
            const file = event.target.files[0];
            if (file) {
                editedProduct.value.photo = URL.createObjectURL(file);
            }
        };

        return {
            editedProduct,
            alertMessage,
            closeModal,
            saveChanges,
            handleFileChange,
        };
    },
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editedProduct.value.photo = URL.createObjectURL(file);
    }
};
</script>


