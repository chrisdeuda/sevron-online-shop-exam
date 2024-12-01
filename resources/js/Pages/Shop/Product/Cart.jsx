import React, { useState, useContext } from 'react';
import { Link } from '@inertiajs/react';
import CheckoutForm from './CheckoutForm';
import { useCart } from '@/Context/CartContext'; // Change 2: Update import path


const Cart = ({ cartItems: initialCartItems }) => {
    const [showCheckout, setShowCheckout] = useState(false);

    const [cartItems, setCartItems] = useState(initialCartItems);
    const [successMessage, setSuccessMessage] = useState('');

    const showCheckoutForm = () => {
        setShowCheckout(true);
    };

    const hideCheckoutForm = () => {
        setShowCheckout(false);
    };

    const removeItem = async (itemId, index) => {
        try {
            const response = await fetch(`/cart/${itemId}`, {
                method: 'DELETE',
            });

            if (response.ok) {
                removeFromCart(itemId);
                setSuccessMessage('Item removed from the cart.');
            }
        } catch (error) {
            console.error('Error removing item:', error);
        }
    };

    const calculateCartTotal = () => {
        let total = 0;
        for (const itemId in cartItems) {
            if (cartItems.hasOwnProperty(itemId)) {
                total += cartItems[itemId].price * cartItems[itemId].quantity;
            }
        }
        return total;
    };

    const cartTotal = calculateCartTotal();

    return (
        <div className="my-8">
            <div className="container px-6 mx-auto">
                <div className="flex justify-center my-6">
                    <div className="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
                        {!showCheckout ? (
                            <>
                                <div className="flex justify-between items-center mb-6">
                                    <h3 className="text-3xl font-bold">Your Cart</h3>
                                    <button
                                        onClick={showCheckoutForm}
                                        className="px-6 py-2 text-sm rounded shadow text-white bg-green-500"
                                    >
                                        Proceed to Checkout
                                    </button>
                                    <Link
                                        to="/products"
                                        className="text-gray-700 hover:text-gray-900"
                                    >
                                        Back to Shopping
                                    </Link>
                                </div>

                                <div className="flex-1">
                                    <table className="w-full text-sm lg:text-base" cellSpacing="0">
                                        <thead>
                                        <tr className="h-12 uppercase">
                                            <th className="py-4 px-6 text-left">Name</th>
                                            <th className="py-4 px-6 text-left">
                                                <span className="lg:hidden" title="Quantity">Qtd</span>
                                                <span className="hidden lg:inline">Quantity</span>
                                            </th>
                                            <th className="py-4 px-6 text-left">Price</th>
                                            <th className="py-4 px-6 text-left">Total</th>
                                            <th className="py-4 px-6 text-left">Remove</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {Object.entries(cartItems).map(([itemId, item], index) => (
                                            <tr key={itemId} className="border-b">
                                                <td className="py-4 px-6 text-left">{item.name}</td>
                                                <td className="py-4 px-6 text-left">${item.price}</td>
                                                <td className="py-4 px-6 text-left">{item.quantity}</td>
                                                <td className="py-4 px-6 text-left">
                                                    ${(item.price * item.quantity).toFixed(2)}
                                                </td>
                                                <td className="py-4 px-6 text-left">
                                                    <button
                                                        onClick={() => removeItem(item.id, index)}
                                                        className="px-4 py-2 text-sm text-white bg-red-500 rounded shadow"
                                                    >
                                                        Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                        <tr>
                                            <td colSpan="3" className="py-4 px-6 text-right font-semibold">
                                                Total:
                                            </td>
                                            <td className="py-4 px-6 text-left font-semibold">
                                                ${cartTotal.toFixed(2)}
                                            </td>
                                            <td className="py-4 px-6 text-left"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </>
                        ) : (
                            <CheckoutForm
                                cartItems={cartItems}
                                totalAmount={cartTotal}
                                onCancel={hideCheckoutForm}
                            />
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Cart;
