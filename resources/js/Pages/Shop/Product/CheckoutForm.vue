<template>
    <div>
        <header class="flex flex-wrap">
            <!-- Header content here -->
            <!-- Copy the header content from the template -->
        </header>
        <div class="h-screen grid grid-cols-3">
            <div class="lg:col-span-2 col-span-3 bg-indigo-50 space-y-8 px-12">
                <!-- Shipping and Billing Information form here -->
                <section>
                    <h2 class="uppercase tracking-wide text-lg font-semibold text-gray-700 my-2">Shipping & Billing Information</h2>
                    <fieldset class="mb-3 bg-white shadow-lg rounded text-gray-600">
                        <label class="flex border-b border-gray-200 h-12 py-3 items-center">
                            <span class="text-right px-2">Name</span>
                            <input v-model="name" class="focus:outline-none px-3" placeholder="Try Odinsson" required>
                        </label>
                        <label class="flex border-b border-gray-200 h-12 py-3 items-center">
                            <span class="text-right px-2">Email</span>
                            <input v-model="email" type="email" class="focus:outline-none px-3" placeholder="try@example.com" required>
                        </label>
                        <!-- Other input fields -->
                    </fieldset>
                </section>
                <section>
                    <h2 class="uppercase tracking-wide text-lg font-semibold text-gray-700 my-2">Payment Information</h2>
                    <fieldset class="mb-3 bg-white shadow-lg rounded text-gray-600">
                        <label class="flex border-b border-gray-200 h-12 py-3 items-center">
                            <span class="text-right px-2">Card</span>
                            <input name="card" class="focus:outline-none px-3 w-full" placeholder="Card number MM/YY CVC" required>
                        </label>
                        <!-- Other payment fields -->
                    </fieldset>
                </section>
                <button @click.prevent="submitOrder" class="submit-button px-4 py-3 rounded-full bg-pink-400 text-white focus:ring focus:outline-none w-full text-xl font-semibold transition-colors">
                    Pay ${{ totalAmount.toFixed(2) }}
                </button>
            </div>
            <div class="col-span-1 bg-white lg:block hidden">
                <!-- Order Summary section here -->
                <h1 class="py-6 border-b-2 text-xl text-gray-600 px-8">Order Summary</h1>
                <ul class="py-6 border-b space-y-6 px-8">
                    <!-- Loop through cart items and display them -->
                    <li v-for="item in cartItems" :key="item.id" class="grid grid-cols-6 gap-2 border-b-1">
                        <div class="col-span-1 self-center">
                            <img :src="item.attributes.photo" :alt="item.name" class="rounded w-full">
                        </div>
                        <div class="flex flex-col col-span-3 pt-2">
                            <span class="text-gray-600 text-md font-semi-bold">{{ item.name }}</span>
                            <span class="text-gray-400 text-sm inline-block pt-2">{{ item.description }}</span>
                        </div>
                        <div class="col-span-2 pt-3">
                            <div class="flex items-center space-x-2 text-sm justify-between">
                                <span class="text-gray-400">{{ item.quantity }} x €{{ item.price }}</span>
                                <span class="text-pink-400 font-semibold inline-block">€{{ item.quantity * item.price }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- Total and other summary details -->
            </div>
        </div>
    </div>
</template>

<script>
// Import the Inertia object here if needed
//import { Inertia } from '@inertiajs/inertia';

export default {
    props: ['cartItems', 'totalAmount'],
    data() {
        return {
            name: '',
            email: '',
            // Other data properties
        };
    },
    methods: {
        async submitOrder() {

            const formData = {
                name: this.name,
                email: this.email,
                address: this.address,
                phone: this.phone,
                total_amount: this.totalAmount,
                items: this.cartItems
            };
            alert('test');

            try {
                const response = await axios.post('/api/checkout', formData); // Use the correct URL
                if (response.ok) {
                    delete props.cartItems[itemId]; // Remove the item by key
                    state.successMessage = 'Item removed from the cart.';
                    console.log('After fetch success');
                }
                // Redirect to order success page or show a success message
            } catch (error) {
                // Handle errors and show appropriate messages
            }
        },
    },
};
</script>


<style>

/* Include a CSS reset or normalize styles */
input, select, textarea {
    border: none;
    /* Other reset styles */
}

* {
    margin: 0;
    padding: 0;
}
fieldset label span {
    min-width: 125px;
}
fieldset .select::after {
    content: '';
    position: absolute;
    width: 9px;
    height: 5px;
    right: 20px;
    top: 50%;
    margin-top: -2px;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'><title>Arrow</title><path d='M.552 0H8.45c.58 0 .723.359.324.795L5.228 4.672a.97.97 0 0 1-1.454 0L.228.795C-.174.355-.031 0 .552 0z' fill='%23CFD7DF' fill-rule='evenodd'/></svg>");
    pointer-events: none;
}

</style>
