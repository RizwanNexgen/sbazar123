
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?php echo e(trans('labels.Min Stock Report')); ?> <small><?php echo e(trans('labels.Min Stock Report')); ?>...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
      <li class="active"><?php echo e(trans('labels.Min Stock Report')); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><?php echo e(trans('labels.Min Stock Report')); ?> </h3>

            <div class="box-tools pull-right">
              <form action="<?php echo e(URL::to('admin/minstockprint')); ?>" target="_blank">
                <input type="hidden" name="page" value="invioce">
                <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> <?php echo e(trans('labels.Print')); ?></button>
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
                      <th><?php echo e(trans('labels.ProductID')); ?></th>
                      <th><?php echo e(trans('labels.ProductName')); ?></th>
                      <th><?php echo e(trans('labels.Min Level')); ?></th>
                      <th><?php echo e(trans('labels.Current Stock')); ?></th>
                      
                    </tr>
                  </thead>
                   <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                   
                      <tr>
                          <td><?php echo e($report->products_id); ?></td>  
                          <td><?php echo e($report->products_name . ' - ' . $report->products_weight . ' ' . $report->products_weight_unit); ?></td>  
                          <td><?php echo e($report->min_level); ?></td>    
                          <td><?php echo e($report->stocks); ?></td>    
                                                                                              
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
                
                <?php if($products): ?>
                <div class="col-xs-12 text-right">
                    <?php echo e($products->links()); ?>

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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/reports/minstock.blade.php ENDPATH**/ ?>