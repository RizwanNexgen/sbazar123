
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            <small><?php echo e(trans('labels.title_dashboard')); ?> <?php echo e($result['commonContent']['setting']['admin_version']); ?></small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></li>
            </ol>
        </section>
       
        <!-- Main content -->
        <section class="content">
            <?php if( $result['commonContent']['roles'] != null and $result['commonContent']['roles']->dashboard_view == 1): ?>
            
                <div class="row">
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3><?php echo e($result['totalCustomers']); ?></h3>

                      <p><?php echo e(trans('labels.customerRegistrations')); ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo e(URL::to('admin/customers/display')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllCustomers')); ?>"><?php echo e(trans('labels.viewAllCustomers')); ?>  <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3><?php echo e($result['totalProducts']); ?></h3>

                      <p><?php echo e(trans('labels.totalProducts')); ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="<?php echo e(URL::to('admin/products/display')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllProducts')); ?>"><?php echo e(trans('labels.viewAllProducts')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                      
                        
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a href="<?php echo e(URL::to('admin/orders/display')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllOrders')); ?>"><?php echo e(trans('labels.viewAllOrders')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                <!-- ./col -->

              </div>
              <div class="row">
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      
        			        <p><?php echo e(trans('labels.NewOrders')); ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?php echo e(URL::to('admin/orders/display')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.NewOrders')); ?>"><?php echo e(trans('labels.NewOrders')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-teal">
                    <div class="inner">
                      <h3>
                      <b><?php if(0): ?> > 0)
                            <?php $__currentLoopData = $result['total_sales_currency_wise']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sales): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                $ <?php echo e(number_format($sales->sale,2)); ?> 
                               
                                <?php if($key !== count($result['total_sales_currency_wise'])): ?>
                                    <br />
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php else: ?>
                        0
                      <?php endif; ?>
                      </b>
                      </h3>
                        <p><?php echo e(trans('labels.Total Money Earned')); ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?php echo e(URL::to('admin/orders/display')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllOrders')); ?>"><?php echo e(trans('labels.viewAllOrders')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <!-- ./col -->
                <?php if($result['commonContent']['setting']['Inventory'] == '1'): ?>
                <div class="col-lg-4 col-xs-6">

                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3><?php echo e($result['outOfStock']); ?> </h3>
                      <p><?php echo e(trans('labels.outOfStock')); ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="<?php echo e(URL::to('admin/outofstock')); ?>" class="small-box-footer" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.outOfStock')); ?>"><?php echo e(trans('labels.outOfStock')); ?> <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                <?php endif; ?>
                <!-- ./col -->
                </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <div class="box-header with-border">
                            <h3 class="box-title"> <?php echo e(trans('labels.addedSaleReport')); ?></h3>
                            <div class="box-tools pull-right">
                                <p class="notify-colors"><span class="sold-content" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.totalsales')); ?>"></span> <?php echo e(trans('labels.totalsales')); ?>  <span class="purchased-content" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.totalcustomers')); ?>"></span><?php echo e(trans('labels.totalcustomers')); ?> </p>
                            </div>
                        </div>
                        <?php echo Form::hidden('reportBase',  $result['reportBase'] , array('id'=>'reportBase')); ?>

                        <ul class="nav nav-tabs">
                            <li class="<?php echo e(Request::is('admin/dashboard/last_year') ? 'active' : ''); ?>"><a href="<?php echo e(url('admin/dashboard/last_year')); ?>"><?php echo e(trans('labels.lastYear')); ?></a></li>
                            <li class="<?php echo e(Request::is('admin/dashboard/last_month') ? 'active' : ''); ?>"><a href="<?php echo e(url('admin/dashboard/last_month')); ?>"><?php echo e(trans('labels.LastMonth')); ?></a></li>
                            <li class="<?php echo e(Request::is('admin/dashboard/this_month') ? 'active' : ''); ?>"><a href="<?php echo e(url('admin/dashboard/this_month')); ?>"><?php echo e(trans('labels.thisMonth')); ?></a></li>
                            <li style="width: 33%"><a href="#" data-toggle="tab">
                                    <div class="input-group ">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default" aria-label="Help"><?php echo e(trans('labels.custom')); ?></button>
                                        </div>
                                        <input class="form-control reservation dateRange" readonly value="" name="dateRange" aria-label="Text input with multiple buttons ">
                                        <div class="input-group-btn"><button type="button" class="btn btn-primary getRange" ><?php echo e(trans('labels.go')); ?></button> </div>
                                    </div>
                                </a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                <div class="chart">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="salesChart" style="height: 400px;"></canvas>
                                </div>
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <div class="col-md-12" style="display: none">
                    <div class="box">
                        <div class="box-header with-border">
                            <!--<h3 class="box-title pull-left">Monthly Report</h3>-->

                            <div class="col-xs-12 col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" aria-label="Help"><?php echo e(trans('labels.customDate')); ?></button>
                                    </div>
                                    <input class="form-control" aria-label="Text input with multiple buttons">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary"><?php echo e(trans('labels.go')); ?></button>
                                    </div>
                                </div>
                            </div>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                        <strong><?php echo e(trans('labels.sales')); ?>: 1 Jan, 2014 - 30 Jul, 2014</strong>
                                    </p>

                                    <div class="chart">
                                        <!-- Sales Chart Canvas -->
                                        <canvas id="salesChart" style="height: 400px;"></canvas>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->

                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <div class="box-footer" style="display: none">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                                        <h5 class="description-header">$35,210.43</h5>
                                        <span class="description-text"><?php echo e(trans('labels.total_revenue')); ?></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                                        <h5 class="description-header">$10,390.90</h5>
                                        <span class="description-text"><?php echo e(trans('labels.total_cost')); ?></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block border-right">
                                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                                        <h5 class="description-header">$24,813.53</h5>
                                        <span class="description-text"><?php echo e(trans('labels.total_profit')); ?></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-xs-6">
                                    <div class="description-block">
                                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                                        <h5 class="description-header">1200</h5>
                                        <span class="description-text"><?php echo e(trans('labels.goal_completions')); ?></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->

                    <!-- /.box -->
                    <div class="row">
                        <!-- /.col -->

                        <div class="col-md-12">
                            <!-- USERS LIST -->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo e(trans('labels.latest_customers')); ?></h3>

                                    <div class="box-tools pull-right">
                                        
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <?php if(1): ?>
                                        <ul class="users-list clearfix">
                                            <?php $i = 1; ?>
                                            <?php $__currentLoopData = $result['customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($i<=21): ?>
                                                        <li>
                                                            <img src="<?php echo e(asset('images/user.png')); ?>">
                                                            <a class="users-list-name" href="<?php echo e(url('admin/customers/edit/')); ?>/<?php echo e($customer->id); ?>"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></a>
                                                            <span class="users-list-date"><?php echo e($customer->created_at); ?></span>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php $i++; ?>
                                                
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php else: ?>
                                        <p style="padding: 8px 0 0 10px;"><?php echo e(trans('labels.no_customer_exist')); ?></p>
                                <?php endif; ?>

                                <!-- /.users-list -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="<?php echo e(url('admin/customers/display')); ?>" class="uppercase" data-toggle="tooltip" data-placement="bottom" title="View All Customers"><?php echo e(trans('labels.viewAllCustomers')); ?></a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!--/.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(trans('labels.NewOrders')); ?></h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <!--<a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
                            <a href="<?php echo e(URL::to('admin/orders/display')); ?>" class="btn btn-sm btn-default btn-flat pull-right" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('labels.viewAllOrders')); ?>"><?php echo e(trans('labels.viewOrders')); ?></a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">

                    <!-- PRODUCT LIST -->

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(trans('labels.GoalCompletion')); ?></h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                       
                            
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo e(trans('labels.RecentlyAddedProducts')); ?></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                <?php $__currentLoopData = $result['recentProducts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentProducts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="item">
                                        <div class="product-img">
                                            <img src="<?php echo e(asset('').$recentProducts->products_image); ?>" alt="" width=" 100px" height="100px">
                                        </div>
                                        <div class="product-info">
                                            <a href="<?php echo e(URL::to('admin/products/edit')); ?>/<?php echo e($recentProducts->products_id); ?>" class="product-title"><?php echo e($recentProducts->products_name); ?>

                                                <span class="label label-warning label-succes pull-right">
                                                    <?php if(!empty($result['commonContent']['currency']->symbol_left)): ?> <?php echo e($result['commonContent']['currency']->symbol_left); ?> <?php endif; ?> <?php echo e(floatval($recentProducts->products_price)); ?> <?php if(!empty($result['commonContent']['currency']->symbol_right)): ?> <?php echo e($result['commonContent']['currency']->symbol_right); ?> <?php endif; ?>
                                                    </span></a>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="<?php echo e(URL::to('admin/products/display')); ?>" class="uppercase" data-toggle="tooltip" data-placement="bottom" title="View All Products"><?php echo e(trans('labels.viewAllProducts')); ?></a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <?php endif; ?>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <script src="<?php echo asset('admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>

    <script src="<?php echo asset('admin/dist/js/pages/dashboard2.js'); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pidesqfm/square.pidetutransporte.com/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>