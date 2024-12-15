import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function ProductEditModal({ product, onClose }) {
    const [editedProduct, setEditedProduct] = useState({ ...product });
    const [alertMessage, setAlertMessage] = useState(null);

    useEffect(() => {
        setEditedProduct({ ...product });
    }, [product]);

    const closeModal = () => {
        onClose();
    };

    const saveChanges = async (e) => {
        e.preventDefault();
        try {
            console.log('da');
            console.log(editedProduct);
            const response = await axios.post(`/api/admin/product/${editedProduct.id}`, editedProduct);

            if (response.status === 200) {
                setAlertMessage('Product updated successfully');
                setTimeout(() => {
                    closeModal();
                }, 2000);
            } else {
                setAlertMessage('Failed to update product');
            }
        } catch (error) {
            console.error('Error updating product:', error);
            setAlertMessage('An error occurred while updating the product');
        }
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setEditedProduct(prev => ({ ...prev, [name]: value }));
    };

    return (
        <div className="fixed inset-0 flex items-center justify-center z-50">
            <div className="absolute inset-0 bg-black opacity-50"></div>
            <div className="bg-white rounded-lg shadow-lg p-6 z-10" style={{ width: '75%' }}>
                <h2 className="text-lg font-semibold mb-3">Edit Product</h2>
                <form onSubmit={saveChanges}>
                    <table className="w-full">
                        <tbody>
                        <tr>
                            <td className="w-1/4">
                                <label className="block">Product Name:</label>
                            </td>
                            <td className="w-3/4">
                                <input
                                    name="name"
                                    value={editedProduct.name}
                                    onChange={handleInputChange}
                                    type="text"
                                    className="mt-1 w-full"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td className="w-1/4">
                                <label className="block">Price:</label>
                            </td>
                            <td className="w-3/4">
                                <input
                                    name="price"
                                    value={editedProduct.price}
                                    onChange={handleInputChange}
                                    type="number"
                                    step="0.01"
                                    className="mt-1 w-full"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td className="w-1/4">
                                <label className="block">Description:</label>
                            </td>
                            <td className="w-3/4">
                  <textarea
                      name="description"
                      value={editedProduct.description}
                      onChange={handleInputChange}
                      className="mt-1 w-full taller-textarea"
                  ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td className="w-1/4">
                                <label className="block">Current Photo:</label>
                            </td>
                            <td className="w-3/4">
                                {editedProduct.photo && (
                                    <img
                                        src={editedProduct.photo}
                                        alt="Product Photo"
                                        style={{ maxWidth: '250px', maxHeight: '250px' }}
                                    />
                                )}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div className="mt-4 flex justify-end">
                        <button type="submit" className="bg-blue-500 text-white px-3 py-1 rounded">Save Changes</button>
                        <button onClick={closeModal} className="bg-gray-200 text-gray-700 px-3 py-1 rounded ml-3">Cancel</button>
                    </div>
                    {alertMessage && (
                        <div className="mt-4 text-center text-green-500">
                            {alertMessage}
                        </div>
                    )}
                </form>
            </div>
        </div>
    );
}
