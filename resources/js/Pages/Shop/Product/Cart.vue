<script>

const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
})
export default {
    data() {
        return {
            successMessage: '', // Set this with your success message
            cartItems: [], // Populate this array with your cart item data
        };
    },
    computed: {
        cartTotal() {
            return this.cartItems.reduce((total, item) => total + item.price * item.quantity, 0);
        },
    },
    methods: {
        updateCart(item) {
            // Implement your logic to update the cart item
            console.log('Updating cart item:', item);
        },
        removeFromCart(item) {
            // Implement your logic to remove the cart item
            console.log('Removing cart item:', item);
        },
        clearCart() {
            // Implement your logic to clear the cart
            console.log('Clearing cart');
        },
    },
};
</script>

<template>
    <div class="my-8">
        <div class="container px-6 mx-auto">
            <div class="flex justify-center my-6">
                <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
                    <div v-if="successMessage" class="p-4 mb-3 bg-blue-400 rounded">
                        <p class="text-white">{{ successMessage }}</p>
                    </div>
                    <h3 class="text-3xl font-bold">Carts</h3>
                    <div class="flex-1">
                        <table class="w-full text-sm lg:text-base" cellspacing="0">
                            <thead>
                            <tr class="h-12 uppercase">
                                <th class="hidden md:table-cell"></th>
                                <th class="text-left">Name</th>
                                <th class="pl-5 text-left lg:text-right lg:pl-0">
                                    <span class="lg:hidden" title="Quantity">Qtd</span>
                                    <span class="hidden lg:inline">Quantity</span>
                                </th>
                                <th class="hidden text-right md:table-cell">Price</th>
                                <th class="hidden text-right md:table-cell">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in cartItems" :key="item.id">
                                <td class="hidden pb-4 md:table-cell" style="width: 230px;">
                                    <a :href="item.attributes.image">
                                        <img :src="item.attributes.image" class="w-[200px] rounded" alt="Thumbnail">
                                    </a>
                                </td>
                                <td>
                                    <a :href="item.attributes.image">
                                        <p class="mb-2 text-gray-900 font-bold">{{ item.name }}</p>
                                    </a>
                                </td>
                                <td class="justify-center mt-6 md:justify-end md:flex">
                                    <div class="h-10 w-28">
                                        <div class="relative flex flex-row w-full h-8">
                                            <form @submit.prevent="updateCart(item)">
                                                <input type="hidden" v-model="item.id" name="id">
                                                <input type="number" v-model="item.quantity" class="w-full text-center h-10 text-gray-800 outline-none rounded border border-gray-600 py-3" />
                                                <button type="submit" class="w-full px-4 mt-1 py-1.5 text-sm rounded shadow text-violet-100 bg-gray-800">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden text-right md:table-cell">
                    <span class="text-sm font-medium lg:text-base">
                      ${{ item.price }}
                    </span>
                                </td>
                                <td class="hidden text-right md:table-cell">
                                    <form @submit.prevent="removeFromCart(item)">
                                        <input type="hidden" v-model="item.id" name="id">
                                        <button type="submit" class="px-3 py-1 text-white bg-gray-800 shadow rounded-full">x</button>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center my-5">
                            <div class="font-semibold text-2xl">Total: ${{ cartTotal }}</div>
                            <div>
                                <form @submit.prevent="clearCart">
                                    <button type="submit" class="px-6 py-2 text-sm rounded shadow text-red-100 bg-gray-800">Clear Carts</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


