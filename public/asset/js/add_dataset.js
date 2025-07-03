function addForm(){
    $("#content-dataset").append(`
   <div class="rounded col-12 shadow-sm p-2 mb-3">
                                            <div class="d-flex flex-md-row flex-column justify-content-md-between">
                                                <div class="col-12 col-md-5 d-flex flex-column">
                                                    <label>Pertanyaan</label>
                                                    <input type="text" placeholder="Pertanyaan disini" name="questions[]" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-5 d-flex flex-column">
                                                    <label>Jawaban</label>
                                                    <input type="text" placeholder="Jawaban disini" name="answer[]" class="form-control">
                                                </div>
                                            </div>
                                        </div>`);
}

addForm();
$("#button-add").click(function (event) {
   addForm();
});
