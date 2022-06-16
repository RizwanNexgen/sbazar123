
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><?php echo e(trans('labels.Customer Report')); ?> <small><?php echo e(trans('labels.Customer Report')); ?>...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.Customer Report')); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->

    <!-- /.row -->

    <div class="row">
        <!-- Left col -->
        <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo e(trans('labels.Filter')); ?></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body no-padding">
              <form  name='registration' method="get" action="<?php echo e(url('admin/customers-orders-report')); ?>">
              <input type="hidden" name="type" value="all">
              <div class="box-body">
                <div class="col-xs-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php echo e(trans('labels.Choose start and end date')); ?></label>
                    <input class="form-control reservation dateRange" placeholder="<?php echo e(trans('labels.Choose start and end date')); ?>" readonly value="<?php echo e(app('request')->input('dateRange')); ?>" name="dateRange" aria-label="Text input with multiple buttons ">
                  </div>
                </div>
                <div class="col-xs-3">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php echo e(trans('labels.Choose Customer')); ?></label>
                    <select type="button" class="btn btn-default select2 form-control" required data-toggle="dropdown" name="customers_id" id="customers_id"  >
                        <option value=""><?php echo e(trans('labels.Choose Customer')); ?></option>
                        <?php $__currentLoopData = $result['customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customers->id); ?>"  <?php if( app('request')->input('customers_id')): ?> <?php if(app('request')->input('customers_id') == $customers->id): ?> <?php echo e('selected'); ?> <?php endif; ?> <?php endif; ?>><?php echo e($customers->first_name); ?> <?php echo e($customers->last_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </div>
                <!-- <div class="col-xs-2">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php echo e(trans('labels.currency')); ?></label>
                    <select type="button" class="btn btn-default select2 form-control" data-toggle="dropdown" name="currency" id="currency">
                        <?php $__currentLoopData = $result['currency']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($currency->symbol_left ? $currency->symbol_left : $currency->symbol_right); ?>"  <?php if( app('request')->input('currency')): ?> <?php if(app('request')->input('currency') == $currency->symbol_right || app('request')->input('currency') == $currency->symbol_left): ?> <?php echo e('selected'); ?> <?php endif; ?> <?php endif; ?>><?php echo e($currency->symbol_left ? $currency->symbol_left : $currency->symbol_right); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </div>             -->
                <div class="col-xs-2" style="padding-top: 25px">                  
                  <div class="form-group">
                    <button class="btn btn-primary" id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    <?php if(app('request')->input('type') and app('request')->input('type') == 'all'): ?>  <a class="btn btn-danger " href="<?php echo e(url('admin/customers-orders-report')); ?>"><i class="fa fa-ban" aria-hidden="true"></i> </a><?php endif; ?>
                  </div>
                </div>       
            </div>
              <!-- /.box-body -->

            </form>  
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
                <div class="col-lg-9 form-inline" id="contact-form">
                    
                    <form method="get" action="<?php echo e(url('admin/customers-orders-report')); ?>">
                        <input type="hidden" name="type"  value="id">
                        <input type="hidden"  value="<?php echo e(csrf_token()); ?>">
                        <div class="input-group-form search-panel ">
                            <input class="form-control" placeholder="<?php echo e(trans('labels.Please enter order ID')); ?>" value="<?php echo e(app('request')->input('orderid')); ?>" name="orderid" aria-label="Text input with multiple buttons ">
                                                     
                            <button class="btn btn-primary " id="submit" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            <?php if(app('request')->input('type') and app('request')->input('type') == 'id'): ?>   <a class="btn btn-danger " href="<?php echo e(url('admin/customers-orders-report')); ?>"><i class="fa fa-ban" aria-hidden="true"></i> </a><?php endif; ?>
                        </div>
                    </form>

                  </div>
                  <div class="box-tools pull-right">
                    <form action="<?php echo e(URL::to('admin/customer-orders-print')); ?>" target="_blank">
                      <input type="hidden" name="page" value="invioce">
                      <input type="hidden" name="customers_id" value="<?php echo e(app('request')->input('customers_id')); ?>">
                      <input type="hidden" name="orders_status_id" value="<?php echo e(app('request')->input('orders_status_id')); ?>">
                      <input type="hidden" name="dateRange" value="<?php echo e(app('request')->input('dateRange')); ?>">
                      <input type="hidden" name="orderid" value="<?php echo e(app('request')->input('orderid')); ?>">
                      <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> <?php echo e(trans('labels.Print')); ?></button>
                    </form>
                  </div>
                </div>
                

          <!-- /.box-header -->
          <div class="box-body">

            <div class="row">
              <div class="col-xs-12">
              <?php $totalSale = 0; ?>
              <div class="box-tools pull-right">
                 <!-- <h2><small><?php echo e(trans('labels.Total Sale Price')); ?>:</small><?php if( $result['commonContent']['currency']->symbol_left == app('request')->input('currency') ): ?> <?php echo e(app('request')->input('currency')); ?> <?php endif; ?> <?php echo e($result['price']); ?> <?php if($result['commonContent']['currency']->symbol_left != app('request')->input('currency') ): ?> <?php echo e(app('request')->input('currency')); ?> <?php endif; ?> </h2> -->
                 <h2><small><?php echo e(trans('labels.Total Sale Price')); ?>:</small>$ <?php echo e($result['price']); ?> </h2>
              </div>

              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th><?php echo e(trans('labels.ID')); ?></th>
                      <th><?php echo e(trans('labels.CustomerName')); ?></th>
                      <th><?php echo e(trans('labels.Order Source')); ?></th>
                      <th><?php echo e(trans('labels.OrderTotal')); ?></th>
                      <th><?php echo e(trans('labels.DatePurchased')); ?></th>
                      <th><?php echo e(trans('labels.Status')); ?> </th>
                      <th><?php echo e(trans('labels.Action')); ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if(count($result['reports']['orders']) > 0): ?>
                    <?php $__currentLoopData = $result['reports']['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$orderData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($orderData->orders_id); ?></td>
                        <td><?php echo e($orderData->customers_name); ?></td>
                        <td>
                            <?php if($orderData->ordered_source == 1): ?>
                            <?php echo e(trans('labels.Website')); ?>

                            <?php else: ?>
                            <?php echo e(trans('labels.Application')); ?>

                            <?php endif; ?></td>
                        <td>
                            <?php if( $result['commonContent']['currency']->symbol_left == app('request')->input('currency') ): ?> <?php echo e(app('request')->input('currency')); ?> <?php endif; ?> <?php echo e($orderData->order_price); ?> <?php if($result['commonContent']['currency']->symbol_left != app('request')->input('currency') ): ?> <?php echo e(app('request')->input('currency')); ?> <?php endif; ?></td>
                        <td><?php echo e(date('d/m/Y', strtotime($orderData->date_purchased))); ?></td>
                        <td>
                            <?php if($orderData->orders_status_id==1): ?>
                                <span class="label label-warning">
                            <?php elseif($orderData->orders_status_id==2): ?>
                                <span class="label label-success">
                            <?php elseif($orderData->orders_status_id==3): ?>
                                <span class="label label-danger">
                            <?php else: ?>
                                <span class="label label-primary">
                            <?php endif; ?>
                            <?php echo e($orderData->orders_status); ?>

                                </span>
                        </td>
                       
                        <td>
                            <a data-toggle="tooltip" target="_blank" data-placement="bottom" title="<?php echo e(trans('labels.View Invoice')); ?>" href="<?php echo e(url('admin/orders/invoiceprint/'.$orderData->orders_id)); ?>" class="badge bg-light-blue"><i class="fa fa-eye" aria-hidden="true"></i><?php echo e(trans('labels.View Invoice')); ?></a>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  	<tr>
                    	<td colspan="6"><strong><?php echo e(trans('labels.NoRecordFound')); ?></strong></td>
                    </tr>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <div class="col-xs-12" style="background: #eee;">
              <?php if(count($result['reports']['orders']) > 0): ?>
                  <?php
                 
                    if($result['reports']['orders']->total() > 0){
                      $fromrecord = ($result['reports']['orders']->currentpage()-1)*$result['reports']['orders']->perpage()+1;
                    }else{
                      $fromrecord = 0;
                    }
                    if($result['reports']['orders']->total() < $result['reports']['orders']->currentpage()*$result['reports']['orders']->perpage()){
                      $torecord = $result['reports']['orders']->total();
                    }else{
                      $torecord = $result['reports']['orders']->currentpage()*$result['reports']['orders']->perpage();
                    }

                  ?>
                  <div class="col-xs-12 col-md-6" style="padding:30px 15px; border-radius:5px;">
                    <div>Showing <?php echo e($fromrecord); ?> to <?php echo e($torecord); ?>

                        of  <?php echo e($result['reports']['orders']->total()); ?> entries
                    </div>
                  </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <?php echo e($result['reports']['orders']->appends(\Request::except('type'))->render()); ?>

                </div>
              <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/reports/statsCustomers.blade.php ENDPATH**/ ?>