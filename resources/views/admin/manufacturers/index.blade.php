@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Manufacturer') }} <small>{{ trans('labels.ListingAllManufacturers') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class=" active">{{ trans('labels.Manufacturer') }}</li>
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
                            {{--<h3 class="box-title">{{ trans('labels.ListingAllManufacturers') }} </h3>--}}

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 form-inline">
                                                <form name='filter' id="registration" class="filter  " method="get" action="{{url('admin/manufacturers/filter')}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="input-group-form search-panel ">
                                                      <select type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" name="FilterBy" id="FilterBy" >
                                                        <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                                        <option value="Name" @if(isset($name)) @if  ($name == "Name") {{ 'selected' }} @endif @endif>{{trans('labels.Name')}}</option>
                                                        <option value="URL" @if(isset($name)) @if  ($name == "URL") {{ 'selected' }} @endif @endif>{{trans('labels.URL')}}</option>
                                                      </select>
                                                      <input type="text" class="form-control input-group-form " name="parameter" placeholder="{{trans('labels.Search')}}..." id="parameter" @if(isset($param)) value="{{$param}}" @endif>
                                                      <button class="btn btn-primary " type="submit" id="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                      @if(isset($param,$name))  <a class="btn btn-danger " href="{{URL::to('admin/manufacturers/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/manufacturers/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
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
                                            <th>@sortablelink('manufacturers_id', trans('labels.ID') )</th>
                                            <th>@sortablelink( 'manufacturer_name', trans('labels.Name') )</th>
                                            <th>Logo</th>
                                            <th>Number of Products</th>
                                            <th>Is Top</th>
                                            <th>@sortablelink( 'manufacturer_status', trans('labels.Status') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($manufacturers)>0)
                                            @foreach ($manufacturers  as $key=>$manufacturer)
                                                <tr>
                                                    <td>{{ $manufacturer->id }}</td>
                                                    <td>{{ $manufacturer->name }}</td>
                                                    <td><img src="{{asset($manufacturer->path)}}" alt="" width=" 100px"></td>
                                                    {{-- <td>{{$manufacturer->total_products}}</td> --}}
                                                    <td><a href="javascript:void(0)" onClick="$('#products_{{$manufacturer->id}}').toggle();">{{$manufacturer->total_products}}</a></td>
                                                    <td>
                                                          @if($manufacturer->is_top==1)
                                                          <span class="label label-success">
                                                            Yes
                                                          </span>
                                                          @else
                                                          <span class="label label-danger">
                                                              No
                                                          </span>
                                                          @endif
                                                    </td>
                                                    <td>
                                                          @if($manufacturer->status==1)
                                                          <span class="label label-success">
                                                            {{ trans('labels.Active') }}
                                                          </span>
                                                          @elseif($manufacturer->status==0)
                                                          <span class="label label-danger">
                                                              {{ trans('labels.InActive') }}
                                                          @endif
                                                    </td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/manufacturers/edit/'.$manufacturer->id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a id="manufacturerFrom" manufacturers_id='{{ $manufacturer->id }}' data-toggle="tooltip" data-placement="bottom" title="Delete" data-href="{{url('admin/manufacturers/delete')}}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                </tr>

                                                @if(count($manufacturer->products) > 0)
                                                <tr id="products_{{$manufacturer->id}}" style="display:none;">
                                                    <td colspan="5" style="padding-left:10%;">
                                                        <div class="card">
                                                            <table class="table">
                                                                @foreach($manufacturer->products as $p)
                                                                    <tr>
                                                                        <td width="5%" style="vertical-align:middle;">#{{$p->products_id}}</td>
                                                                        <td width="5%" style="vertical-align:middle;"><img src="{{asset($p->path)}}" class="img-thumbnail" alt="" height="50px"></td>
                                                                        <td width="22%" style="vertical-align:middle;"><strong>{{$p->products_name}}</strong></td>
                                                                        <td width="10%" style="vertical-align:middle;">€{{$p->products_price}}</td>
                                                                        <td width="10%" style="vertical-align:middle;">
                                                                            <a onclick='deleteProduct("{{ $p->products_id }}", this)' class="btn btn-sm btn-danger" href="javascript:void(0);">Delete</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else 
                                                <tr>
                                                    <td colspan="7">
                                                        <p style="color:#CCC;">No products in {{ $manufacturer->name }} brand</p>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach

                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($manufacturers != null)
                                    <div class="col-xs-12 text-right">
                                        {{$manufacturers->links()}}
                                    </div>
                                    @endif
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

            <!-- deleteManufacturerModal -->
            <div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="deleteManufacturerModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteManufacturerModalLabel">{{ trans('labels.DeleteManufacturer') }}</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/manufacturers/delete', 'name'=>'deleteManufacturer', 'id'=>'deleteManufacturer', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('manufacturers_id',  '', array('class'=>'form-control', 'id'=>'manufacturers_id')) !!}
                        <div class="modal-body">
                            <p>{{ trans('labels.DeleteManufacturerText') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ trans('labels.Delete') }}</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">

        function deleteProduct(product_id, node){
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this product.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        method: 'post',
                        url: '{{url('admin/products/delete_ajax')}}',
                        data: {'products_id' : product_id},
                        success: function(result){

                            console.log($(node));
                            console.log($(node).parent().parent());

                            $(node).parent().parent().remove();

                            swal("Product has been deleted!", {
                                icon: "success",
                            });
                        },
                        error: function(){
                            swal("Faild to deleted!", {
                                icon: "error",
                            });
                        }
                    });
                }
            });
        }

    </script>

@endsection
