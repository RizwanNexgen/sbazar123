@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Hermes <small>More options...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/shippingmethods/display')}}"><i class="fa fa-dashboard"></i>{{ trans('labels.ShippingMethods') }}</a></li>
                <li class="active">Hermes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">More Options</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        
                                        <div class="box-body">
                                            @if( count($errors) > 0)
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="icon fa fa-check" aria-hidden="true"></span>
                                                        <span class="sr-only">{{ trans('labels.Setting') }}:</span>
                                                        {{ $error }}</div>
                                                @endforeach
                                            @endif
                                            
                                            <form action="{{url('admin/shippingmethods/updateHermesCountries')}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label>Minimum Order</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label>Shipping Charge</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        
                                                    </div>
                                                </div>
                                                
                                                @foreach($result['hermes_countries'] as $o)
                                                <input type="hidden" name="ids[]" value="{{$o->id}}" />
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select class="form-control" name="country_code[{{$o->id}}]">
                                                                <option value="">--Select--</option>
                                                                @foreach($result['countries'] as $country)
                                                                <option value="{{$country->countries_iso_code_2}}" @if($o->country_code==$country->countries_iso_code_2) selected @endif>{{$country->countries_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <input type="text" name="min_order[{{$o->id}}]" value="{{$o->min_order}}" class="form-control" placeholder="e.g. 5.00" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <select class="form-control" name="shipping_type[{{$o->id}}]">                                                                
                                                                <option value="2" @if($o->shipping_type==2) selected @endif>Shipping Charge</option> 
                                                                <option value="1" @if($o->shipping_type==1) selected @endif>Free Shipping</option>                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <input type="text" name="shipping_charge[{{$o->id}}]" value="{{$o->shipping_charge}}" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <a class="btn btn-danger" href="{{url('admin/shippingmethods/hermesCountries/delete/'.$o->id)}}" onClick="return confirm('Sure to delete?')">&times</a>
                                                    </div>
                                                </div>
                                                @endforeach

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <select class="form-control" name="country_code_new">
                                                                <option value="">--Select--</option>
                                                                @foreach($result['countries'] as $country)
                                                                <option value="{{$country->countries_iso_code_2}}">{{$country->countries_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <input type="text" name="min_order_new" value="" class="form-control" placeholder="e.g. 5.00" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <select class="form-control" name="shipping_type_new">                                                                
                                                                <option value="2">Shipping Charge</option> 
                                                                <option value="1">Free Shipping</option>                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <input type="text" name="shipping_charge_new" value="" class="form-control" placeholder="e.g. 5.00" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                                    <a href="{{ URL::to('admin/shippingmethods/display')}}" type="button" class="btn btn-default"> <i class="fa fa-angle-left"></i> {{ trans('labels.back') }}</a>
                                                </div>

                                            </form>
                                            
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
@endsection
