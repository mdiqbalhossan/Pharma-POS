<div class="modal fade modal-default" id="print-receipt" aria-labelledby="print-receipt">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="d-flex justify-content-end">
                <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="receipt-content">
                <!-- Receipt content will be loaded here dynamically -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </div>
                    <p>{{ __('Loading receipt...') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for receipt content -->
<script type="text/template" id="receipt-template">
    <div class="icon-head text-center">
        <a href="javascript:void(0);">
            <img src="{{ photo_url(setting('invoice_logo')) }}" width="100" height="30" alt="{{ __('Receipt Logo') }}">
        </a>
    </div>
    <div class="text-center info text-center">
        <h6>{{ setting('company_name') }}</h6>
        <p class="mb-0">{{ __('Phone Number:') }} {{ setting('company_phone') }}</p>
        <p class="mb-0">{{ __('Email:') }} <a href="mailto:{{ setting('company_email') }}">{{ setting('company_email') }}</a></p>
    </div>
    <div class="tax-invoice">
        <h6 class="text-center">{{ __('Sale Invoice') }}</h6>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="invoice-user-name"><span>{{ __('Name:') }} </span><span id="customer-name"></span></div>
                <div class="invoice-user-name"><span>{{ __('Invoice No:') }} </span><span id="invoice-no"></span></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="invoice-user-name"><span>{{ __('Customer Id:') }} </span><span id="customer-id"></span></div>
                <div class="invoice-user-name"><span>{{ __('Date:') }} </span><span id="invoice-date"></span></div>
            </div>
        </div>
    </div>
    <table class="table-borderless w-100 table-fit">
        <thead>
            <tr>
                <th># {{ __('Item') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Qty') }}</th>
                <th class="text-end">{{ __('Total') }}</th>
            </tr>
        </thead>
        <tbody id="receipt-items">
            <!-- Items will be inserted here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <table class="table-borderless w-100 table-fit">
                        <tr>
                            <td>{{ __('Sub Total') }} :</td>
                            <td class="text-end" id="receipt-subtotal"></td>
                        </tr>
                        <tr>
                            <td>{{ __('Discount') }} :</td>
                            <td class="text-end" id="receipt-discount"></td>
                        </tr>
                        <tr>
                            <td>{{ __('Shipping') }} :</td>
                            <td class="text-end" id="receipt-shipping"></td>
                        </tr>
                        <tr>
                            <td>{{ __('Tax') }} :</td>
                            <td class="text-end" id="receipt-tax"></td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Bill') }} :</td>
                            <td class="text-end" id="receipt-total"></td>
                        </tr>
                        <tr>
                            <td>{{ __('Due') }} :</td>
                            <td class="text-end" id="receipt-due"></td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Payable') }} :</td>
                            <td class="text-end" id="receipt-payable"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="text-center invoice-bar">
        <p>{{ __('**VAT against this challan is payable through central registration. Thank you for your business!') }}</p>
        <a href="javascript:void(0);" id="receipt-barcode" class="d-flex justify-content-center mb-2">
        </a>
        <p>{{ __('Sale') }} <span id="receipt-sale-no"></span></p>
        <p>{{ setting('invoice_footer') }}</p>
        <a href="javascript:void(0);" class="btn btn-primary print-button">{{ __('Print Receipt') }}</a>
    </div>
</script>
