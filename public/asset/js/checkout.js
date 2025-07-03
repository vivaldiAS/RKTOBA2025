let selectedItems = [];

function addItem(id, name, price, stok) {
    const cardProduct = document.getElementById(`card-product-${id}`);

    let item = {
        id: id,
        name: name,
        price: price,
        quantity: 1,
        currentQuantity: stok,
    };

    let index = selectedItems.findIndex((i) => i.name === name);
    if (index !== -1) {
        if (selectedItems[index].currentQuantity <= 0) {
            alert(`Stok ${item.name} Habis`);
        } else {
            selectedItems[index].quantity++;
            --selectedItems[index].currentQuantity;

            if (selectedItems[index].currentQuantity == 0) {
                cardProduct.classList.add("bg-danger");
            }

            const stok = document.getElementById(`stok-${id}`);
            stok.innerText = `Stok : ${selectedItems[index].currentQuantity}`;
        }
    } else {
        if (!(item.currentQuantity <= 0)) {
            --item.currentQuantity;
            selectedItems.push(item);
            const stok = document.getElementById(`stok-${id}`);
            stok.innerText = `Stok : ${item.currentQuantity}`;
        } else {
            alert(`Stok ${item.name} Habis`);
            cardProduct.classList.add("bg-danger");
        }
    }

    refreshTable();
}
const boxSelectedItem = document.getElementById("box-items-selected");

function priceFormat(price) {
    const formattedPrice = price.toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
    });

    return formattedPrice;
}

function refreshTable() {
    boxSelectedItem.replaceChildren();

    let total = 0;

    selectedItems.forEach((item, index) => {
        const rowNode = document.createElement("div");
        rowNode.classList.add("row");

        const element = `
            <div class="col-md-1 text-center p-3">${index + 1}</div>
            <div class="col-md-5 text-center p-3">${item.name}</div>
            <div class="col-md-3 text-center p-3">${item.quantity}</div>
            <div class="col-md-3 text-center p-3">${priceFormat(
                item.price * item.quantity
            )}</div>
        `;

        rowNode.innerHTML = element;

        boxSelectedItem.appendChild(rowNode);

        total += item.price * item.quantity;
    });

    let totalElement = document.getElementById("total");
    totalElement.innerHTML = `Total : ${priceFormat(total)}`;
}

$(document).ready(function () {
    // mencari tombol "Batalkan Pesanan" dan menambahkan fungsi click
    $(".btn-danger").click(function () {
        // menghapus semua baris dari tabel kecuali header
        $("#selected-items-table tbody tr").remove();
        let totalElement = document.getElementById("total");
        totalElement.innerHTML = "Total : Rp. 0,00";
        selectedItems.forEach((el) => {
            const stok = document.getElementById(`stok-${el.id}`);
            stok.innerText = `Stok : ${el.currentQuantity + el.quantity}`;
        });
        selectedItems = [];
        boxSelectedItem.replaceChildren();
    });
});

// form search
const searchIcon = document.getElementById("search-icon");
const searchFormRow = document.getElementById("search-form-row");
const closeIcon = document.getElementById("icon-close");
const confirmPayment = document.getElementById("payment_confirm");
const searchInput = document.querySelector('input[type="text"]');

searchIcon.addEventListener("click", () => {
    searchFormRow.style.display = "block ";
});

closeIcon.addEventListener("click", () => {
    searchFormRow.style.display = "none ";
    searchInput.value = "";
    refreshGridItem(searchInput.value);
});

confirmPayment.addEventListener("click", async function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    await fetch("/admin/request/gallery", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": csrfToken,
        },
        body: JSON.stringify({
            data: selectedItems.map((el, i) => {
                return {
                    id: el.id,
                    quantity: el.quantity,
                    price: el.price,
                };
            }),
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            const { message } = data;

            alert(message);
            // location.reload();
            $("#selected-items-table tbody tr").remove();
            let totalElement = document.getElementById("total");
            totalElement.innerHTML = "Total : Rp. 0,00";
            selectedItems = [];
            boxSelectedItem.replaceChildren();
        })
        .catch((error) => {
            console.log(error.message);
            // handle any errors here
        });
});

searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase().trim();

    refreshGridItem(searchTerm);
});

function refreshGridItem(searchTerm) {
    const products = document.querySelectorAll(".card-product");

    products.forEach(function (product) {
        const title = product
            .querySelector(".card-product-title")
            .textContent.toLowerCase();
        const merchant = product
            .querySelector(".card-product-merchant")
            .textContent.toLowerCase();
        const price = product
            .querySelector(".card-product-price")
            .textContent.toLowerCase();

        if (
            title.indexOf(searchTerm) > -1 ||
            merchant.indexOf(searchTerm) > -1 ||
            price.indexOf(searchTerm) > -1
        ) {
            product.classList.add("d-flex");
            product.classList.remove("d-none");
        } else {
            product.classList.remove("d-flex");
            product.classList.add("d-none");
        }
    });
}
