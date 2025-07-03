const image_meta = document.getElementById('image-meta');
const assetPath = image_meta.getAttribute('content');
const btn_choose_warehouse = document.getElementById('choose-warehouse');
const product_container = document.getElementById('product_container');

const nama_produk = document.getElementById('nama_produk')
const jenis_produk = document.getElementById('jenis_produk')
const expired_date = document.getElementById('expired_date')
const deskripsi_produk = document.getElementById('deskripsi_produk')
const harga = document.getElementById('harga')
const berat = document.getElementById('berat')
const jumlah = document.getElementById('jumlah')
const imageWarehouseProduk = document.getElementById('add-image-warehouse-produk')
const product_image= document.getElementById('upload-image-gallery');


async function fetchData(url = '/gallery/warehouse/api') {
    const response = await fetch(url)
        .then(response => response.json())
        .then(data => data)
        .catch(error => console.error(error));

    return response;
}
const loading = () => `<p class="text-danger fs-7">Loading...</p>`;

const makeLoading = () => {
    product_container.innerHTML = loading();
}


const card = (data) => {
    const { product_name, product_description, price, image } = data;
    return `
    <div class="col-md-4">
        <div class="card">
            <img class="card-img-top"
                src="${assetPath}/${image}"
                    alt="Card image cap">
                <div class="card-body py-3">
                    <h5 class="card-title fs-6 mb-1">${product_name}</h5>
                    <p class="card-text fs-7 mb-1">${product_description}</p>
                    <p class="card-text font-weight-bold">Rp. ${price.toLocaleString('id-ID')}</p>
                    <span href="#" class="btn btn-primary fs-7 btn-choose" data-dismiss="modal">Pilih produk</span>
                    <input type="hidden" id="data" value='${JSON.stringify(data)}' />
                </div>
            </div>
        </div>`;
}


const makePageItem = (links) => {

    let result = '';

    links.forEach((el, i) => {
        const { label, active, url, current_page, last_page } = el;
        let page_item = `<li class="page-item ${active ? 'active' : ''} ${(current_page === +label) ? 'disabled' : ''}">
            <span class="page-link" href="#" data-href="${url}">${label}</span>
        </li>`;
        result += page_item
    })

    return result;
}

const paginationEvenListener = (box_pagination) => {
    const page_items = box_pagination.querySelectorAll('.page-item');

    page_items.forEach((el, i) => {
        const href_url = el.querySelector('.page-link').getAttribute('data-href');
        el.addEventListener('click', async function () {
            makeLoading();
            const data = await fetchData(href_url);
            makeComponent(data);
        })
    })
}

const pagination = (links) => {
    const box_pagination = document.getElementById('pagination');

    const component = `
        ${makePageItem(links)}
        `;

    box_pagination.innerHTML = component;

    paginationEvenListener(box_pagination);
}

const chooseSelect = (category_id) => {

}

const chooseProductListener = (product_container) => {
    const allButtons = document.querySelectorAll('.btn-choose');

    allButtons.forEach((el, i) => {
        let { category_id, product_name, product_description, expired_at, price, heavy, stok, image } = JSON.parse(el.nextSibling.nextSibling.value);
        const dateString = expired_at;
        const dateObj = new Date(dateString);
        const formattedDate = dateObj.toISOString().substr(0, 10);


        el.addEventListener('click', function () {
            jenis_produk.value = category_id;
            nama_produk.value = product_name;
            expired_date.value = formattedDate;
            deskripsi_produk.value = product_description;
            harga.value = price;
            berat.value = heavy;
            jumlah.value = stok;
            imageWarehouseProduk.src = `${assetPath}/${image}`;
            product_image.value =  `${image}`;
        });
    })
}

function makeComponent(fetchData) {

    const { data, current_page, first_page_url, from, last_page, last_page_url, links, next_page_url, path, per_page, prev_page_url, total } = fetchData;

    let component = '';

    data.forEach((el, i) => {
        component += card(el);
    });

    product_container.innerHTML = component;
    pagination(links);
    chooseProductListener(product_container);
}

btn_choose_warehouse.addEventListener('click', async function () {
    makeLoading();
    const response = await fetch('/gallery/warehouse/api')
        .then(response => response.json())
        .then(data => data)
        .catch(error => console.error(error));

    makeComponent(response);
})
