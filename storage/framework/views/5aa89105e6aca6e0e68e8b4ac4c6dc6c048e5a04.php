<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> <?php echo e(trans('labels.Hotcat')); ?> <small><?php echo e(trans('labels.ListingAllHotcats')); ?>...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
                <li class=" active"><?php echo e(trans('labels.Hotcat')); ?></li>
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
                                                <form name='filter' id="registration" class="filter  " method="get" action="<?php echo e(url('admin/hotcats/filter')); ?>">
                                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                                    <div class="input-group-form search-panel ">
                                                      <select type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" name="FilterBy" id="FilterBy" >
                                                        <option value="" selected disabled hidden><?php echo e(trans('labels.Filter By')); ?></option>
                                                        <option value="Name" <?php if(isset($name)): ?> <?php if($name == "Name"): ?> <?php echo e('selected'); ?> <?php endif; ?> <?php endif; ?>><?php echo e(trans('labels.Name')); ?></option>
                                                        <option value="URL" <?php if(isset($name)): ?> <?php if($name == "URL"): ?> <?php echo e('selected'); ?> <?php endif; ?> <?php endif; ?>><?php echo e(trans('labels.URL')); ?></option>
                                                      </select>
                                                      <input type="text" class="form-control input-group-form " name="parameter" placeholder="<?php echo e(trans('labels.Search')); ?>..." id="parameter" <?php if(isset($param)): ?> value="<?php echo e($param); ?>" <?php endif; ?>>
                                                      <button class="btn btn-primary " type="submit" id="submit"><span class="glyphicon glyphicon-search"></span></button>
                                                      <?php if(isset($param,$name)): ?>  <a class="btn btn-danger " href="<?php echo e(URL::to('admin/hotcats/display')); ?>"><i class="fa fa-ban" aria-hidden="true"></i> </a><?php endif; ?>
                                                    </div>
                                                </form>
                                                <div class="col-lg-4 form-inline" id="contact-form12"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="box-tools pull-right">
                                <a href="<?php echo e(URL::to('admin/hotcats/add')); ?>" type="button" class="btn btn-block btn-primary"><?php echo e(trans('labels.AddNew')); ?></a>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php if(count($errors) > 0): ?>
                                        <?php if($errors->any()): ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <?php echo e($errors->first()); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('hotcats_id', trans('labels.ID')));?></th>
                                            <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('hotcat_name', trans('labels.Name')));?></th>
                                            <th>Color Code</th>
                                            <th>Logo</th>
                                            <th>Number of Products</th>
                                            <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('hotcats_status', trans('labels.Status')));?></th>
                                            <th><?php echo e(trans('labels.Action')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($hotcats)>0): ?>
                                            <?php $__currentLoopData = $hotcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$hotcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($hotcat->id); ?></td>
                                                    <td><?php echo e($hotcat->name); ?></td>
                                                    <td><?php echo e($hotcat->color_code); ?></td>
                                                    <td><img src="<?php echo e(asset($hotcat->path)); ?>" alt="" width=" 100px"></td>
                                                    <td><?php echo e($hotcat->total_products); ?></td>
                                                    <td>
                                                          <?php if($hotcat->status==1): ?>
                                                          <span class="label label-success">
                                                            <?php echo e(trans('labels.Active')); ?>

                                                          </span>
                                                          <?php elseif($hotcat->status==0): ?>
                                                          <span class="label label-danger">
                                                              <?php echo e(trans('labels.InActive')); ?>

                                                          <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="<?php echo e(URL::to('admin/hotcats/edit/'.$hotcat->id)); ?>" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a id="hotcatFrom" hotcats_id='<?php echo e($hotcat->id); ?>' data-toggle="tooltip" data-placement="bottom" title="Delete" data-href="<?php echo e(url('admin/hotcats/delete')); ?>" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5"><?php echo e(trans('labels.NoRecordFound')); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <?php if($hotcats != null): ?>
                                    <div class="col-xs-12 text-right">
                                        <?php echo e($hotcats->links()); ?>

                                    </div>
                                    <?php endif; ?>
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
                        <?php echo Form::open(array('url' =>'admin/hotcats/delete', 'name'=>'deleteHotcat', 'id'=>'deleteHotcat', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')); ?>

                        <?php echo Form::hidden('action',  'delete', array('class'=>'form-control')); ?>

                        <?php echo Form::hidden('hotcats_id',  '', array('class'=>'form-control', 'id'=>'hotcats_id')); ?>

                        <div class="modal-body">
                            <p>Are you sure you want to delete this hotcat?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('labels.Close')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(trans('labels.Delete')); ?></button>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/app/current/resources/views/admin/hotcats/index.blade.php ENDPATH**/ ?>