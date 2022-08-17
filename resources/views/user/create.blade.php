    <div class="modal fade" id="storeBook" tabindex="-1" role="dialog" aria-labelledby="modalStore" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalStore">Store Book</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-3">
                                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <ul id="saveform_errlist"></ul>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <label class="form-control-label">Book Title: </label>
                                        <input name="title" id="title" type="text"
                                            class="form-control "placeholder="Book Tittle" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Book Code: </label>
                                        <input name="code" id="code" type="text" class="form-control"
                                            placeholder="Book Code" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Author: </label>
                                        <input name="author" id="author" type="text" class="form-control"
                                            placeholder="Book Author" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Description: </label>
                                        <textarea name="description" id="description" type="text" class="form-control" placeholder="Book Description" /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1 store">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
