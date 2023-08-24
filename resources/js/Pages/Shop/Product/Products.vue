<script>
import { ref, inject } from 'vue';
import NavLink from "@/Components/NavLink.vue";

export default {
    components: {NavLink},
    props: ['products'], // Declare that you're expecting 'products' prop
    setup() {
        const cartTotal = inject('cartTotal');
        const addToCart = async (product) => {
            try {
                const cartItem = createCartItem(product);

                console.log(cartItem);

                const response = await axios.post('/cart', cartItem);

                if (response.status === 200) {
                    alert('Product added to cart' );
                    // Fetch updated cart total after adding an item
                    const updatedTotalResponse = await axios.get('/cart/total');

                    console.log(updatedTotalResponse);
                    cartTotal.value = updatedTotalResponse.data.total; // Update cartTotal value
                    // Other success handling
                } else {
                    // Other error handling
                }
            } catch (error) {
                console.error('Error adding product to cart:', error);
            }
        };

        const createCartItem = (product) => {
            return {
                id: product.id,
                name: product.name,
                price: product.price,
                photo: product.photo,
                quantity: 1, // default order 1
            };
        };
        return {
            cartTotal,
            addToCart,
            createCartItem
        };
    },

    methods: {
        // async addToCart(product) {
        //
        //     try {
        //
        //         const cartItem = this.createCartItem(product);
        //
        //         const response = await axios.post('/cart', cartItem); // Use the correct URL
        //         if (response.data.message === 'success') {
        //             // Fetch updated cart total after adding an item
        //             const updatedTotalResponse = await axios.get('/cart/total');
        //             cartTotal.value = updatedTotalResponse.data.total; // Update cartTotal value
        //             // Other success handling
        //         } else {
        //             // Other error handling
        //         }
        //     } catch (error) {
        //         console.error('Error adding product to cart:', error);
        //     }
        // },


    },
    data() {
        return {
            successMessage: '',
            product: {
                id: '',
                name: '',
                price: '',
                image: '',
                quantity: 1,
            },
        };
    },
};
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-900">Latest Products</h2>
                <NavLink :href="route('cart.index')" :active="route().current('cart.index')">
                    View Cart ({{ cartTotal }})
                </NavLink>
            </div>
            <div class="h-1 bg-gray-800 w-48 my-6"></div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <div v-for="product in products" :key="product.id" class="w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md flex flex-col">
                    <img :src="product.photo" alt="Product Image" class="w-full h-60 object-cover object-center">
                    <div class="px-5 py-3 flex-grow">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-gray-700">{{ product.name }}</h3>
                            <span class="mt-2 text-gray-500 font-semibold">${{ product.price }}</span>
                        </div>
                    </div>
                    <form @submit.prevent="addToCart(product)" class="flex justify-end mt-3">
                        <input type="hidden" v-model="product.id" name="id">
                        <input type="hidden" v-model="product.name" name="name">
                        <input type="hidden" v-model="product.price" name="price">
                        <input type="hidden" v-model="product.image" name="image">
                        <input type="hidden" :value="product.quantity" name="quantity">
                        <button type="submit" class="px-4 py-1.5 text-white text-sm bg-gray-900 rounded">Add To Cart</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</template>
