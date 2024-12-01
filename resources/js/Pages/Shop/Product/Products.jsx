import React, { useContext } from 'react';
import axios from 'axios';
import { Link } from '@inertiajs/react';
import { CartContext } from '@/context/CartContext.jsx'; // You'll need to create this context

const Products = ({ products }) => {
    // const { cartTotal, setCartTotal } = useContext(CartContext);

    const createCartItem = (product) => {
        return {
            id: product.id,
            name: product.name,
            price: product.price,
            photo: product.photo,
            quantity: 1, // default order 1
        };
    };

    const addToCart = async (event, product) => {
        event.preventDefault();

        try {
            const cartItem = createCartItem(product);
            console.log(cartItem);

            const response = await axios.post('/cart', cartItem);

            if (response.status === 200) {
                alert('Product added to cart');
                // Fetch updated cart total after adding an item
                const updatedTotalResponse = await axios.get('/cart/total');
                console.log(updatedTotalResponse);
                setCartTotal(updatedTotalResponse.data.total);
            } else {
                // Error handling
            }
        } catch (error) {
            console.error('Error adding product to cart:', error);
        }
    };

    return (
        <div className="bg-white">
            <div className="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-3xl font-extrabold text-gray-900">Latest Products</h2>
                    <Link
                        to="/cart"
                        className="text-gray-700 hover:text-gray-900"
                    >
                        {/*View Cart ({cartTotal})*/}
                    </Link>
                </div>

                <div className="h-1 bg-gray-800 w-48 my-6"></div>

                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    {products.map((product) => (
                        <div
                            key={product.id}
                            className="w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md flex flex-col"
                        >
                            <img
                                src={product.photo}
                                alt="Product Image"
                                className="w-full h-60 object-cover object-center"
                            />
                            <div className="px-5 py-3 flex-grow">
                                <div className="flex items-center justify-between mb-5">
                                    <h3 className="text-gray-700">{product.name}</h3>
                                    <span className="mt-2 text-gray-500 font-semibold">
                                        ${product.price}
                                    </span>
                                </div>
                            </div>
                            <form
                                onSubmit={(e) => addToCart(e, product)}
                                className="flex justify-end mt-3"
                            >
                                <input type="hidden" name="id" value={product.id} />
                                <input type="hidden" name="name" value={product.name} />
                                <input type="hidden" name="price" value={product.price} />
                                <input type="hidden" name="image" value={product.photo} />
                                <input type="hidden" name="quantity" value={1} />
                                <button
                                    type="submit"
                                    className="px-4 py-1.5 text-white text-sm bg-gray-900 rounded"
                                >
                                    Add To Cart
                                </button>
                            </form>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default Products;
