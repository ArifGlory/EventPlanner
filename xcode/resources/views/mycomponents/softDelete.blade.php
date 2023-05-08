@if(useSoftDelete()==true)
    @role('superadmin')
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" checked name="tampilkan" id="inlineRadio1" value="nontrashed"
               onchange="reloadTable();">
        <label class="form-check-label" for="inlineRadio1">Data</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="tampilkan" id="inlineRadio2" value="trashed"
               onchange="reloadTable();">
        <label class="form-check-label" for="inlineRadio2">Terhapus</label>
    </div>
    @endrole
@endif
