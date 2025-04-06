<div class="modal fade pos-modal" id="recents" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h5 class="modal-title">Recent Transactions</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset d-flex align-items-center h-100"><img
                                    src="assets/img/icons/search-white.svg" alt="img"></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paidOrders->merge($unpaidOrders)->sortByDesc('created_at')->take(10) as $order)
                                <tr>
                                    <td>{{ $order->sale_date }}</td>
                                    <td>#{{ $order->sale_no }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>
                                        @if ($order->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($order->payment_status == 'unpaid')
                                            <span class="badge bg-warning">Unpaid</span>
                                        @elseif($order->status == 'pending')
                                            <span class="badge bg-secondary">On Hold</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->grand_total }}</td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <a class="me-2 p-2 view-products" href="javascript:void(0);"
                                                data-id="{{ $order->id }}" data-sale-no="{{ $order->sale_no }}">
                                                <i data-feather="eye" class="feather-eye"></i>
                                            </a>
                                            @if ($order->status != 'cancelled')
                                                <a class="p-2 print-receipt" href="javascript:void(0);"
                                                    data-id="{{ $order->id }}">
                                                    <i data-feather="printer" class="feather-eye"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recent transactions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
