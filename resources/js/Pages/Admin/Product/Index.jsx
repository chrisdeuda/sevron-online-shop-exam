import React, { useState } from 'react';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout';
import PrimaryButton from '@/components/PrimaryButton';
import ProductModal from "@/Pages/Admin/Product/ProductModal.jsx";

const Index = ({ auth, products: initialProducts, can })  => {
    const [modalProduct, setModalProduct] = useState(null);
    const [modalOpen, setModalOpen] = useState(false);
    const [modalMode, setModalMode] = useState('');
    const [products, setProducts] = useState(initialProducts)

    const openModal =  (product,mode) => {
        setModalProduct(product);
        setModalMode(mode);
        setModalOpen(true);
    }

    const closeModal = () => {
        setModalProduct(null);
        setModalOpen(false);
    };


    // Add debugging
    console.log('Dashboard Auth:', auth);

    // Add basic validation
    if (!auth || !auth.user) {
        return <div>Loading...</div>;
    }

    const saveProductChanges = (updatedProduct) => {
        if (modalMode === 'edit') {
            setProducts(prevProducts => ({
                ...prevProducts,
                data: prevProducts.data.map(
                    product => product.id === updatedProduct.id ? updatedProduct : product
                )
            }));
        } else if (modalMode === 'add') {
            setProducts(prevProducts => ({
                ...prevProducts,
                data: [...prevProducts.data, updatedProduct]
            }));
        }
        closeModal();
    };

    return (

        <AuthenticatedLayout
            auth={auth}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Admin Products</h2>}
        >

            <div>
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Product
                </h2>
            </div>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="flex bg-gray-800 justify-between items-center p-5">
                            <div className="flex space-x-2 items-center text-white">
                                Product Settings Page! Here you can list, create, update or delete product!
                            </div>
                            {can.create && (
                                <div className="flex space-x-2 items-center">
                                    <a href="#"
                                       className="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center"
                                       onClick={() => openModal(null, 'add')}>
                                        <span className="iconify mr-1" data-icon="gridicons:create"
                                              data-inline="false"></span> Create Product
                                    </a>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" className="py-3 px-6">Title</th>
                                <th scope="col" className="py-3 px-6">Description</th>
                                {(can.edit || can.delete) && <th scope="col" className="py-3 px-6">Actions</th>}
                            </tr>
                            </thead>
                            <tbody>
                            {products.data.map((product) => (
                                <tr key={product.id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td data-label="Title" className="py-4 px-6">
                                        {product.name}
                                    </td>
                                    <td data-label="Title" className="py-4 px-6">
                                        {product.description}
                                    </td>
                                    {(can.edit || can.delete) && (
                                        <td className="py-4 px-6 w-48">
                                            <div className="flex justify-start lg:justify-end">
                                                {can.edit && (
                                                    <PrimaryButton
                                                        className="ml-4 bg-green-500 px-2 py-1 rounded text-white cursor-pointer"
                                                        onClick={() => openModal(product, 'edit')}
                                                    >
                                                        Edit
                                                    </PrimaryButton>
                                                )}
                                                {can.delete && (
                                                    <PrimaryButton className="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer">
                                                        Delete
                                                    </PrimaryButton>
                                                )}
                                            </div>
                                        </td>
                                    )}
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {modalOpen && (
                <ProductModal
                    product={modalProduct}
                    onClose={closeModal}
                    onSave={saveProductChanges}
                    mode={modalMode}
                />
            )}
        </AuthenticatedLayout>
    );
};

export default Index;
