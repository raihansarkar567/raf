@extends('layouts.app')

@section('content')
<div class="cusTopMargin">
    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">{{ Auth::user()->business_name }}</div>

                <div class="card-body">
                    {{-- Session Massege section --}}

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{-- Session Massege section End --}}

                    {{-- Product start --}}
                    <div id="totalStat">
                        <div class="card bg-danger text-white">
                          <div class="row card-body countDisplay">
                              <div class="col-sm-4 output_div">
                                <span>Quantity: </span><span id="qtyBadge">{{Session::has('cart') ? Session::get('cart') -> totalQty : ''}}</span>
                            </div>
                            <div class="col-sm-4">
                                <span>Total Cost: </span><span id="totalPriceBadge">{{Session::has('cart') ? Session::get('cart') -> totalPrice : ''}}</span><span> tk </span>
                            </div>
                        </div>
                    </div>
            </div>

            {{-- Session Massege section --}}
            
            
            {{-- Session Massege section End --}}

            <table id="table_id" class="table table-striped table-dark">
             <thead>
                <tr>
                   <th>Image</th>
                   <th>Name</th>
                   <th>Rate</th>
                   <th>Qty</th>
                   <th>Off</th>
                   <th>Cart</th>
               </tr>
           </thead>
           <tbody>
            @foreach($my_product as $v_product_info)
            <tr>
                <td style="width: 75px; height: 75px;"><a href="{{route('product_details', ['product_id' => $v_product_info -> product_id])}}"><img class="card-img-top" src="{{ URL::to('upload/product/'.$v_product_info -> image_txt)}}" alt="Card image"></a></td>

                <td>{{$v_product_info -> product_name}}</td>

                <td><input id="{{$v_product_info -> product_id}}input_rate" type="number" class="form-control form-control-sm" placeholder="Price" name="rateNumber"  value="{{$v_product_info -> product_rate}}"></td>

                <td><input id="{{$v_product_info -> product_id}}input_quantity" type="number" class="form-control form-control-sm" placeholder="Quantity" name="quantityNumber" value="1"></td>

                <td>{{$v_product_info -> product_discount}} %</td>

                <td><button id="cartBtn{{$v_product_info -> product_id}}" type="submit" class="btn btn-primary" style="margin: 2px;">+</button></td>
            </tr>

            <script>
                $(function(){
                    var table = $('#table_id').DataTable({
                        retrieve: true,
                        paging: false,
                        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            $('td', nRow).css('background-color', '#233a40');
                        }
                    });
                    $('#cartBtn{{$v_product_info -> product_id}}').click(function() {
                        var input_quantity=document.getElementById("{{$v_product_info -> product_id}}input_quantity").value;
                        var input_rate=document.getElementById("{{$v_product_info -> product_id}}input_rate").value;
                        if(input_quantity<{{$v_product_info -> product_quantity}}){
                            $.ajax({
                                url: '{{route('addToCartTbl', ['product_id' => $v_product_info -> product_id])}}',
                                type: 'GET',
                                data: { 'input_quantity': input_quantity,
                                'input_rate': input_rate },
                                success: function(response)
                                {
                                    $('#badge').html(response.totalQty);
                                    $('#qtyBadge').html(response.totalQty);
                                    $('#totalPriceBadge').html(response.totalPrice);
                                    console.log(response);
                                }
                            });
                        }else{
                            $('#{{$v_product_info -> product_id}}input_quantity').attr("placeholder", "Limit Ex.").val("").focus().blur(function () {
                                $(this).css({ 'border-color': 'red' });
                            });
                        }
                        
                    });
                });    
            </script>

            @endforeach
        </tbody>
    </table>

    {{-- Product end --}}
</div>
</div>
</div>
</div>
</div>
{{-- scroll top --}}
<button onclick="topFunction()" id="scrollTop" title="Go to top">Top</button>


{{-- <script type="text/javascript">
    // $('#search').on('keyup',function(){
    //     $value=$(this).val();
    //     console.log($value);
    //     $.ajax({
    //         type : 'get',
    //         url : '{{URL::to('search')}}',
    //         data:{'search':$value},
    //         success:function(data){
    //             // $('tbody').html(data);
    //             console.log(data);
    //         }
    //     });
    // })

    function search(){
        var search = $('#search').val();
        if(search){
            $("#all_data").hide();
            $("#search_data").show();
        }
        else{
            $("#all_data").show();
            $("#search_data").hide();
        }
        console.log(search);
        $.ajax({
            type : 'get',
            url : '{{URL::to('search')}}',
            data:{'search':search},
            success:function(response){
                $('#search_data').html(response);
                console.log(response);
            }
        });
    }
</script>
<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script> --}}

<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

<script>
    window.onscroll = function() {myFunction()};
    var mybutton = document.getElementById("scrollTop");
    var totalbar = document.getElementById("totalStat");
    var totalbarSticky = totalbar.offsetTop;

    function myFunction() {
      if (window.pageYOffset >= totalbarSticky) {
        totalbar.classList.add("totalbarSticky");
    } else {
        totalbar.classList.remove("totalbarSticky");
    }
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
}

</script>


@endsection



