<script>
export default {
    props: ['products'], // Declare that you're expecting 'products' prop

    methods: {
        async addToCart(product) {
            try {
                const cartItem = this.createCartItem(product);

                const response = await axios.post('/cart', cartItem); // Use the correct URL
                if (response.data.message === 'success') {
                    this.successMessage = 'Product added to cart!';
                } else {
                    this.successMessage = 'Failed to add product to cart.';
                }
            } catch (error) {
                console.error('Error adding product to cart:', error);
            }
        },

        createCartItem(product) {
            return {
                id: product.id,
                name: product.name,
                price: product.price,
                photo: product.photo,
                quantity: 1, // default order 1
            };
        },
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
            <h2 class="text-3xl font-extrabold text-gray-900">Latest Products</h2>
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
