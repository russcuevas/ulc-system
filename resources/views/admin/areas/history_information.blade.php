@foreach ($clients as $client)
<div class="modal fade" id="loanInfoModal{{ $client->id }}" tabindex="-1" aria-labelledby="loanInfoModalLabel{{ $client->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loanInfoModalLabel{{ $client->id }}">Loan Information - {{ $client->fullname }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Client Loans Table --}}
                <h6 class="mb-3">Loans</h6>
                <div class="table-responsive mb-3">
                    <table id="clientsLoans" class="table table-hover table-striped dataTable js-basic-example">
                        <thead class="table-light">
                            <tr>
                                <th>PN Number</th>
                                <th>Loan</th>
                                <th>Amount</th>
                                <th>Terms</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientsLoans->where('client_id', $client->id) as $loan)
                            <tr>
                                <td>{{ $loan->pn_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->loan_from)->format('F j, Y') }} to {{ \Carbon\Carbon::parse($loan->loan_to)->format('F j, Y') }}</td>
                                <td>₱{{ number_format($loan->loan_amount, 2) }}</td>
                                <td>{{ $loan->loan_terms }}</td>
                                <td>₱{{ number_format($loan->balance, 2) }}</td>
                                <td style="text-transform: capitalize">{{ $loan->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <br>
                <br>
                <br>
                <h6 class="mb-3">Collections</h6>
                <div class="table-responsive">
                    <table id="clientsCollections" class="table table-hover table-striped dataTable js-basic-example">
                        <thead class="table-light">
                            <tr>
                                <th>PN Number</th>
                                <th>Reference #</th>
                                <th>Collection By</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientsDailies->where('client_id', $client->id) as $daily)
                            @php
                                $loan = $clientsLoans->firstWhere('id', $daily->client_loans_id);
                            @endphp
                            <tr>
                                <td>{{ $loan?->pn_number ?? 'N/A' }}</td>
                                <td>{{ $daily->reference_number }}</td>
                                <td>{{ $daily->collected_by }}</td>
                                <td>{{ \Carbon\Carbon::parse($daily->due_date)->format('F j, Y') }}</td>
                                <td>₱{{ number_format($daily->collection, 2) }}</td>
                                <td>{{ $daily->type ?? 'No Payment' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach