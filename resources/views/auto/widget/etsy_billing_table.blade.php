<table class="sold-table">
    <span class='total-entries'>Total entries : {{ count($transactions) }}</span>
    <thead>
        <th class="all-input-th">

        <input type="checkbox"  class="option-input radio" id="all-check-billing" onclick="allcheckBilling();">

        </th>
        <th>Billing Payment ID</th>
        <th>Transaction Date</th>
        <th>Transaction Type</th>
        <th>Amount</th>
        <th>Currency</th>
    </thead>
        @if($pagination->total_transactions > 0)
        @foreach($transactions as $transaction)
        <tr>
            <td>
                <input type="checkbox" name="sold[]" class="fee-checkbox-billing option-input radio" >
            </td>
            <td>
                <div class="table-val">
                    {{$transaction->bill_charge_id}}
                </div>
            </td>
            <td>
                <div class="table-val">
                    {{\Carbon\Carbon::parse($transaction->creation_tsz)}}
                </div>
            </td>
            <td><div class="table-val">{{$transaction->label}}</div></td>
            <td><div class="table-val">{{$transaction->amount}}</div></td>
            <td><div class="table-val">{{$transaction->currency_code}}</div></td>
            </tr>
        
            <?php $i=0; ?>
        @endforeach
        <tr><td colspan='20' id="no-data" class='text-center'><strong>No Sold</strong></td></tr>
    @else
       <tr><td colspan='20' class='empty-data text-center'><strong>No Sold</strong></td></tr>
    @endif
  
</table>





