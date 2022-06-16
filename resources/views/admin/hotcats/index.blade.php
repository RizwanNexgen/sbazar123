@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.Hotcat') }} <small>{{ trans('labels.ListingAllHotcats') }}...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class=" active">{{ trans('labels.Hotcat') }}</li>
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
                            {{--<h3 class="box-title">{{ trans('labels.ListingAllHotcats') }} </h3>--}}

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6 form-inline">
                                                <form name='filter' id="registration" class="filter  " method="get" action="{{url('admin/hotcats/filter')}}">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <div class="input-group-form search-panel ">
                                                      <select type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" name="FilterBy" id="FilterBy" >
                                                        <option value="" selected disabled hidden>{{trans('labels.Filter By')}}</option>
                                                        <option value="Name" @if(isset($name)) @if  ($name == "Name") {{ 'selected' }} @endif @endif>{{trans('labels.Name')}}</option>
                                                        <option value="URL" @if(isset($name)) @if  ($name == "URL") {{ 'selected' }} @endif @endif>{{trans('labels.URL')}}</option>
                                                      </select>
                                                      <input type="text" class="form-control input-group-form " name="parameter" placeholder="{{trans('labels.Search')}}..." id="parameter" @if(isset($param)) value="{{$param}}" @endif>
                                                      <button class="btn btn-primary " type="submit" id="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                      @if(isset($param,$name))  <a class="btn btn-danger " href="{{URL::to('admin/hotcats/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/hotcats/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
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
                                            <th>@sortablelink('hotcats_id', trans('labels.ID') )</th>
                                            <th>@sortablelink( 'hotcat_name', trans('labels.Name') )</th>
                                            <th>Color Code</th>
                                            <th>Logo</th>
                                            <th>Number of Products</th>
                                            <th>@sortablelink( 'hotcats_status', trans('labels.Status') )</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($hotcats)>0)
                                            @foreach ($hotcats  as $key=>$hotcat)
                                                <tr>
                                                    <td>{{ $hotcat->id }}</td>
                                                    <td>{{ $hotcat->name }}</td>
                                                    <td>{{ $hotcat->color_code }}</td>
                                                    <td><img src="{{asset($hotcat->path)}}" alt="" width=" 100px"></td>
                                                    <td>{{$hotcat->total_products}}</td>
                                                    <td>
                                                          @if($hotcat->status==1)
                                                          <span class="label label-success">
                                                            {{ trans('labels.Active') }}
                                                          </span>
                                                          @elseif($hotcat->status==0)
                                                          <span class="label label-danger">
                                                              {{ trans('labels.InActive') }}
                                                          @endif
                                                    </td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/hotcats/edit/'.$hotcat->id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a id="hotcatFrom" hotcats_id='{{ $hotcat->id }}' data-toggle="tooltip" data-placement="bottom" title="Delete" data-href="{{url('admin/hotcats/delete')}}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                </tr>
                                            @endforeach

                                        @else
                                            <tr>
                                                <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    @if($hotcats != null)
                                    <div class="col-xs-12 text-right">
                                        {{$hotcats->links()}}
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

            <!-- deleteHotcatModal -->
            <div class="modal fade" id="hotcatModal" tabindex="-1" role="dialog" aria-labelledby="deleteHotcatModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="deleteHotcatModalLabel">Delete Hotcat</h4>
                        </div>
                        {!! Form::open(array('url' =>'admin/hotcats/delete', 'name'=>'deleteHotcat', 'id'=>'deleteHotcat', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                        {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
                        {!! Form::hidden('hotcats_id',  '', array('class'=>'form-control', 'id'=>'hotcats_id')) !!}
                        <div class="modal-body">
                            <p>Are you sure you want to delete this hotcat?</p>
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
@endsection
