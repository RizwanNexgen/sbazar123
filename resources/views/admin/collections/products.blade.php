@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Collections <small>Add Products...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/packages/display')}}"><i class="fa fa-industry"></i> Collections</a></li>
                <li class="active">Products</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->

            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add Products</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <br>

                                        @if (session('update'))
                                            <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong> {{ session('update') }} </strong>
                                            </div>
                                        @endif


                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    <!-- /.box-header -->
                                        <!-- form start -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Search product</label>
                                                <input type="text" class="form-control" id="searchProduct" name="search" value="" placeholder="Enter Product ID/Name/SKU" />
                                            </div>

                                            <table id="myTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Product ID</th>                                                                                   
                                                        <th>Title</th>
                                                        <th width="10%">Price</th> 
                                                        <th>SKU</th>                                            
                                                        <th width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="searchResult">
                                                @if(count($list)>0)
                                                    @foreach ($list  as $o)
                                                    <tr>
                                                        <td>{{$o->products_id}}</td>                                                                     
                                                        <td>{{$o->products_name}} ({{$o->products_weight}} {{$o->products_weight_unit}})</td>
                                                        <td>€{{$o->products_price}}</td>  
                                                        <td>{{$o->products_sku}}</td>                                            
                                                        <td>
                                                            <a href="javascript:void(0)" onClick="addPackageProduct({{$o->products_id}}, {{$info->id}})" class="btn btn-success btn-sm">Add</a>                                                            
                                                        </td>
                                                    </tr>
                                                    @endforeach                                
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <div class="box">
                        <div class="box-header">Products</div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Product ID</th>                                                                                   
                                        <th>Title</th>
                                        <th width="10%">Price</th> 
                                        <th>SKU</th>                                            
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="addedResult">
                                @if(count($products)>0)
                                    @foreach ($products  as $o)
                                    <tr>
                                        <td>{{$o->products_id}}</td>                                                                     
                                        <td>{{$o->products_name}} ({{$o->products_weight}} {{$o->products_weight_unit}})</td>
                                        <td>€{{$o->products_price}}</td>  
                                        <td>{{$o->products_sku}}</td>                                            
                                        <td>
                                            <a onClick="return confirm('Sure to delete?')" href="{{url('admin/packages/remove_products/'.$o->products_id.'/'.$info->id)}}" class="btn btn-danger btn-sm">Remove</a>
                                        </td>
                                    </tr>
                                    @endforeach                                
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    <script type="text/javascript">
        $(function() {
            $('#searchProduct').keyup(function(){
                
                var input, filter, table, tr, td, i, product_id, product_title, product_sku;                            
                input = document.getElementById("searchProduct");                                               
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                
                // Loop through all table rows, and hide those who don't match the search query
                for (i = 1; i < tr.length; i++) 
                {
                    product_id = tr[i].getElementsByTagName("td")[0];
                    
                    product_title = tr[i].getElementsByTagName("td")[1];
                    product_sku = tr[i].getElementsByTagName("td")[3];

                    product_idValue = product_id.textContent || product_id.innerText;
                    product_titleValue = product_title.textContent || product_title.innerText;
                    product_skuValue = product_sku.textContent || product_sku.innerText;

                    if ( (product_idValue.toUpperCase().indexOf(filter) > -1) || (product_titleValue.toUpperCase().indexOf(filter) > -1) || (product_skuValue.toUpperCase().indexOf(filter) > -1)) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
                
            });
        });   

        function addPackageProduct(product_id, package_id)
        {
            $.ajax({
                url:'{{url("admin/packages/add_product")}}',
                data:'product_id='+product_id+'&package_id='+package_id,
                type:'GET',
                dataType:'json',
                success:function(response){
                    if(response.error=='N') {
                        html = '<tr>'+
                        '<td>'+response.product.products_id+'</td>'+  
                        '<td>'+response.product.products_name+' ('+response.product.products_weight+' '+response.product.products_weight_unit+')</td>'+       
                        '<td>€'+response.product.products_price+'</td>'+  
                        '<td>'+response.product.products_sku+'</td>'+
                        '<td><a onClick="return confirm(\'Sure to delete?\')" href="{{url("admin/packages/remove_products")}}/'+response.product.products_id+'/'+package_id+'" class="btn btn-danger btn-sm">Remove</a></td>'+    
                        '</tr>';
                        $('#tr_'+response.product.products_id).remove();
                        $('#addedResult').append(html);
                    }else{
                        alert(response.error_msg);
                    }
                }
            });
        }     
    </script>
@endsection
