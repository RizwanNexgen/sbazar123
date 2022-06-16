@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Products') }} <small>{{ trans('labels.ListingAllProducts') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class="active"> {{ trans('labels.Products') }}</li>
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

                            <div CLASS="col-lg-12"> <h7 style="font-weight: bold; padding:0px 16px; float: left;">{{ trans('labels.FilterByCategory/Products') }}:</h7>

                                <br>
                           <div class="col-lg-10 form-inline">

                                <form  name='registration'  class="registration" method="get">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    
                                    <div class="input-group-form search-panel ">
                                        
                                        <select class="form-control" name="product_type">
                                            <option value="">Product Type</option>
                                            <option value="Simple" @if(Request('product_type')=='Simple') selected @endif>Simple</option>
                                            <option value="Variable" @if(Request('product_type')=='Variable') selected @endif>Variable</option>
                                        </select>
                                        <select class="form-control" name="brand_id">
                                            <option value="">Brand</option>
                                            @foreach($results['brand_list'] as $brand)
                                            <option value="{{$brand->id}}" @if(Request('brand_id')==$brand->id) selected @endif>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="unit_id">
                                            <option value="">Unit</option>
                                            @foreach($results['units'] as $unit)
                                            <option value="{{$unit->units_name}}" @if(Request('unit_id')==$unit->units_name) selected @endif>{{$unit->units_name}}</option>
                                            @endforeach
                                        </select>
                                        <select id="FilterBy" type="button" class="form-control input-group-form " data-toggle="dropdown" name="categories_id">

                                            <option value="" selected disabled hidden>{{trans('labels.ChooseCategory')}}</option>
                                            @foreach ($results['subCategories'] as  $key=>$subCategories)
                                                <option value="{{ $subCategories->id }}"
                                                        @if(isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id']))
                                                          @if( $subCategories->id == $_REQUEST['categories_id'])
                                                            selected
                                                          @endif
                                                        @endif
                                                >{{ $subCategories->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control input-group-form " name="product" placeholder="Search term..." id="parameter"  @if(isset($product)) value="{{$product}}" @endif />
                                        <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        @if(!empty(Request('_token')))  
                                            <a class="btn btn-danger " href="{{url('admin/products/display')}}">
                                                <i class="fa fa-ban" aria-hidden="true"></i> 
                                            </a>
                                        @endif
                                    </div>
                                </form>
                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                            </div>
                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/products/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                            </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($errors) > 0)
                                        @if($errors->any())
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{$errors->first()}}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>@sortablelink('products_id', trans('labels.ID') )</th>
                                            <th>@sortablelink('products_name', trans('labels.Name') )</th>
                                            <th>{{ trans('labels.Image') }}</th>
                                            <th>@sortablelink('categories_name', trans('labels.Category') )</th>
                                            {{-- <th>Points</th> --}}
                                            <th>{{ trans('labels.Additional info') }}</th>
                                            
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($results['products'])>0)
                                            @php  $resultsProduct = $results['products']->unique('products_id')->keyBy('products_id');  @endphp
                                            @foreach ($resultsProduct as  $key=>$product)
                                                <tr>
                                                    <td>{{ $product->products_id }}</td>
                                                    <td>
                                                        {{ $product->products_name }} @if(!empty($product->products_model)) ( {{ $product->products_model }} ) @endif
                                                    </td>
                                                    <td><img src="{{asset($product->path)}}" alt="" height="100px"></td>
                                                    <td>
                                                        {{ $product->categories_name }}
                                                    </td>
                                                    {{-- <td class="text-center">
                                                        {{ $product->products_points }} 
                                                    </td> --}}
                                                    
                                                    <td>
                                                        <strong>{{ trans('labels.Product Type') }}:</strong>
                                                        @if($product->products_type==0)
                                                            {{ trans('labels.Simple') }}
                                                        @elseif($product->products_type==1)
                                                            {{ trans('labels.Variable') }}
                                                        @elseif($product->products_type==2)
                                                            {{ trans('labels.External') }}
                                                        @endif
                                                        <br>
                                                        <strong>Product Unique ID: {{$product->products_sku}}</strong>   
                                                        <br>
                                                        @if(!empty($product->manufacturer_name))
                                                            <strong>Brand:</strong> {{ $product->manufacturer_name }}<br>
                                                        @endif
                                                        @if(!empty($product->products_points))
                                                            <strong>Points:</strong> {{ $product->products_points }}<br>
                                                        @endif
                                                        <strong>{{ trans('labels.Price') }}: </strong>   
                                                        @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $product->products_price }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                        <br>
                                                        <strong>Market Price: </strong>   
                                                        @if(!empty($result['commonContent']['currency']->symbol_left)) {{$result['commonContent']['currency']->symbol_left}} @endif {{ $product->products_price_market }} @if(!empty($result['commonContent']['currency']->symbol_right)) {{$result['commonContent']['currency']->symbol_right}} @endif
                                                        <br>
                                                        <strong>{{ trans('labels.Weight') }}: </strong>  {{ $product->products_weight }}{{ $product->products_weight_unit }}<br>
                                                        <strong>{{ trans('labels.Viewed') }}: </strong>  {{ $product->products_viewed }}<br>
                                                        @if(!empty($product->specials_id))
                                                            <strong class="badge bg-light-blue">{{ trans('labels.Special Product') }}</strong><br>
                                                            <strong>{{ trans('labels.SpecialPrice') }}: </strong>  {{ $product->specials_products_price }}<br>

                                                            @if(($product->specials_id) !== null)
                                                                @php  $mytime = Carbon\Carbon::now()  @endphp
                                                                <strong>{{ trans('labels.ExpiryDate') }}: </strong>

                                                                {{-- @if($product->expires_date > $mytime->toDateTimeString()) --}}
                                                                    {{  date('d-m-Y', $product->expires_date) }}
                                                                {{-- @else
                                                                    <strong class="badge bg-red">{{ trans('labels.Expired') }}</strong>
                                                                @endif --}}
                                                                <br>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    

                                                    <td>
                                                      <a class="btn btn-primary" style="width: 100%; margin-bottom: 5px;" href="{{url('admin/products/edit')}}/{{ $product->products_id }}">{{ trans('labels.EditProduct') }}</a>
                                                      </br>
                                                      @if($product->products_type==1)
                                                          <a class="btn btn-info" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/attach/attribute/display')}}/{{ $product->products_id }}">{{ trans('labels.ProductAttributes') }}</a>

                                                          </br>
                                                      @endif
                                                      {{-- <a class="btn btn-warning" style="width: 100%;  margin-bottom: 5px;" href="{{url('admin/products/images/display/'. $product->products_id) }}">{{ trans('labels.ProductImages') }}</a> --}}
                                                      <a class="btn btn-danger" style="width: 100%;  margin-bottom: 5px;" id="deleteProductId" products_id="{{ $product->products_id }}">{{ trans('labels.DeleteProduct') }}</a>
                                                      </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>

                                </div>


                            </div>
                                <div class="col-xs-12" style="background: #eee;">


                                  @php
                                    if($results['products']->total()>0){
                                      $fromrecord = ($results['products']->currentpage()-1)*$results['products']->perpage()+1;
                                    }else{
                                      $fromrecord = 0;
                                    }
                                    if($results['products']->total() < $results['products']->currentpage()*$results['products']->perpage()){
                                      $torecord = $results['products']->total();
                                    }else{
                                      $torecord = $results['products']->currentpage()*$results['products']->perpage();
                                    }

                                  @endphp
                                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                                    <div>Showing {{$fromrecord}} to {{$torecord}}
                                        of  {{$results['products']->total()}} entries
                                    </div>
                                  </div>
                                <div class="col-xs-12 col-md-6 text-right">
                                   {{ $results['products']->appends([
                                        'product_type' => Request('product_type'), 
                                        'categories_id'=> Request('categories_id'), 
                                        'product'=> Request('product'), 
                                        'brand_id'=> Request('brand_id'), 
                                        'unit_id'=> Request('unit_id')
                                    ])->links() }}
                                    
                                </div>
                              </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>

            <!-- deleteProductModal -->
            <div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteProductModalLabel">{{ trans('labels.DeleteProduct') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/products/delete', 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('products_id',  '', array('class'=>'form-control', 'id'=>'products_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteThisProductDiloge') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary" id="deleteProduct">{{ trans('labels.DeleteProduct') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main row -->

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
