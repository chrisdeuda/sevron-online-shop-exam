<script>
export default {
    props: ['products'], // Declare that you're expecting 'products' prop

    methods: {
        addToCart(product) {
            // Implement your logic to add the product to the cart
            console.log('Adding product to cart:', product);

        },
    },
};
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Latest Products</h2>
            <div class="h-1 bg-gray-800 w-48 my-6"></div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <div v-for="product in products" :key="product.id" class="w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md">
                    <img src="https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-04.jpg" alt="Product Image" class="w-full h-60 object-cover object-center">
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-gray-700 uppercase">{{ product.name }}</h3>
                            <span class="mt-2 text-gray-500 font-semibold">${{ product.price }}</span>
                        </div>
                        <form @submit.prevent="addToCart(product)" class="flex justify-end">
                            <input type="hidden" v-model="product.id" name="id">
                            <input type="hidden" v-model="product.name" name="name">
                            <input type="hidden" v-model="product.price" name="price">
                            <input type="hidden" v-model="product.image" name="image">
                            <input type="hidden" value="1" name="quantity">
                            <button type="submit" class="px-4 py-1.5 text-white text-sm bg-gray-900 rounded">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
