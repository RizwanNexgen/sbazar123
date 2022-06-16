@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Super Deals <small>Super Deals...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">Super Deals</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Super Deals</h3>
                    </div>
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <div class="box-body">
                                        @if( count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-success" role="alert">
                                            <span class="icon fa fa-check" aria-hidden="true"></span>
                                            <span class="sr-only">Super Deals Error:</span>
                                            {{ $error }}
                                        </div>
                                        @endforeach
                                        @endif

                                        {!! Form::open(array('url' =>'admin/update-super-deals', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                        <br>


                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Enable</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="status">
                                                    <option {{ ($list->status == 1) ? "selected" : "" }} value="1">Yes</option>
                                                    <option {{ ($list->status == 0) ? "selected" : "" }} value="0">No</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Type</label>
                                            <div class="col-sm-10 col-md-4">
                                                <select class="form-control" name="type">
                                                    <option {{ ($list->type == 'price') ? "selected" : "" }} value="price">Price</option>
                                                    <option {{ ($list->type == 'point') ? "selected" : "" }} value="point">Point</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Cap Amount</label>
                                            <div class="col-sm-10 col-md-4">
                                                <input type="number" class="form-control" name="cap_amount" value= {{ $list->cap_amount }} step="any" />
                                            </div>
                                        </div>

                                        <div class="form-group" id="imageIcone">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Header Image</label>
                                            <div class="col-sm-10 col-md-4">
                                                <!-- Modal -->
                                                <div class="modal fade embed-images" id="ModalmanufacturedICone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Image') }} </h3>
                                                            </div>
                                                            <div class="modal-body manufacturer-image-embed">
                                                                @if(isset($allimage))
                                                                <select class="image-picker show-html " name="bg_image_id" id="select_img">
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
                                                                <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="imageselected">
                                                    {!! Form::button(trans('labels.Add Image'), array('id'=>'newIcon','class'=>"btn btn-primary field-validate", 'data-toggle'=>"modal", 'data-target'=>"#ModalmanufacturedICone" )) !!}
                                                    <br>
                                                    <div id="selectedthumbnailIcon" class="selectedthumbnail col-md-5" style="display: none"> </div>
                                                    <div class="closimage">
                                                        <button type="button" class="close pull-left image-close " id="image-Icone" style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <br>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">  </label>
                                            <div class="col-sm-10 col-md-4">
                                                <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.OldImage') }}</span>
                                                <br>
                                                {!! Form::hidden('oldImage',  $result['commonContent']['setting']['website_logo'] , array('id'=>'website_logo')) !!}
                                                <img src="{{asset($list->image_category->path)}}" alt="" width="80px">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 col-md-3 control-label"> Number of Products </label>
                                            <div class="col-sm-10 col-md-4">
                                                <label> {{ count($list->products) }} Products</label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            @if(count($list->products) > 0)
                                            <label for="name" class="col-sm-2 col-md-3 control-label">Products </label>
                                            <div class="col-sm-12 col-md-8">
                                                <a class="btn btn-primary" href="{{url('admin/super-deals/products')}}">Add Product</a>
                                            </div>
                                            @endif
                                        </div>
                                        
                                        <br>
                                        <br>
                                        
                                        <div id="productList" class="form-group">
                                            @if(count($list->products) > 0)
                                            <div class="col-sm-10 col-md-8 col-sm-offset-2">
                                                <div class="card">
                                                    <table class="table">
                                                        <tr>
                                                            <th width="10%" style="vertical-align:middle; text-align:center;">#ID</th>
                                                            <th width="10%" style="vertical-align:middle; text-align:center;">#Image</th>
                                                            <th width="30%" style="vertical-align:middle; text-align:center;">#Name</strong></th>
                                                            <th width="20%" style="vertical-align:middle; text-align:center;">#Actual Price</th>
                                                            <th width="20%" style="vertical-align:middle; text-align:center;">#Actual Point</th>
                                                            <th width="15%" style="vertical-align:middle; text-align:center;">#Super Deals Price/Point</th>
                                                            <th width="15%" style="vertical-align:middle; text-align:center;">#Action</th>
                                                        </tr>
                                                        @foreach($list->products as $p)
                                                        <tr>
                                                            <td width="10%" style="vertical-align:middle; text-align:center;">#{{$p->products_id}}</td>
                                                            <td width="10%" style="vertical-align:middle; text-align:center;"><img src="{{asset($p->path)}}" class="img-thumbnail" alt="" height="50px"></td>
                                                            <td width="30%" style="vertical-align:middle; text-align:center;"><strong>{{$p->products_name}}</strong></td>
                                                            <td width="20%" style="vertical-align:middle; text-align:center;">€{{$p->products_price}}</td>
                                                            <td width="20%" style="vertical-align:middle; text-align:center;">{{$p->products_points}} pt</td>
                                                            <td width="15%" style="vertical-align:middle; text-align:center;">
                                                                <input hidden value="{{ $p->products_id }}" name="product_id[]">
                                                                <!--<input type="number" class="form-control" name="cap_amount" value= {{ $list->cap_amount }} step="any" />-->
                                                                <input type="text" name="product_ss[]" value={{ ($list->type == 'price') ? $p->new_product_price : $p->new_point}}>
                                                            </td>
                                                            <td width="15%" style="vertical-align:middle; text-align:center;">
                                                                <a class="btn btn-sm btn-danger" href="{{url('admin/super-deals/remove_products')}}/{{ $p->products_id }}" >Remove</a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                        
                                                    </table>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        
                                    </div>

                                    <!-- /.box-body -->
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }} </button>
                                        <a href="{{ URL::to('admin/dashboard/this_month')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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

        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>
    function toggleProductList(e){
        $('#productList').toggle();
    }
</script>
@endsection