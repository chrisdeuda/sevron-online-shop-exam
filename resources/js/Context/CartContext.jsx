import React, { createContext, useState, useContext } from 'react';

export const CartContext = createContext();

export const CartProvider = ({ children }) => {
    const [cartItems, setCartItems] = useState({});
    const [cartTotal, setCartTotal] = useState(0);

    const addToCart = (item) => {
        setCartItems(prevItems => ({
            ...prevItems,
            [item.id]: item
        }));
        updateCartTotal();
    };

    const removeFromCart = (itemId) => {
        setCartItems(prevItems => {
            const newItems = { ...prevItems };
            delete newItems[itemId];
            return newItems;
        });
        updateCartTotal();
    };

    const updateCartTotal = () => {
        const total = Object.values(cartItems).reduce((sum, item) => {
            return sum + (item.price * item.quantity);
        }, 0);
        setCartTotal(total);
    };

    const clearCart = () => {
        setCartItems({});
        setCartTotal(0);
    };

    return (
        <CartContext.Provider value={{
            cartItems,
            cartTotal,
            addToCart,
            removeFromCart,
            clearCart,
            setCartTotal
        }}>
            {children}
        </CartContext.Provider>
    );
};

// Custom hook for using cart context
export const useCart = () => {
    const context = useContext(CartContext);
    if (!context) {
        throw new Error('useCart must be used within a CartProvider');
    }
    return context;
};
