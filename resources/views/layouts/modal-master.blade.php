<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> @yield("modal_title")</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        @yield("modal_content")
    </div>
    <div class="modal-footer">
        @yield("modal_footer")
    </div>
</div>
@stack('js')