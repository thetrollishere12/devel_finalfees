
<div class="import-table">
    @if($pagination->total_page > 0 )
        <span class='total-page'>Page {{$pagination->effective_page}}/{{$pagination->total_page}}</span>
    @endif
        <span class='total-entries'>Total entries : {{{$pagination->total_transactions}}}</span>
    </div>

    <table class="sold-table">
        <thead>
            <th class="all-input-th">

            <input type="checkbox"  class="option-input radio" id="all-check" onclick="allcheck();">
   
            </th>
            <th>Transaction Id</th>
            <th>Sale Date</th>
            <th>Image</th>
            <th>Name</th>
            <th>Quantities</th>
            <th>Currency</th>
            <th>Sold Price</th>
            <th>Item Cost</th>
            <th>Shipping Charge</th>
            <th>Shipping Cost</th>
            <th>Discount</th>
            <th>Sale Fees</th>
            <th>Total Tax</th>
            <th>Sub Total</th>
            <th>Profit</th>
        </thead>
        <?php $i=1;$o=0; ?>
        @if($pagination->total_transactions > 0)
            @foreach($transaction_sale as $transaction)
            
            @php
            $o++;
            @endphp
        
            <tr class="transaction transaction_blk_{{ $o }}" data-count="{{ $o }}">
                <td>
                    <input type="checkbox" name="sold[]" class="fee-checkbox option-input radio" >
                </td>
                <td>
                    <div class="table-val">
                        {{$transaction['receipt']->receipt_id}}
                    </div>

                </td>
                <td>
                    <div class="table-val">
                        {{ \Carbon\Carbon::parse($transaction['receipt']->creation_tsz)->format('M d, Y') }}
                    </div>
                </td>
                
                <td>
                    
                </td>
                <td>
                    <div class="table-val">
                        Etsy Sale {{ count($transaction['transaction']) }} Item Sold ( | @foreach($transaction['transaction'] as $listing){{$listing['transaction_id']}} | @endforeach)
                    </div>
                </td>
                <td><div class="table-val">{{ count($transaction['transaction']) }}</div></td>
                <td>
                    <div class="table-val">
                        {{$transaction['receipt']->currency_code}}
                    </div>
                </td>
                
                <td>
                    <div class="table-val">
                        {{$transaction['receipt']->total_price}}
                    </div>
                </td>
                <td>
                    <div class="item_cost_div item_cost_{{ $o}}">0.0</div>
                </td>

                <td>
                    <div class="table-val">
                        {{$transaction['receipt']->total_shipping_cost}}
                    </div>
                </td>
                
                <td class="table-input">
                    <input type='text' class="shipping-cost shipping_cost_blk_{{ $o }}" value='0.0' old-val = ''>
                </td>

                
                
                <td>
                    <div class="table-val">
                        {{$transaction['receipt']->discount_amt}}
                    </div>
                </td>
                <td>
                    <div class="table-val">
                        {{ number_format($transaction['fee']/100,2,'.',',') }}
                    </div>
                </td>
                 <td>
                    <div class="table-val">
                        {{$transaction['receipt']->total_tax_cost}}
                    </div>
                </td>
                <td>
                    <div class="table-val">
                        {{$transaction['receipt']->total_price+$transaction['receipt']->total_shipping_cost+$transaction['receipt']->total_tax_cost}}
                    </div>
                </td>
                <td>
                    <div class="table-val profit_blk_{{ $o }}" data-profit="{{$transaction['receipt']->subtotal+$transaction['receipt']->total_shipping_cost}}">
                        {{$transaction['receipt']->subtotal+$transaction['receipt']->total_shipping_cost-$transaction['fee']/100}}
                    </div>
                </td>
                
            </tr>
            
            @foreach($transaction['transaction'] as $listing)
            <tr class="listing listing_blk_{{ $o }}" data-count="{{ $o }}">
                <td></td>
                <td>
                    <div class="table-val">
                        {{$listing['transaction_id']}}
                    </div>
                </td>
                <td></td>
                <td class="table-img">
                    @if(isset($listing['image']))
                    <input type="image" src="{{ $listing['image'] }}" > 
                    @else
                    <input type="image" src="{{url('image/empty.jpg')}}" > 
                    @endif
               
                </td>
                <td>
                    <div class="table-val">
                        @if(strlen($listing['title']) > 90)
                        {{ substr($listing['title'],0,90)}}...
                        @else
                        {{ substr($listing['title'],0,90)}}
                        @endif
    
                    </div>
                </td>
                <td>
                    <div class="table-val">
                        {{$listing['quantity']}}
                    </div>
                </td>
                <td>
                    <div class="table-val">
                        {{$listing['currency']}}
                    </div>
                </td>
                <td>
                    <div class="table-val">
                        {{$listing['price']}}
                    </div>
                </td>
                <td class="table-input">
                    <input type='text' class="item-cost item-cost-{{ $o }}" value='0.0' old-val = ''>
                </td>
                <td></td>
                <td></td>
                <td>
                    <div class="table-val">{{ number_format($transaction['receipt']->discount_amt/count($transaction['transaction']),2) }}</div>
                </td>
                <td></td>
                <td><div class="table-val">{{number_format(($transaction['receipt']->total_tax_cost/$transaction['receipt']->total_price)*$listing['price'],2)}}</div></td>
                <td></td>
                <td></td>

            </tr>
            @endforeach
            
               
                <?php $i=0; ?>
            @endforeach
            <tr><td colspan='20' id="no-data" class='text-center'><strong>No Sold</strong></td></tr>
        @else
           <tr><td colspan='20' class='empty-data text-center'><strong>No Sold</strong></td></tr>
        @endif
    </table>
    
    @if($pagination->total_page > 0 )
        <div class="paging">
    <ul>
    @if($pagination->total_page <= 3)
        
        @for($x = 1; $x <= $pagination->total_page; $x++)
            <li onclick="selectPage({{$x}});" class="page-number page-deactive" @if($pagination->effective_page == $x) id='page-active' @endif ><a >{{$x}}</a></li>
        @endfor
        
        
     
    @else
     
        @if($pagination->effective_page == 1)
        
        <li onclick="selectPage({{$pagination->effective_page}});" class="page-number" id='page-active'><a >{{$pagination->effective_page}}</a></li>
        <li onclick="selectPage({{$pagination->effective_page+1}});" class='page-number page-deactive'><a >{{$pagination->effective_page+1}}</a></li>
        <li onclick="selectPage({{$pagination->effective_page+2}});" class='page-number page-deactive'><a >{{$pagination->effective_page+2}}</a></li>
        
        @elseif($pagination->effective_page == $pagination->total_page)
        
        <li onclick="selectPage({{$pagination->effective_page-2}});" class='page-number page-deactive'><a >{{$pagination->effective_page-2}}</a></li>
        <li onclick="selectPage({{$pagination->effective_page-1}});" class='page-number page-deactive'><a >{{$pagination->effective_page-1}}</a></li>
        <li onclick="selectPage({{$pagination->effective_page}});" class="page-number" id='page-active'><a >{{$pagination->effective_page}}</a></li>
        
        @else
        
        <li onclick="selectPage({{$pagination->effective_page-1}});" class='page-number page-deactive'><a >{{$pagination->effective_page-1}}</a></li>
        <li onclick="selectPage({{$pagination->effective_page}});" class="page-number" id='page-active'><a >{{$pagination->effective_page}}</a></li>
        <li onclick="selectPage({{$pagination->effective_page+1}});" class='page-number page-deactive'><a >{{$pagination->effective_page+1}}</a></li>
        
        @endif
     
    @endif
        
    </ul>
    </div>
    @endif

<style>
    #active_account{
          padding:4px 10px;
          outline:none;
          margin:4px 0px;
        }
</style>
<script src="{{asset('js/etsy_sold_item_ajax.js?34234')}}"></script>