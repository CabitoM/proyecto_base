@extends("layouts.modal-master")
@section("modal_title")
Ver usuario
@endsection
@section("modal_content")
<div class="row">
    <div class="col-lg-12">
        <form action=""><label for=""> loquesea </label>
            <input id="input_prueba" type="text">
        </form>
    </div>
</div>
@endsection
@section("modal_footer")
<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-secondary">Save changes</button>
@endsection
@push("js")
<script>
    
</script>
@endpush