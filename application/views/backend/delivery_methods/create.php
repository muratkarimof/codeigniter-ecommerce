<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid pt-3">
            <?php
            errorAlert();
            successAlert();
            ?>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?=$title?></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="<?= base_url('backend/delivery/create'); ?>" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tittle</label>
                            <input type="text" name="title" class="form-control">
                            <?php echo form_error('title', '<span class =text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="title">Order</label>
                            <input type="number" name="order" class="form-control" min="0">
                            <?php echo form_error('order', '<span class =text-danger >','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <br>
                            <select class="custom-select form-control" id="Status" name="status">
                                <option value="0">Non-Active</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>