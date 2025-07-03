document.body.innerHTML += `
<div id="chatbot-button" role="button" class="button-customer-chatbot">
        <img src="${botImage}" alt="BOT">
        <img src="${closeImage}" alt="BOT">
    </div>
    <div class="box-chat-customer-service hide-chat" id="chatbot">
        <div class="wrap-chat" id="box-chat">
            <div class="chat-message left">
                <img src="${botImage}" alt="">
                <div class="message">
                    Hi, saya adalah chatbot customer service anda bebas untuk bertanya.
                </div>
            </div>
        </div>
        <div class="input-message">
            <textarea type="text" rows="1" oninput="this.parentNode.dataset.replicatedValue = this.value" placeholder="Ketikkan pertanyaan anda..." name="message-bot" id="message-bot"></textarea>
        </div>
    </div>`;
let inputMessage = document.getElementById("message-bot");
let boxChatHolder = document.getElementById("box-chat");
let chatbotButton = document.getElementById("chatbot-button");
let chatbot = document.getElementById("chatbot");
let beforeKey = '';
let chats = [];

chatbotButton.addEventListener("click", (event) => {
    chatbot.classList.toggle("hide-chat");
    chatbotButton.classList.toggle("close");
});

inputMessage.addEventListener("keydown", (event) => {
    if (event.code === 'Enter' && !beforeKey.startsWith("Shift")) {
        event.preventDefault();
        let message = inputMessage.value;
        let clearMessage = message.trim().replaceAll("\n", '<br/>');
        appendChat(clearMessage, 'right');
        inputMessage.value = "";
        inputMessage.parentNode.dataset.replicatedValue = inputMessage.value;
        getAnswer(message.trim());
    }
    beforeKey = event.code;
});

const appendChat = (message, position) => {
    boxChatHolder.innerHTML += `<div class="chat-message ${position}">
    <img src="${position === 'left' ? botImage : personImage}" alt="IMAGE">
    <div class="message">
        ${message}
    </div>
</div>
`;
    let last = document.querySelectorAll(".chat-message.right");
    last[last.length - 1].scrollIntoView({behavior: "smooth", inline: "center", block: "center"})
}

const getAnswer = async (questionMessage) => {
    let response = await fetch("https://api.openai.com/v1/completions", {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            "model": model,
            "prompt": questionMessage + "\n",
            "max_tokens": 255,
            "stop": "\n",
            "temperature": 0
        }),
    });
    let gptResponse = await response.json();
    console.log(gptResponse);
    if(gptResponse["choices"][0].text.toString().includes("QUERY")){
        let resSplit = gptResponse["choices"][0].text.split("#");
        let message = "";
        if(resSplit[1] === "QUERY_DETAIL_PRODUCT"){
            message = await  getDetailProduct(resSplit[2]);
        }else if(resSplit[1] === "QUERY_PRODUCT_PRICE"){
            message = await  getProductPrice(resSplit[2]);
        }else if(resSplit[1] === "QUERY_PRODUCT_STOCK"){
            message = await  getProductStock(resSplit[2]);
        }else if(resSplit[1] === "QUERY_DESC_PRODUCT"){
            message = await  getProductDesc(resSplit[2]);
        }else if(resSplit[1] === "QUERY_ALL_CATEGORY"){
            message = await  getAllCategory();
        }else if(resSplit[1] === "QUERY_TOTAL_PRODUCT_SALED"){
            message = await  getTotalProductSale(resSplit[2]);
        }else if(resSplit[1] === "QUERY_BEST_PRODUCT_SALED"){
            message = await  getBestProductSale(resSplit[2]);
        }else if(resSplit[1] === "QUERY_DETAIL_STORE"){
            message = await  getDetailStore(resSplit[2]);
        }else if(resSplit[1] === "QUERY_ADDRESS_STORE"){
            message = await  getAddressStore(resSplit[2]);
        }else if(resSplit[1] === "QUERY_PHONE_NUMBER_STORE"){
            message = await  getPhoneNumberStore(resSplit[2]);
        }else if(resSplit[1] === "QUERY_DESC_STORE"){
            message = await  getDescStore(resSplit[2]);
        }else if(resSplit[1] === "QUERY_AVAILABLE_VOUCHER"){
            message = await  getAvailableVoucher();
        }else if(resSplit[1] === "QUERY_SPEC_PRODUCT"){
            message = await  getSpecProduct(resSplit[2]);
        }else if(resSplit[1] === "QUERY_OWNER_STORE"){
            message = await  getStoreOwner(resSplit[2]);
        }else if(resSplit[1] === "QUERY_RATING_PRODUCT"){
            message = await  getRatingProduct(resSplit[2]);
        }

        appendChat(message, "left");
    }else{
        let message = formatMessage(gptResponse["choices"][0].text).replaceAll("\n", '<br/>');
        appendChat(message, "left");
    }
}

async function getDetailProduct(product_name){
    let response = await fetch("/api/chatbot/query/detail-product",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getProductPrice(product_name){
    let response = await fetch("/api/chatbot/query/product-price",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getProductStock(product_name){
    let response = await fetch("/api/chatbot/query/product-stock",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getProductDesc(product_name){
    let response = await fetch("/api/chatbot/query/product-desc",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}


async function getSpecProduct(product_name){
    let response = await fetch("/api/chatbot/query/spec-product",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getRatingProduct(product_name){
    let response = await fetch("/api/chatbot/query/rating-product",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getAllCategory(){
    let response = await fetch("/api/chatbot/query/all-category",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getAvailableVoucher(){
    let response = await fetch("/api/chatbot/query/available-voucher",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getTotalProductSale(product_name){
    let response = await fetch("/api/chatbot/query/total-product-sale",
        {
            method: "POST",
            body: JSON.stringify({
                "product_name": product_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getBestProductSale(store_name){
    let response = await fetch("/api/chatbot/query/best-product-sale",
        {
            method: "POST",
            body: JSON.stringify({
                "store_name": store_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getDetailStore(store_name){
    let response = await fetch("/api/chatbot/query/detail-store",
        {
            method: "POST",
            body: JSON.stringify({
                "store_name": store_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getStoreOwner(store_name){
    let response = await fetch("/api/chatbot/query/store-owner",
        {
            method: "POST",
            body: JSON.stringify({
                "store_name": store_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getAddressStore(store_name){
    let response = await fetch("/api/chatbot/query/address-store",
        {
            method: "POST",
            body: JSON.stringify({
                "store_name": store_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}

async function getPhoneNumberStore(store_name){
    let response = await fetch("/api/chatbot/query/phone-number-store",
        {
            method: "POST",
            body: JSON.stringify({
                "store_name": store_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}


async function getDescStore(store_name){
    let response = await fetch("/api/chatbot/query/desc-store",
        {
            method: "POST",
            body: JSON.stringify({
                "store_name": store_name,
            }),
            headers: {
                "Content-Type": "application/json",
            }
        });
    let respondApi = await response.json();
    return respondApi["answer"];
}


const formatMessage = (message) => {
    while (message.startsWith("\n")) {
        message = message.slice(1);
    }
    return message;
}
