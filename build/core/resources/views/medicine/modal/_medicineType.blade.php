<div class="modal fade" id="add-medicine-type">
    <div class="modal-dialog modal-dialog-centered custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>Add New Medicine Type</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="medicine-type-form" action="{{ route('medicine-types.ajax.store') }}" method="POST">
                        @csrf
                        <div class="modal-body custom-modal-body">
                            <div class="alert alert-success d-none" id="medicine-type-success-message"></div>
                            <div class="alert alert-danger d-none" id="medicine-type-error-message"></div>

                            {{-- Name --}}
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="medicine-type-name"
                                    required placeholder="Enter name">
                                <div class="invalid-feedback" id="medicine-type-name-error"></div>
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="medicine-type-description" placeholder="Enter description"></textarea>
                                <div class="invalid-feedback" id="medicine-type-description-error"></div>
                            </div>

                            <div class="modal-footer-btn">
                                <a href="javascript:void(0);" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
