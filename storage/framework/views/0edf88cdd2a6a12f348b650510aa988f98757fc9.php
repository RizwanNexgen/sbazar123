
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Splash Screen
                <small>Listing the Splash Screens for app...</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo e(URL::to('admin/dashboard/this_month')); ?>"><i
                                class="fa fa-dashboard"></i> <?php echo e(trans('labels.breadcrumb_dashboard')); ?></a></li>
                <li class="active">Splash Screen</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs"> </ul>
                                        <form method="POST" action="<?php echo e(url('admin/homebanners/store_splash_screen')); ?>" class="form-horizontal" enctype='multipart/form-data'>
                                        <?php echo csrf_field(); ?>
                                        <div class="">
                                            <div class="row">
                                                <div class="col-xs-12">

                                                    <table class="table">
                                                        <tr>
                                                            <td style="text-align: end; vertical-align: middle;">
                                                               <div >
                                                                   First Screen
                                                                   <input type="file" name="first" style="display: inline-block">
                                                               </div>
                                                            </td>

                                                            <td style="text-align: start; vertical-align: middle; ">
                                                               
                                                                <?php if($result['first']->type == 'VIDEO'): ?>
                                                                <video width="320" height="240" controls>
                                                                      <source src="<?php echo e($result['first']->url); ?>" type="video/mp4">
                                                                
                                                                </video>
                                                                <?php else: ?>
                                                                <img src="<?php echo e($result['first']->url); ?>" alt="" width=" 100px">
                                                                <?php endif; ?>
                                                                    
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: end; vertical-align: middle;">
                                                                <div >
                                                                    Second Screen
                                                                    <input type="file" name="second" style="display: inline-block">
                                                                </div>
                                                            </td>

                                                            <td style="text-align: start; vertical-align: middle; ">
                                                                <?php if(!empty($result['second'])): ?>
                                                                    <img src="<?php echo e($result['second']->url); ?>" alt="" width=" 100px">
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: end; vertical-align: middle;">
                                                                <div >
                                                                    Third Screen
                                                                    <input type="file" name="third" style="display: inline-block">
                                                                </div>
                                                            </td>

                                                            <td style="text-align: start; vertical-align: middle; ">
                                                                <?php if(!empty($result['third'])): ?>
                                                                    <img src="<?php echo e($result['third']->url); ?>" alt="" width=" 100px">
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: end; vertical-align: middle;">
                                                                <div >
                                                                    Fourth Screen
                                                                    <input type="file" name="fourth" style="display: inline-block">
                                                                </div>
                                                            </td>

                                                            <td style="text-align: start; vertical-align: middle; ">
                                                                <?php if(!empty($result['fourth'])): ?>
                                                                    <img src="<?php echo e($result['fourth']->url); ?>" alt="" width=" 100px">
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: end; vertical-align: middle;">
                                                                <div >
                                                                    Fifth Screen
                                                                    <input type="file" name="fifth" style="display: inline-block">
                                                                </div>
                                                            </td>

                                                            <td style="text-align: start; vertical-align: middle; ">
                                                                <?php if(!empty($result['fifth'])): ?>
                                                                    <img src="<?php echo e($result['fifth']->url); ?>" alt="" width=" 100px">
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </table>


                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary pull-right" id="normal-btn"><?php echo e(trans('labels.Submit')); ?></button>
                                    </div>
                                    </form>
                                    <!-- /.tab-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
    <script src="<?php echo asset('admin/plugins/jQuery/jQuery-2.2.0.min.js'); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pidesqfm/square.pidetutransporte.com/resources/views/admin/app_menus/splash_screen.blade.php ENDPATH**/ ?>