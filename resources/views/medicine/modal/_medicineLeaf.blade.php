<div class="modal fade" id="add-medicine-leaf">
    <div class="modal-dialog modal-dialog-centered custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>Add New Medicine Leaf</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="medicine-leaf-form" action="{{ route('medicine-leafs.ajax.store') }}" method="POST">
                        @csrf
                        <div class="modal-body custom-modal-body">
                            <div class="alert alert-success d-none" id="medicine-leaf-success-message"></div>
                            <div class="alert alert-danger d-none" id="medicine-leaf-error-message"></div>

                            {{-- Type --}}
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <input type="text" class="form-control" name="type" id="medicine-leaf-type"
                                    required placeholder="Enter type (e.g. Blister, Bottle)">
                                <div class="invalid-feedback" id="medicine-leaf-type-error"></div>
                            </div>

                            {{-- Quantity Per Box --}}
                            <div class="mb-3">
                                <label class="form-label">Quantity Per Box</label>
                                <input type="number" class="form-control" name="qty_box" id="medicine-leaf-qty-box"
                                    required placeholder="Enter quantity per box">
                                <div class="invalid-feedback" id="medicine-leaf-qty-box-error"></div>
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
