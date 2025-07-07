<div class="modal fade" id="add-supplier">
    <div class="modal-dialog modal-dialog-centered custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>Add New Supplier</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="supplier-form" action="{{ route('suppliers.ajax.store') }}" method="POST">
                        @csrf
                        <div class="modal-body custom-modal-body">
                            <div class="alert alert-success d-none" id="supplier-success-message"></div>
                            <div class="alert alert-danger d-none" id="supplier-error-message"></div>

                            {{-- Name --}}
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="supplier-name" required
                                    placeholder="Enter name">
                                <div class="invalid-feedback" id="supplier-name-error"></div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="supplier-email"
                                    placeholder="Enter email">
                                <div class="invalid-feedback" id="supplier-email-error"></div>
                            </div>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" id="supplier-phone"
                                    placeholder="Enter phone">
                                <div class="invalid-feedback" id="supplier-phone-error"></div>
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="supplier-address" placeholder="Enter address"></textarea>
                                <div class="invalid-feedback" id="supplier-address-error"></div>
                            </div>

                            <div class="row">
                                {{-- City --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city" id="supplier-city"
                                        placeholder="Enter city">
                                    <div class="invalid-feedback" id="supplier-city-error"></div>
                                </div>

                                {{-- State --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="state" id="supplier-state"
                                        placeholder="Enter state">
                                    <div class="invalid-feedback" id="supplier-state-error"></div>
                                </div>

                                {{-- Zip --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Zip</label>
                                    <input type="text" class="form-control" name="zip" id="supplier-zip"
                                        placeholder="Enter zip">
                                    <div class="invalid-feedback" id="supplier-zip-error"></div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Opening Balance --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Opening Balance</label>
                                    <input type="number" step="0.01" class="form-control" name="opening_balance"
                                        id="supplier-opening-balance" placeholder="Enter opening balance">
                                    <div class="invalid-feedback" id="supplier-opening-balance-error"></div>
                                </div>

                                {{-- Opening Balance Type --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Balance Type</label>
                                    <select class="form-select" name="opening_balance_type"
                                        id="supplier-opening-balance-type">
                                        <option value="debit">Debit</option>
                                        <option value="credit">Credit</option>
                                    </select>
                                    <div class="invalid-feedback" id="supplier-opening-balance-type-error"></div>
                                </div>
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
