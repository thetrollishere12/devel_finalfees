<link href="{{asset('css/ebay_sold_item.css?4')}}" rel="stylesheet" type="text/css" />
<div class="import-table">
        <select id="active_select" name="ebay_id" onchange="activeSelect();">
            <?php foreach ($ebay_account as $key => $value) {
                $sel="";
                if(isset($select_id))
                {
                    if($value->id==$select_id)
                    {
                        $sel="selected";
                    }
                } else  { $sel=""; }
            ?>
            <option <?php echo $sel; ?> value="<?php echo $value->id; ?>">Ebay - <?php echo $value->ebay_email; ?></option>

            <?php } ?>
        </select>
        <!--start : date field and show all-->
        <!--end : date field and show all-->
        <span class='total-entries'>Total entries : {{{$pagenation[0]['totalentries']}}}</span>
    </div>

    <table class="sold-table">
        <thead>
            <th class="all-input-th">

            <input type="checkbox"  class="option-input radio" id="all-check" onclick="allcheck();">
   
            </th>
            <th>Image</th>
            <th>Transaction Id</th>
            <th>Item Id</th>
            <th>Sale Date</th>
            <th>Name</th>
            <th>Quantities</th>
            <th>Sold Price</th>
            <th>Item Cost</th>
            <th>Shipping Charge</th>
            <th>Shipping Cost</th>
            <th>Final Value Fee</th>
            <th>AD Fee</th>
            <th>Paypal Fee</th>
            <th>Tax On Subtotal</th>
            <th>Tax On Shipping</th>
            <th>Tax On Handling</th>
            <th>Total Tax</th>
            <th>Subtotal</th>
            <th>Profit</th>
        </thead>
        <?php $i=1; ?>
        @if(isset($order_details) && count($order_details)!=0)
            @foreach($order_details as $order_info)
                <tr>
                    <td>
                        <input type="checkbox" name="sold[]" class="fee-checkbox option-input radio" >
                    </td>
                   
                    <td class="table-img">
                        @if(isset($order_info['image_url']))
                        <input type="image" src="{{$order_info['image_url']}}" > </td>
                        @endif
                    <td>
                        <div class="table-val">
                        @php
                                $transaction_id = explode('-',$order_info['OrderLineItemID']);
                                if(isset($transaction_id[1]))
                                echo $transaction_id[1];
                                else
                                echo "no transaction";

                            @endphp
                        </div>
                    </td>
                    <td>
                        <div class="table-val">
                        @if(isset($order_info['ItemID']))
                        {{$order_info['ItemID']}}
                        @endif
                        </div>
                    </td>
                    <td> <div class='table-val sold-date'>@dateconvert($order_info['CreatedTime'])</div></td>
                    <td><div class="table-val table-name">{{$order_info['title']}}</div></td>
                    <td><div class="table-val">@if(isset($order_info['QuantityPurchased'])){{$order_info['QuantityPurchased']}} @endif</div> </td>
                    <td><div class="table-val">{{$order_info['AmountPaid']- $order_info['ShippingServiceCost']-$order_info['TotalTaxAmount']}}</div> </td>
                    <td class="table-input"><input type='text' class="item-cost" value='0.0' old-val = ''>
                    </td>
                 
                    
                    <td><div class="table-val">{{$order_info['ShippingServiceCost']}}</div> </td>
                    <td class="table-input">
                        <input type='text' class="shipping-cost" value='0.0' old-val = ''>
                    </td>
                    <td><div class="table-val">{{$order_info['FinalValueFee']}}</div> </td>
                     <td>
                         <div class='table-val'>@if(isset($order_info['adfee'])){{$order_info['adfee']}} @endif</div>
                     </td>
                    <td><div class="table-val">{{$order_info['FeeOrCreditAmount']}}</div> </td>
                    <td><div class="table-val">{{$order_info['TaxOnSubtotalAmount']}}</div> </td>
                    <td><div class="table-val">{{$order_info['TaxOnShippingAmount']}}</div> </td>
                    <td><div class="table-val">{{$order_info['TaxOnHandlingAmount']}}</div> </td>
                    <td><div class="table-val">{{$order_info['TotalTaxAmount']}}</div> </td>
                    <td><div class="table-val"> {{$order_info['AmountPaid']-$order_info['TotalTaxAmount']}}</div> </td>
                    <td><div class="table-val">@if(isset($order_info['adfee'])) {{$order_info['AmountPaid']-$order_info['TotalTaxAmount']-$order_info['FinalValueFee']-$order_info['FeeOrCreditAmount']
                        -$order_info['adfee']}} @endif</div> </td>
                    </tr>
               
                <?php $i=0; ?>
            @endforeach
            <tr><td colspan='20' id="no-data" class='text-center'><strong>No Sold</strong></td></tr>
        @else
           <tr><td colspan='20' class='empty-data text-center'><strong>No Sold</strong></td></tr>
        @endif
    </table>

    @if($pagenation[0]['totalpages'] != 1 )
        <div class="paging">
    <ul>
      @for($i=1;$i<$pagenation[0]['totalpages']+1;$i++)
      <li onclick="selectPage({{$i}});" @if($i == $pagenation[0]['pagenumber']) class="page-number" id='page-active' @else class='page-number page-deactive' @endif><a >{{$i}}</a></li>
      @endfor
    </ul>
    </div>
    @endif

    <span class="green">Don't See Your Item</span>
    <div class="tooltip">
        <img class="question_img" src="{{url('image/question2.png')}}" alt="question mark">
        <div class="right">
            <div class="text-content">
                <p>Some of your recently sold products may take 24 hours to appear since it takes time for eBay to update your account.</p>
            </div>
            <i></i>
        </div>
    </div>

    @if(isset(Auth::user()->email_verified_at))
                <div id="list"></div>
                <div>
                    <button class="create_sheet" data-toggle="modal" data-target="#add_page">Create Spreadsheet</button>
                </div>
    @endif
            <div class="alert alert-dismissible collapse newsheet-alert">
                <button type="button" id="newsheet_close_alert" class="close">&times;</button>
                <div class="alert-message newsheet-alert-message"></div>
             </div>
             
@if(isset($pagenation[0]['pagenumber']) && $pagenation[0]['pagenumber'] ==1)
    <script>
        $(document).ready(function(){
        popMessage('warning','You can update the item cost or shipping cost by clicking');
        });
    </script>
@endif
<script src="{{asset('js/ebay_sold_item.js?'.time().'')}}" type="text/javascript"></script>
<script src="{{asset('js/sold_item.js?'.time().'')}}" type="text/javascript"></script>
