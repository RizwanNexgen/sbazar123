@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Min Stock Report') }} <small>{{ trans('labels.Min Stock Report') }}...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Min Stock Report') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.Min Stock Report') }} </h3>

            <div class="box-tools pull-right">
              <form action="{{ URL::to('admin/minstockprint')}}" target="_blank">
                <input type="hidden" name="page" value="invioce">
                <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</button>
              </form>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ProductID') }}</th>
                      <th>{{ trans('labels.ProductName') }}</th>
                      <th>{{ trans('labels.Min Level') }}</th>
                      <th>{{ trans('labels.Current Stock') }}</th>
                      
                    </tr>
                  </thead>
                   <tbody>
                    @foreach ($products as  $key=>$report)                   
                      <tr>
                          <td>{{ $report->products_id }}</td>  
                          <td>{{ $report->products_name . ' - ' . $report->products_weight . ' ' . $report->products_weight_unit }}</td>  
                          <td>{{ $report->min_level }}</td>    
                          <td>{{ $report->stocks }}</td>    
                                                                                              
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                
                @if($products)
                <div class="col-xs-12 text-right">
                    {{$products->links()}}
                </div>
                @endif

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
