@if(count($list)>0)
    <div class="row">
        <div class="col-lg-12">
            <div class="timeline ms-2">
                <!-- timeline time label -->
                <div class="time-label">
                    <span class="bg-red">Data Log</span>
                </div>
                <!-- /.timeline-label -->
                @foreach($list as $x)
                    <!-- timeline item -->
                    <div>
                        <i class="fas fa-clock bg-green"></i>
                        <div class="timeline-item">
                            <span class="time"><i
                                    class="fas fa-clock"></i> {{SelisihTanggal($x->created_at)}}</span>
                            <h3 class="timeline-header no-border">{{change_event_name($x->description)}}</h3>
                        </div>
                    </div>
                    <!-- END timeline item -->
                @endforeach
            </div>
        </div>
        <div class="col-lg-12">
            <div class="d-flex justify-content-center">
                {{ $list->links() }}
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-lg-12">
            @include('mycomponents.nulldata')
        </div>
    </div>
@endif


