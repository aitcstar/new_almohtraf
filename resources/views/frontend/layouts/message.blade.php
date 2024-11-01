<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
@if (count($errors->all()) > 0)
@foreach ($errors->all() as $error)
<div class="row">
    <div class="col-12">
        <div class="alertPart">
    <div class="alert alert-danger alert-common" role="alert">{{$error}}</div>
</div>
</div>
</div>
@endforeach
@endif
@if (session()->has('success'))
<div class="row">
    <div class="col-12">
        <div class="alertPart">
            <div class="alert alert-success alert-common" role="alert">{{session('success')}}</div>
        </div>
</div>
</div>

@endif
@if (session()->has('error'))
<div class="row">
    <div class="col-12">
        <div class="alertPart">
            <div class="alert alert-danger alert-common" role="alert">{{session('error')}}</div>
        </div>
</div>
</div>

@endif
<script>
$(document).on('click','#x',function(){
        $(".rounded-md").hide();
});
</script>
