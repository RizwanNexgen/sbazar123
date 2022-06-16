@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Combos <small>Listing all the combos...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class=" active">Combos</li>
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
                            

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 form-inline">
                                                <form name='filter' id="registration" class="filter  " method="get" action="{{url('admin/combos/filter')}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="input-group-form search-panel ">
                                                      <select type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" name="FilterBy" id="FilterBy" >
                                                        <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                                        <option value="Name" @if(isset($name)) @if  ($name == "Name") {{ 'selected' }} @endif @endif>{{trans('labels.Name')}}</option>
                                                        <!-- <option value="URL" @if(isset($name)) @if  ($name == "URL") {{ 'selected' }} @endif @endif>{{trans('labels.URL')}}</option> -->
                                                      </select>
                                                      <input type="text" class="form-control input-group-form " name="parameter" placeholder="{{trans('labels.Search')}}..." id="parameter" @if(isset($param)) value="{{$param}}" @endif>
                                                      <button class="btn btn-primary " type="submit" id="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                      @if(isset($param,$name))  <a class="btn btn-danger " href="{{URL::to('admin/combos/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/combos/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
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
                                            <th>ID</th>
                                            <th>Name</th>                                            
                                            <th>Discount</th>
                                            <th>Number of Products</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($list)>0)
                                            @foreach ($list  as $o)
                                            <tr>
                                                <td>{{ $o->id }}</td>
                                                <td>{{ $o->combo_info()->combo_title }}</td>
                                                <td>{{ $o->discount }}%</td>
                                                <td><a href="javascript:void(0)" onClick="$('#products_{{$o->id}}').toggle();">{{$o->combo_products()->count()}}</a></td>
                                                <td>
                                                      @if($o->status==1)
                                                      <span class="label label-success">
                                                        {{ trans('labels.Active') }}
                                                      </span>
                                                      @elseif($o->status==0)
                                                      <span class="label label-danger">
                                                          {{ trans('labels.InActive') }}
                                                      @endif
                                                </td>
                                                <td>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/combos/edit/'.$o->id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Delete" onClick="return confirm('Sure to delete?')" href="{{url('admin/combos/delete/'.$o->id)}}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>

                                            @if($o->combo_products()->count()>0)
                                            <tr id="products_{{$o->id}}" style="display:none;">
                                                <td colspan="7" style="padding:0;">
                                                    <div class="card">
                                                        <table class="table">
                                                            
                                                            @php 
                                                            $total_price = 0;
                                                            $total_points = 0;                                                            
                                                            @endphp

                                                            @foreach($o->products as $p)    

                                                                @php 
                                                                $qty_price = $p->products_price * $p->quantity;
                                                                $qty_points = $p->products_points * $p->quantity;
                                                                $total_price = $total_price + $qty_price;
                                                                $total_points = $total_points + $qty_points; 
                                                                @endphp

                                                                <tr>
                                                                    <td width="5%" style="vertical-align:middle;">#{{$p->products_id}}</td>
                                                                    <td width="5%" style="vertical-align:middle;"><img src="{{asset($p->path)}}" class="img-thumbnail" alt="" height="50px"></td>
                                                                    <td width="22%" style="vertical-align:middle;"><strong>{{$p->products_name}}</strong></td>
                                                                    <td width="10%" style="vertical-align:middle; text-align:right;">€{{$p->products_price}}</td>
                                                                    <td width="3%" style="vertical-align:middle;">&times;</td>
                                                                    <td width="15%" style="vertical-align:middle;">
                                                                        <form class="form-inline" method="POST" action="{{url('admin/combos/update_combo_quantity')}}">
                                                                            @csrf
                                                                            <input type="hidden" name="combo_product_id" value="{{$p->combo_product_id}}" />
                                                                            <input type="number" name="quantity" style="width:60px;" class="form-control" value="{{$p->quantity}}" />
                                                                            <button class="btn btn-success"><i class="fa fa-refresh"></i></button>
                                                                        </form>
                                                                    </td>
                                                                    <td width="10%" style="vertical-align:middle;">€{{$qty_price}}</td>
                                                                    <td width="10%" style="vertical-align:middle;">{{$qty_points}} pts</td>
                                                                    <td width="10%" style="vertical-align:middle;">{{$p->products_sku}}</td>
                                                                    <td width="10%" style="vertical-align:middle;">
                                                                        <a class="btn btn-sm btn-danger" href="{{url('admin/combos/delete_combo_product/'.$p->combo_product_id)}}" onClick="return confirm('Sure to delete?')">Remove</a>
                                                                    </td>
                                                                </tr>

                                                                

                                                            @endforeach
                                                            
                                                            <tr>
                                                                <td style="vertical-align:middle; text-align:right;" colspan="6"><strong>Total:</strong></td>                                                                
                                                                <td style="vertical-align:middle;"><strong>€{{$total_price}}</strong></td>
                                                                <td style="vertical-align:middle;"><strong>{{$total_points}} pts</strong></td>
                                                                <td style="vertical-align:middle;" colspan="2">&nbsp;</td>
                                                            </tr>

                                                            
                                                            
                                                            @php
                                                            $discount = ($total_price*$o->discount)/100;
                                                            @endphp
                                                            <tr>
                                                                <td style="vertical-align:middle; text-align:right;" colspan="6"><strong>Discount:</strong></td>                                                                
                                                                <td style="vertical-align:middle;"><strong>€{{$discount}} ({{$o->discount}}%)</strong></td>                                                                
                                                                <td style="vertical-align:middle;" colspan="3">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align:middle; text-align:right;" colspan="6"><strong>Bundle Total:</strong></td>                                                                
                                                                <td style="vertical-align:middle;"><strong>€{{$total_price-$discount}}</strong></td>
                                                                <td style="vertical-align:middle;"><strong>{{$total_points}} pts</strong></td>
                                                                <td style="vertical-align:middle;" colspan="2">&nbsp;</td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            @else 
                                            <tr>
                                                <td colspan="7">
                                                    <p style="color:#CCC;">No products in {{ $o->combo_info()->combo_title }} combo</p>
                                                </td>
                                            </tr>
                                            @endif

                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">No records found.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    
                                    <div class="col-xs-12 text-right">
                                        {{$list->links()}}
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
