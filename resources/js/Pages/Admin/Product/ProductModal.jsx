import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function ProductModal({ product, onClose, onSave, mode }) {
    const [editedProduct, setEditedProduct] = useState(product || {});
    const [alertMessage, setAlertMessage] = useState(null);
    const [preview, setPreview] = useState(null);

    useEffect(() => {
        setEditedProduct(product || {});
        setPreview(product?.image_url || null);
    }, [product]);

    const closeModal = () => {
        onClose();
    };

    const saveChanges = async (e) => {
        e.preventDefault();
        try {
            const formData = new FormData();
            for (const key in editedProduct) {
                if (key === 'image' && editedProduct[key] instanceof File) {
                    formData.append(key, editedProduct[key]);
                } else {
                    formData.append(key, editedProduct[key]);
                }
            }

            let response;
            let message
            if (mode === 'edit') {
                response = await axios.post(`/api/admin/product/${editedProduct.id}`, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
            } else {
                response = await axios.post('/api/admin/product', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
            }

            if (response.status === 200 || response.status === 201 ) {
                message = mode === 'edit' ? 'Product updated successfully' : 'Product added successfully' ;
                setAlertMessage(message);
                setTimeout(() => {
                    // MODIFIED: Pass response.data instead of editedProduct
                    onSave(response.data);
                    closeModal();
                }, 2000);
            } else {
                message =  mode === 'edit' ? 'Failed to update product' : 'Failed to add product';
                setAlertMessage(message);
            }
        } catch (error) {
            console.error('Error saving product:', error);
            setAlertMessage('An error occurred while saving the product');
        }
    };

    const handleInputChange = (e) => {
        const { name, value, type, files } = e.target;
        if (type === 'file') {
            const file = files[0];
            setEditedProduct(prev => ({ ...prev, [name]: file }));

            // Create a preview URL
            const reader = new FileReader();
            reader.onloadend = () => {
                setPreview(reader.result);
            };
            if (file) {
                reader.readAsDataURL(file);
            } else {
                setPreview(null);
            }
        } else {
            setEditedProduct(prev => ({ ...prev, [name]: value }));
        }
    };

    return (
        <div className="fixed inset-0 flex items-center justify-center z-50">
            <div className="absolute inset-0 bg-black opacity-50"></div>
            <div className="bg-white rounded-lg shadow-lg p-6 z-10" style={{ width: '75%' }}>
                <h2 className="text-lg font-semibold mb-3">{mode === 'edit' ? 'Edit Product' : 'Add Product'}</h2>
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
                                    value={editedProduct.name || ''}
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
                                    value={editedProduct.price || ''}
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
                                        value={editedProduct.description || ''}
                                        onChange={handleInputChange}
                                        className="mt-1 w-full taller-textarea"
                                    ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td className="w-1/4">
                                <label className="block">Product Image:</label>
                            </td>
                            <td className="w-3/4">
                                <input
                                    type="file"
                                    name="image"
                                    onChange={handleInputChange}
                                    accept="image/*"
                                    className="mt-1 w-full"
                                />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    {preview && (
                        <div className="mt-4">
                            <h3 className="font-semibold">Image Preview:</h3>
                            <div className="mt-2 w-48 h-48 overflow-hidden">
                                <img
                                    src={preview}
                                    alt="Preview"
                                    className="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                    )}


                    <div className="mt-4 flex justify-end">
                        <button type="submit" className="bg-blue-500 text-white px-3 py-1 rounded">
                            {mode === 'edit' ? 'Save Changes' : 'Add Product'}
                        </button>
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
