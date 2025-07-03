let min_created_at = 1690288746;
let ft = [];
let withRestart = false;

async function getAllFineTunes() {
    let response = await fetch("https://api.openai.com/v1/fine-tunes", {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${token}`,
            "Content-Type": "application/json",
        },
    });
    let gptResponse = await response.json();
    let data = gptResponse["data"].filter((item) => item["created_at"] >= min_created_at && item["fine_tuned_model"] !== null);
    ft = data;
    console.log(data);
    $("#select-model").empty().append(`
        <option >Pilih Model</option>
        `);
    data.forEach((d) => {
        $("#select-model").append(`
        <option value="${d['id']}">${d['fine_tuned_model'].replace("ada:ft-ta-1-del:compact-", "")}</option>
        `);
    });
}

let loadingActivateModel = false;
$("#activate-model").click(async function (event) {
    if (!loadingActivateModel) {
        loadingActivateModel = true;
        $(this).val("Loading...").addClass("disabled");
        let found = ft.find((item) => item['id'] === $("#select-model").val());
        if (found !== null) {
            let response = await fetch("/api/chatbot/activate-model", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    "fine_tune_id": found["id"],
                    "model_name": found["fine_tuned_model"]
                })
            });
            await response.json();
            loadingActivateModel = false;
            withRestart = true;
            $(this).val("Aktifkan Model").removeClass("disabled");
            showModalSuccess(`Success to activate model to ${found["fine_tuned_model"]}`);
        }
    }
});
$("#close-modal-button").click(function (event) {
    $("#custom-model").addClass("hide");
    if(withRestart){
        window.location.reload();
    }
})

$("#fine-tune").click(async function () {
    $(this).text("Loading to Fine Tune").addClass("disabled");
     let respond = await fetch("/api/chatbot/fine-tune", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            "training_file": "file-W7eyVj9i8SatC3xNLEGSAlXX",
            "model": "ada",
            "suffix":'compact-model-ta',
        }),
    });
     let jsonRes = await respond.json();
     console.log(jsonRes);
    $(this).text("Fine Tune Model").removeClass("disabled");
    showModalSuccess("Success to request train data");
});
$("#check-fine-tune").click(async function () {
    $("#check-fine-tune").text("Loading to get status").addClass("disabled");
    let response = await fetch("https://api.openai.com/v1/fine-tunes", {
        method: "GET",
        headers: {
            'Authorization': `Bearer ${token}`,
            "Content-Type": "application/json",
        },
    });
    let gptResponse = await response.json();
    let data = gptResponse["data"].filter((item) => item["created_at"] >= min_created_at && item["status" ] !== "cancelled");
    let last = data[data.length - 1];
    if(last["status"] === "succeeded"){
        showModalSuccess("Done To Train Model");
    }else{
        showModalWaiting("Status Last Fine Tune Is Waiting");
    }
    $("#check-fine-tune").text("Check Fine Tune Status").removeClass("disabled");
})

getAllFineTunes();

function showModalSuccess(message) {
    $("#custom-model").toggleClass("hide");
    $("#icon-message").empty().append(`
    <i  class="fas fa-check-circle text-success size-40"></i>`);
    $("#message").empty().append(`
    <span class="text-success text-center">${message}</span>`);
}


function showModalWaiting(message) {
    $("#custom-model").toggleClass("hide");
    $("#icon-message").empty().append(`
    <i  class="fas fa-clock text-warning size-40"></i>`);
    $("#message").empty().append(`
    <span class="text-warning text-center">${message}</span>`);
}
