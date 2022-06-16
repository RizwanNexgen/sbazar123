@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Collections <small>Listing all the collections...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li class=" active">Collections</li>
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
                                                      @if(isset($param,$name))  <a class="btn btn-danger " href="{{URL::to('admin/bundles/display')}}"><i class="fa fa-ban" aria-hidden="true"></i> </a>@endif
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="{{ URL::to('admin/packages/add') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
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
                                            <th>Title</th>
                                            <th>Color Code</th>
                                            <th>Background</th>                                            
                                            <th>Status</th>
                                            <th>Number of Products</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($list)>0)
                                            @foreach ($list  as $o)

                                                <tr>
                                                    <td>{{ $o->id }}</td>
                                                    <td>
                                                        @if(empty($o->parent_id))
                                                        {{ $o->package_info()->package_title }}
                                                        @else 
                                                        {{ $o->parent_package()->package_info()->package_title }} <i class="fa fa-angle-right"></i> {{ $o->package_info()->package_title }}
                                                        @endif
                                                        
                                                        @if(count($o->child_packages)>0)
                                                        <span class="badge badge-dark" onClick="$('.tr_{{$o->id}}').toggle();"><i class="fa fa-angle-down"></i></span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($o->color_code))
                                                            {{ $o->color_code }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($o->image_category))
                                                        <img src="{{asset($o->image_category->path)}}" width="60" />
                                                        @endif
                                                    </td>                                                                                              
                                                    <!--<td>
                                                        {{$o->end_time}}
                                                        @if(time()>strtotime($o->end_time))
                                                        <span class="badge bg-red ml-2">Expired</span>                                                    
                                                        @endif
                                                    </td>-->
                                                    
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
                                                    
                                                    <td><a href="{{ URL::to('admin/packages/products/'.$o->id)}}">{{$o->package_products()->count()}} Products</a></td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/packages/edit/'.$o->id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Delete" onClick="return confirm('Sure to delete?')" href="{{url('admin/packages/delete/'.$o->id)}}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>    

                                                @foreach ($o->child_packages  as $o2)
                                                <tr class="tr_{{$o2->parent_id}}" style="display:none;">
                                                    <td>{{ $o2->id }}</td>
                                                    <td>
                                                        @if(empty($o2->parent_id))
                                                        {{ $o2->package_info()->package_title }}
                                                        @else 
                                                        {{ $o2->parent_package()->package_info()->package_title }} <i class="fa fa-angle-right"></i> {{ $o2->package_info()->package_title }}
                                                        @endif
                                                    </td>                                                
                                                    <td>
                                                        @if(isset($o2->image_category))
                                                        <img src="{{asset($o2->image_category->path)}}" width="60" />
                                                        @endif
                                                    </td>                                                                                              
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
                                                    <td><a href="{{ URL::to('admin/packages/products/'.$o2->id)}}">{{$o2->package_products()->count()}} Products</a></td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ URL::to('admin/packages/edit/'.$o2->id)}}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Delete" onClick="return confirm('Sure to delete?')" href="{{url('admin/packages/delete/'.$o2->id)}}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach    

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
