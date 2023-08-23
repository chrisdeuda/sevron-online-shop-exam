<script>

import { reactive } from 'vue';
export default {
    props: {
        cartItems: Object, // Provided by Inertia
    },
    setup(props) {
        const state = reactive({
            successMessage: '',
        });
        const removeItem = async (itemId, index) => {
            console.log(props.cartItems);
            try {
                const response = await fetch(`/cart/${itemId}`, {
                    method: 'DELETE',
                });
                if (response.ok) {
                    delete props.cartItems[itemId]; // Remove the item by key
                    state.successMessage = 'Item removed from the cart.';
                }
            } catch (error) {
                console.error('Error removing item:', error);
            }
        };

        return {
            state,
            removeItem,
        };
    },
    computed: {
        cartTotal() {
            let total = 0;
            const carts = this.cartItems;
            for (const itemId in carts) {
                if (carts.hasOwnProperty(itemId)) {
                    total += carts[itemId].price * carts[itemId].quantity;
                }
            }
            return total;
        },
    },
};
</script>

<template>
    <div class="my-8">
        <div class="container px-6 mx-auto">
            <div class="flex justify-center my-6">
                <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
<!--                    <div v-if="successMessage" class="p-4 mb-3 bg-blue-400 rounded">
                        <p class="text-white">{{ successMessage }}</p>
                    </div>-->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-3xl font-bold">Your Carts</h3>
                        <button @click="proceedToCheckout" class="px-6 py-2 text-sm rounded shadow text-white bg-green-500">Proceed to Checkout</button>
                    </div>
                    <div class="flex-1">
                        <table class="w-full text-sm lg:text-base" cellspacing="0">
                            <thead>
                            <tr class="h-12 uppercase">
<!--                                <th class="hidden md:table-cell"></th>-->
                                <th class="py-4 px-6 text-left">Name</th>
                                <th class="py-4 px-6 text-left">
                                    <span class="lg:hidden" title="Quantity">Qtd</span>
                                    <span class="hidden lg:inline">Quantity</span>
                                </th>
                                <th class="py-4 px-6 text-left">Price</th>
                                <th class="py-4 px-6 text-left">Total</th>
                                <th class="py-4 px-6 text-left">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in cartItems" :key="item.id" class="border-b">
                                <td class="py-4 px-6 text-left">{{ item.name }}</td>
                                <td class="py-4 px-6 text-left">${{ item.price }}</td>
                                <td class="py-4 px-6 text-left">{{ item.quantity }}</td>
                                <td class="py-4 px-6 text-left">${{ item.price * item.quantity }}</td>
                                <td class="py-4 px-6 text-left">
                                    <button @click="removeItem(item.id, index)" class="px-4 py-2 text-sm text-white bg-red-500 rounded shadow">Remove</button>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" class="py-4 px-6 text-right font-semibold">Total:</td>
                                <td class="py-4 px-6 text-left font-semibold">${{ cartTotal }}</td>
                                <td class="py-4 px-6 text-left"></td>
                            </tr>
                            </tbody>
                        </table>
<!--                        <div class="flex justify-between items-center my-5">-->
<!--                            -->
<!--                            <div class="font-semibold text-2xl">Total: ${{ cartTotal }}</div>-->
<!--                            <div>-->
<!--                                &lt;!&ndash; Clear cart button here &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


