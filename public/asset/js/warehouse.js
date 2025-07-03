
const uploadImageWarehouse = document.getElementById('upload-image-warehouse');
const addImageWarehouseProduct = document.getElementById('add-image-warehouse-produk');

uploadImageWarehouse.addEventListener('change', function(e) {
    const file = e.target.files[0];

    addImageWarehouseProduct.src = URL.createObjectURL(file);
})
