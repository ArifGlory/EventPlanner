<!-- Add Impor Modal -->
<div class="modal fade" id="modal_impor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-header">
                <h4 class="modal-title">Impor Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_impor" name="form_impor" class="row" method="post" enctype="multipart/form-data"
                      action="javascript:imporfunction();">
                    <div class="col-12 mb-3">
                        <div class="custom-file">
                            <input id="file"
                                   class="custom-file-input"
                                   type="file" name="file"
                                   accept=".xlsx, .xls, .csv">
                            <label class="custom-file-label"
                                   for="file">PILIH</label>
                        </div>
                        <p style="color: red" id="error_file">
                        </p>
                    </div>
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-info me-sm-3 me-1" id="btnimpor"><i class="fa fa-file-import"></i> Impor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Impor Modal -->
