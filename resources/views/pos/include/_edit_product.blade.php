<div class="modal fade modal-default pos-modal" id="edit-product" aria-labelledby="edit-product">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5>Red Nike Laser</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="pos.html">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Product Name <span>*</span></label>
                                <input type="text" placeholder="45">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Tax Type <span>*</span></label>
                                <select class="select">
                                    <option>Exclusive</option>
                                    <option>Inclusive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Tax <span>*</span></label>
                                <input type="text" placeholder="% 15">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Discount Type <span>*</span></label>
                                <select class="select">
                                    <option>Percentage</option>
                                    <option>Early payment discounts</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Discount <span>*</span></label>
                                <input type="text" placeholder="15">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="input-blocks add-product">
                                <label>Sale Unit <span>*</span></label>
                                <select class="select">
                                    <option>Kilogram</option>
                                    <option>Grams</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-sm-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
