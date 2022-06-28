@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.AddProduct') }} <small>{{ trans('labels.AddProduct') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/products/display')}}"><i class="fa fa-database"></i> {{ trans('labels.ListingAllProducts') }}</a></li>
            <li class="active">{{ trans('labels.AddProduct') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content"> 
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.AddNewProduct') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if(session()->has('message.level'))
                                    <div class="alert alert-{{ session('message.level') }} alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {!! session('message.content') !!}
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!-- form start -->
                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                            {{ $error }}
                                        </div>
                                        @endforeach
                                        @endif

                                    
                                        {!! Form::open(array('url' =>'admin/products/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Product Type') }}<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control field-validate prodcust-type" name="products_type" onChange="prodcust_type();">
                    <option value="">{{ trans('labels.Choose Type') }}</option>
                    <option value="0">{{ trans('labels.Simple') }}</option>
                    <option value="1">{{ trans('labels.Variable') }}</option>                                                            
                </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.Product Type Text') }}.</span>
            </div>
        </div>
        <div class="form-group parent_product" style="display:none;">
            <label for="name" class="col-sm-2 col-md-3 control-label">Parent Product</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="parent_products_id">
                    <option value="">--Select--</option>    
                    @foreach($result['main_products'] as $o)
                    <option value="{{$o->products_id}}">{{$o->products_name}}</option>   
                    @endforeach                                                                                                                    
                </select>                                                        
            </div>
        </div>
        <div class="form-group">
            <label for="products_sku" class="col-sm-2 col-md-3 control-label">Unique ID<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                {!! Form::text('products_sku', '', array('class'=>'form-control field-validate', 'id'=>'products_sku')) !!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                Enter unique id of product
                </span>
                <span class="help-block hidden">Enter unique id of product</span>
            </div>
        </div>
       <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">SB Unique ID</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="sb_unique_id" class="form-control" value="{{old('sb_unique_id')}}" />
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }}<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <?php print_r($result['categories']); ?>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.ChooseCatgoryText') }}.</span>
                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Brands<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control field-validate" name="manufacturers_id">
                    <option value="">{{ trans('labels.ChooseManufacturers') }}</option>
                    @foreach ($result['manufacturer'] as $manufacturer)
                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                    @endforeach
                </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.ChooseManufacturerText') }}.</span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsPrice') }}<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                {!! Form::text('products_price', '', array('class'=>'form-control number-validate', 'id'=>'products_price')) !!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.ProductPriceText') }}
                </span>
                <span class="help-block hidden">{{ trans('labels.ProductPriceText') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Points<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                {!! Form::text('products_points', '', array('class'=>'form-control number-validate', 'id'=>'products_points')) !!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                {{ trans('labels.ProductPriceText') }}
                </span>
                <span class="help-block hidden">Points</span>
            </div>
        </div>
       <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsWeight') }}</label>
            <div class="col-sm-10 col-md-4">
                {!! Form::text('products_weight', '0', array('class'=>'form-control field-validate number-validate', 'id'=>'products_weight')) !!}
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.RequiredTextForWeight') }}
                </span>
            </div>
            <div class="col-sm-10 col-md-4" style="padding-left: 0;">
                <select class="form-control" name="products_weight_unit">                                                                                                                        
                    @if($result['units'] !== null)
                    @foreach($result['units'] as $unit)
                    <option value="{{$unit->units_name}}">{{$unit->units_name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Product Stock<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <input type="text" id="stock_n" name="stock" value="" class="form-control">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.Enter Stock Text') }}</span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Enter Min Order<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <input type="text" id="products_min_order" name="products_min_order" value="1" class="form-control">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    Enter Min order</span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">
                {{ trans('labels.Min Level') }}<span style="color:red;">*</span>
            </label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="min_level" id="min_level_n" value="" class="form-control number-validate-level">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.Min Level Text') }}</span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">
                {{ trans('labels.Max Level') }}<span style="color:red;">*</span>
            </label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="max_level" id="max_level_n" value="" class="form-control number-validate-level">
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.Max Level Text') }}</span>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Main Img</label>
            <div class="col-sm-10 col-md-8">
                <input type="file" name="p_main_img">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Sub Images</label>
            <div class="col-sm-10 col-md-3">
                <input type="file" name="p_sub_image_1">
            </div>
            <div class="col-sm-10 col-md-3" style="padding-left: 0;">
                <div class="col-sm-10 col-md-8">
                    <input type="file" name="p_sub_image_2">
                </div>
            </div>
            <div class="col-sm-10 col-md-3" style="padding-left: 0;">
                <input type="file" name="p_sub_image_3">
            </div>
        </div>

        {{-- <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}<span style="color:red;">*</span></label>
            <div class="col-sm-10 col-md-8">
                <!-- Modal -->
                <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true"></span></button>
                                <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }}</h3>
                            </div>
                            <div class="modal-body manufacturer-image-embed">
                                @if(isset($allimage))
                                <select class="image-picker show-html " name="image_id" id="select_img">
                                    <option value=""></option>
                                    @foreach($allimage as $key=>$image)
                                    <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            <div class="modal-footer">

                                <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left">{{ trans('labels.Add Image') }}</a>
                                <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="imageselected">
                    {!! Form::button( trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                    <br>
                    <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                    <div class="closimage">
                        <button type="button" class="close pull-left image-close " id="image-close"
                        style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadProductImageText') }}</span>
            </div>
        </div> --}}

    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="products_status">
                    <option value="1">{{ trans('labels.Active') }}</option>
                    <option value="0">{{ trans('labels.Inactive') }}</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.SelectStatus') }}</span>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Expire Date</label>
            <div class="col-sm-10 col-md-8">
                <input class="form-control datepicker" readonly type="text" name="product_expires_date" id="product_expires_date"
                        value="">
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2 col-md-3">Bundle</label>
                <div class="col-sm-10 col-md-8">
                <select name="bundle_id" class="form-control">
                    <option value="">--Select--</option>
                    @foreach($result['bundles'] as $bundle)
                    <option value="{{$bundle->id}}">{{$bundle->bundle_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2 col-md-3">Combo</label>
                <div class="col-sm-10 col-md-8">
                <select name="combo_id" class="form-control">
                    <option value="">--Select--</option>
                    @foreach($result['combos'] as $combo)
                    <option value="{{$combo->id}}">{{$combo->combo_title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
       
        <!-- <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Is Exotic?</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="exotic">
                    <option value="N" @if(old('exotic')=='N') selected @endif>{{ trans('labels.No') }}</option>
                    <option value="Y" @if(old('exotic')=='Y') selected @endif>{{ trans('labels.Yes') }}</option>
                </select>
            </div>
        </div>
       <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.IsFeature') }} </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" name="is_feature">
                    <option value="0">{{ trans('labels.No') }}</option>
                    <option value="1">{{ trans('labels.Yes') }}</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.IsFeatureProuctsText') }}</span>
            </div>
        </div> -->

        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Hotcat') }}</label>
            <div class="col-sm-10 col-md-8">
                <?php print_r($result['hotcats']); ?>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.ChoosehotcatText') }}.</span>
                <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
            </div>
        </div>
        <div class="form-group" id="tax-class">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }} </label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control field-validate" name="tax_class_id">
                    {{--<option selected>{{ trans('labels.SelectTaxClass') }}</option>--}}
                    @foreach ($result['taxClass'] as $taxClass)
                    <option <?php if($taxClass->tax_class_id == 1){ echo 'selected'; }?> value="{{ $taxClass->tax_class_id }}">{{ $taxClass->tax_class_title }}</option>
                    @endforeach
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.ChooseTaxClassForProductText') }}
                </span>
                <span class="help-block hidden">{{ trans('labels.SelectProductTaxClass') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Bonus Points</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="bonus_points" class="form-control" value="{{old('bonus_points')}}" />
            </div>
        </div>
       <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Redeem Points</label>
            <div class="col-sm-10 col-md-8">
                {!! Form::text('products_points_redeem', '', array('class'=>'form-control', 'id'=>'products_points_redeem')) !!}                                                        
                <span class="help-block hidden">Redeem Points</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Note</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" name="note" class="form-control" value="{{old('note')}}" />
            </div>
        </div>     
      <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Max Orders</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" class="form-control" value="@if(empty(old('max_order'))){{'5'}}@else{{old('max_order')}}@endif" name="max_order" />
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Maximum number of orders</span>
            </div>                                                    
        </div>
      
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">Market Price</label>
            <div class="col-sm-10 col-md-8">
                {!! Form::text('products_price_market', '', array('class'=>'form-control', 'id'=>'products_price_market')) !!}
                
                <span class="help-block hidden">Market Price</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-md-3 control-label">Purchase Price</label>
            <div class="col-sm-10 col-md-8">
                <input type="text" class="form-control" value="{{old('price_purchase')}}" name="price_purchase" />
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter numeric purchase price</span>
            </div>                                                    
        </div>
       
       
        <div class="form-group flash-sale-link">
            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSale') }}</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" onChange="showFlash();" name="isFlash" id="isFlash">
                    <option value="no">{{ trans('labels.No') }}</option>
                    <option value="yes">{{ trans('labels.Yes') }}</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.FlashSaleText') }}</span>
            </div>
        </div>

        <div class="flash-container" style="display: none;">
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSalePrice') }}<span style="color:red;">*</span></label>
                <div class="col-sm-10 col-md-8">
                    <input class="form-control" type="text" name="flash_sale_products_price" id="flash_sale_products_price" value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.FlashSalePriceText') }}</span>
                    <span class="help-block hidden">{{ trans('labels.FlashSalePriceText') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSaleDate') }}<span style="color:red;">*</span></label>
                <div class="col-sm-10 col-md-4">
                    <input class="form-control datepicker" readonly type="text" name="flash_start_date" id="flash_start_date" readonly value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.FlashSaleDateText') }}</span>
                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
                <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                    <input type="text" class="form-control timepicker" name="flash_start_time" readonly id="flash_start_time" value="">
                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashExpireDate') }}<span style="color:red;">*</span></label>
                <div class="col-sm-10 col-md-4">
                    <input class="form-control datepicker" readonly type="text" readonly name="flash_expires_date" id="flash_expires_date" value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.FlashExpireDateText') }}</span>
                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
                <div class="col-sm-10 col-md-4 bootstrap-timepicker">
                    <input type="text" class="form-control timepicker" readonly name="flash_end_time" id="flash_end_time" value="">
                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                <div class="col-sm-10 col-md-8">
                    <select class="form-control" name="flash_status">
                        <option value="1">{{ trans('labels.Active') }}</option>
                        <option value="0">{{ trans('labels.Inactive') }}</option>
                    </select>
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.ActiveFlashSaleProductText') }}</span>
                </div>
            </div>
        </div>
        <div class="form-group special-link">
            <label for="name" class="col-sm-2 col-md-3 control-label">Discount</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" onChange="showSpecial();" name="isSpecial" id="isSpecial">
                    <option value="no">{{ trans('labels.No') }}</option>
                    <option value="yes">{{ trans('labels.Yes') }}</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                    {{ trans('labels.SpecialProductText') }}.</span>
            </div>
        </div>
        <div class="special-container" style="display: none;">
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SpecialPrice') }}<span style="color:red;">*</span></label>
                <div class="col-sm-10 col-md-8">
                    <input class="form-control" type="text" name="specials_new_products_price" id="special-price" value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.SpecialPriceTxt') }}.</span>
                    <span class="help-block hidden">{{ trans('labels.SpecialPriceNote') }}.</span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ExpiryDate') }}<span style="color:red;">*</span></label>
                <div class="col-sm-10 col-md-8">
                    <input class="form-control datepicker" readonly readonly type="text" name="expires_date" id="expiry-date" value="">
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.SpecialExpiryDateTxt') }}
                    </span>
                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}<span style="color:red;">*</span></label>
                <div class="col-sm-10 col-md-8">
                    <select class="form-control" name="status">
                        <option value="1">{{ trans('labels.Active') }}</option>
                        <option value="0">{{ trans('labels.Inactive') }}</option>
                    </select>
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                        {{ trans('labels.ActiveSpecialProductText') }}.</span>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name" class="col-sm-2 col-md-3 control-label">MSD</label>
            <div class="col-sm-10 col-md-8">
                <select class="form-control" onChange="showMSD(this.value);" name="isMSD" id="isMSD">
                    <option value="N">No</option>
                    <option value="Y">Yes</option>
                </select>
                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Member Special Discount</span>
            </div>
        </div>
        <div class="msd-container" style="display: none;">
            @foreach($result['user_levels'] as $user_level)
            <div class="form-group">
                <label for="name" class="col-sm-2 col-md-3 control-label">{{$user_level->membership_name}}</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" value="" name="msd_{{$user_level->membership_id}}" />
                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter discount amount in %</span>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
                                     
                                        
                                        <hr>
                                        


                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="tabbable tabs-left">
                                                    <ul class="nav nav-tabs">
                                                        @foreach($result['languages'] as $key=>$languages)
                                                        <li class="@if($key==0) active @endif"><a href="#product_<?=$languages->languages_id?>" data-toggle="tab"><?=$languages->name?>@if($languages->code=='en') <span style="color:red;">*</span> @endif</a></li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach($result['languages'] as $key=>$languages)

                                                        <div style="margin-top: 15px;" class="tab-pane @if($key==0) active @endif" id="product_<?=$languages->languages_id?>">
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductName') }}@if($languages->code=='en') <span style="color:red;">*</span> @endif ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="products_name_<?=$languages->languages_id?>" class="form-control @if($languages->code=='en') field-validate @endif">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.EnterProductNameIn') }} {{ $languages->name }} </span>
                                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group external_link" style="display: none">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.External URL') }} ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <input type="text" name="products_url_<?=$languages->languages_id?>" class="form-control products_url">
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.External URL Text') }} {{ $languages->name }} </span>
                                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }}@if($languages->code=='en') <span style="color:red;">*</span> @endif ({{ $languages->name }})</label>
                                                                    <div class="col-sm-10 col-md-8">
                                                                        <textarea id="editor<?=$languages->languages_id?>" name="products_description_<?=$languages->languages_id?>" class="form-control" rows="5"></textarea>
                                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                                            {{ trans('labels.EnterProductDetailIn') }} {{ $languages->name }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /.box-body -->
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <span>{{ trans('labels.Save_And_Continue') }}</span>
                                                <i class="fa fa-angle-right 2x"></i>
                                            </button>
                                        </div>

                                        <!-- /.box-footer -->
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
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

        //for multiple languages
        @foreach($result['languages'] as $languages)
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor{{$languages->languages_id}}');

        @endforeach

        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
        
    });

    function showMSD(state)
    {
        if(state=='Y')
        {
            $('.msd-container').show();
        }
        else
        {
            $('.msd-container').hide();
        }
    }
</script>
@endsection